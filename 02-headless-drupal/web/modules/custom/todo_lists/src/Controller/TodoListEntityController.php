<?php

namespace Drupal\todo_lists\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\todo_lists\Entity\TodoListEntityInterface;

/**
 * Class TodoListEntityController.
 *
 *  Returns responses for Todo list entity routes.
 */
class TodoListEntityController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Todo list entity  revision.
   *
   * @param int $todo_list_entity_revision
   *   The Todo list entity  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($todo_list_entity_revision) {
    $todo_list_entity = $this->entityManager()->getStorage('todo_list_entity')->loadRevision($todo_list_entity_revision);
    $view_builder = $this->entityManager()->getViewBuilder('todo_list_entity');

    return $view_builder->view($todo_list_entity);
  }

  /**
   * Page title callback for a Todo list entity  revision.
   *
   * @param int $todo_list_entity_revision
   *   The Todo list entity  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($todo_list_entity_revision) {
    $todo_list_entity = $this->entityManager()->getStorage('todo_list_entity')->loadRevision($todo_list_entity_revision);
    return $this->t('Revision of %title from %date', ['%title' => $todo_list_entity->label(), '%date' => format_date($todo_list_entity->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Todo list entity .
   *
   * @param \Drupal\todo_lists\Entity\TodoListEntityInterface $todo_list_entity
   *   A Todo list entity  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(TodoListEntityInterface $todo_list_entity) {
    $account = $this->currentUser();
    $langcode = $todo_list_entity->language()->getId();
    $langname = $todo_list_entity->language()->getName();
    $languages = $todo_list_entity->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $todo_list_entity_storage = $this->entityManager()->getStorage('todo_list_entity');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $todo_list_entity->label()]) : $this->t('Revisions for %title', ['%title' => $todo_list_entity->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all todo list entity revisions") || $account->hasPermission('administer todo list entity entities')));
    $delete_permission = (($account->hasPermission("delete all todo list entity revisions") || $account->hasPermission('administer todo list entity entities')));

    $rows = [];

    $vids = $todo_list_entity_storage->revisionIds($todo_list_entity);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\todo_lists\TodoListEntityInterface $revision */
      $revision = $todo_list_entity_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $todo_list_entity->getRevisionId()) {
          $link = $this->l($date, new Url('entity.todo_list_entity.revision', ['todo_list_entity' => $todo_list_entity->id(), 'todo_list_entity_revision' => $vid]));
        }
        else {
          $link = $todo_list_entity->link($date);
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
              'url' => Url::fromRoute('entity.todo_list_entity.revision_revert', ['todo_list_entity' => $todo_list_entity->id(), 'todo_list_entity_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.todo_list_entity.revision_delete', ['todo_list_entity' => $todo_list_entity->id(), 'todo_list_entity_revision' => $vid]),
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

    $build['todo_list_entity_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
