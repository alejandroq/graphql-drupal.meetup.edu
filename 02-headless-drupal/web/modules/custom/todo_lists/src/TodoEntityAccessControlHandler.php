<?php

namespace Drupal\todo_lists;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Todo entity entity.
 *
 * @see \Drupal\todo_lists\Entity\TodoEntity.
 */
class TodoEntityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\todo_lists\Entity\TodoEntityInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished todo entity entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published todo entity entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit todo entity entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete todo entity entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add todo entity entities');
  }

}
