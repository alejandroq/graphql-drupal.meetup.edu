<?php

namespace Drupal\todo_lists;

use Drupal\Core\Entity\ContentEntityStorageInterface;
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
interface TodoEntityStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Todo entity revision IDs for a specific Todo entity.
   *
   * @param \Drupal\todo_lists\Entity\TodoEntityInterface $entity
   *   The Todo entity entity.
   *
   * @return int[]
   *   Todo entity revision IDs (in ascending order).
   */
  public function revisionIds(TodoEntityInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Todo entity author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Todo entity revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\todo_lists\Entity\TodoEntityInterface $entity
   *   The Todo entity entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(TodoEntityInterface $entity);

  /**
   * Unsets the language for all Todo entity with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
