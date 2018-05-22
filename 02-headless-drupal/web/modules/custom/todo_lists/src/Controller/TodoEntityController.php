<?php

namespace Drupal\todo_lists\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\todo_lists\Entity\TodoEntityInterface;

/**
 * Class TodoEntityController.
 *
 *  Returns responses for Todo entity routes.
 */
class TodoEntityController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Todo entity  revision.
   *
   * @param int $todo_entity_revision
   *   The Todo entity  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($todo_entity_revision) {
    $todo_entity = $this->entityManager()->getStorage('todo_entity')->loadRevision($todo_entity_revision);
    $view_builder = $this->entityManager()->getViewBuilder('todo_entity');

    return $view_builder->view($todo_entity);
  }

  /**
   * Page title callback for a Todo entity  revision.
   *
   * @param int $todo_entity_revision
   *   The Todo entity  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($todo_entity_revision) {
    $todo_entity = $this->entityManager()->getStorage('todo_entity')->loadRevision($todo_entity_revision);
    return $this->t('Revision of %title from %date', ['%title' => $todo_entity->label(), '%date' => format_date($todo_entity->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Todo entity .
   *
   * @param \Drupal\todo_lists\Entity\TodoEntityInterface $todo_entity
   *   A Todo entity  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(TodoEntityInterface $todo_entity) {
    $account = $this->currentUser();
    $langcode = $todo_entity->language()->getId();
    $langname = $todo_entity->language()->getName();
    $languages = $todo_entity->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $todo_entity_storage = $this->entityManager()->getStorage('todo_entity');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $todo_entity->label()]) : $this->t('Revisions for %title', ['%title' => $todo_entity->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all todo entity revisions") || $account->hasPermission('administer todo entity entities')));
    $delete_permission = (($account->hasPermission("delete all todo entity revisions") || $account->hasPermission('administer todo entity entities')));

    $rows = [];

    $vids = $todo_entity_storage->revisionIds($todo_entity);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\todo_lists\TodoEntityInterface $revision */
      $revision = $todo_entity_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $todo_entity->getRevisionId()) {
          $link = $this->l($date, new Url('entity.todo_entity.revision', ['todo_entity' => $todo_entity->id(), 'todo_entity_revision' => $vid]));
        }
        else {
          $link = $todo_entity->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => \Drupal::service('renderer')->renderPlain($username),
              'message' => ['#markup' => $revision->getRevisionLogMessage(), '#allowed_tags' => Xss::getHtmlTagList()],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => Url::fromRoute('entity.todo_entity.revision_revert', ['todo_entity' => $todo_entity->id(), 'todo_entity_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.todo_entity.revision_delete', ['todo_entity' => $todo_entity->id(), 'todo_entity_revision' => $vid]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['todo_entity_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
