<?php

namespace Drupal\todo_lists;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Todo list entity entities.
 *
 * @ingroup todo_lists
 */
class TodoListEntityListBuilder extends EntityListBuilder {


  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Todo list entity ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\todo_lists\Entity\TodoListEntity */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.todo_list_entity.edit_form',
      ['todo_list_entity' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
