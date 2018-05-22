<?php

namespace Drupal\todo_lists;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Todo list entity entity.
 *
 * @see \Drupal\todo_lists\Entity\TodoListEntity.
 */
class TodoListEntityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\todo_lists\Entity\TodoListEntityInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished todo list entity entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published todo list entity entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit todo list entity entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete todo list entity entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add todo list entity entities');
  }

}
