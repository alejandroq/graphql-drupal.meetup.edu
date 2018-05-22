<?php

namespace Drupal\todo_lists;

use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\todo_lists\Entity\TodoListEntityInterface;

/**
 * Defines the storage handler class for Todo list entity entities.
 *
 * This extends the base storage class, adding required special handling for
 * Todo list entity entities.
 *
 * @ingroup todo_lists
 */
interface TodoListEntityStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Todo list entity revision IDs for a specific Todo list entity.
   *
   * @param \Drupal\todo_lists\Entity\TodoListEntityInterface $entity
   *   The Todo list entity entity.
   *
   * @return int[]
   *   Todo list entity revision IDs (in ascending order).
   */
  public function revisionIds(TodoListEntityInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Todo list entity author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Todo list entity revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\todo_lists\Entity\TodoListEntityInterface $entity
   *   The Todo list entity entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(TodoListEntityInterface $entity);

  /**
   * Unsets the language for all Todo list entity with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
