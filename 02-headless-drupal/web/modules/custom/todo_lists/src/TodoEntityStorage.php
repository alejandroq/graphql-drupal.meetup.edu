<?php

namespace Drupal\todo_lists;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\todo_lists\Entity\TodoEntityInterface;

/**
 * Defines the storage handler class for Todo entity entities.
 *
 * This extends the base storage class, adding required special handling for
 * Todo entity entities.
 *
 * @ingroup todo_lists
 */
class TodoEntityStorage extends SqlContentEntityStorage implements TodoEntityStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(TodoEntityInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {todo_entity_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {todo_entity_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(TodoEntityInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {todo_entity_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('todo_entity_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
