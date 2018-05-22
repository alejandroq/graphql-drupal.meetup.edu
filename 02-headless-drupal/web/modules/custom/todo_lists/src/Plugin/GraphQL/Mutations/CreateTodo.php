<?php

namespace Drupal\todo_lists\Plugin\GraphQL\Mutations;

use Drupal\graphql_core\Plugin\GraphQL\Mutations\Entity\CreateEntityBase;
use Drupal\graphql\GraphQL\Execution\ResolveContext;
use Drupal\todo_lists\Entity\TodoEntity;
use Drupal\todo_lists\Entity\TodoListEntity;
use GraphQL\Type\Definition\ResolveInfo;

/**
 * Simple mutation for creating a new article node.
 *
 * @GraphQLMutation(
 *   id = "create_todo",
 *   entity_type = "todo_entity",
 *   entity_bundle = "todo_entity",
 *   secure = true,
 *   name = "createTodo",
 *   type = "EntityCrudOutput!",
 *   arguments = {
 *      "input" = "TodoInput"
 *   }
 * )
 */
class CreateTodo extends CreateEntityBase {

  /**
   * {@inheritdoc}
   */
  protected function extractEntityInput($value, array $args, ResolveContext $context, ResolveInfo $info) {
    // TODO not the opitmal way to do this (but need to explore if I made a mistake with entity_reference
    $lid = TodoListEntity::load($args['input']['lid']);
    $val = [
      'lid' => $args['input']['lid'],
      'content' => $args['input']['content'],
    ];
    TodoEntity::create($val)->save();
    return $val;
  }

}
