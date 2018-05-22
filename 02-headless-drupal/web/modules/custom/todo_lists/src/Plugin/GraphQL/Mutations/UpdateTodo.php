<?php

namespace Drupal\todo_lists\Plugin\GraphQL\Mutations;

use Drupal\graphql_core\Plugin\GraphQL\Mutations\Entity\UpdateEntityBase;
use Drupal\graphql\GraphQL\Execution\ResolveContext;
use Drupal\todo_lists\Entity\TodoEntity;
use GraphQL\Type\Definition\ResolveInfo;

/**
 * Simple mutation for updating an existing article node.
 *
 * @GraphQLMutation(
 *   id = "update_todo",
 *   entity_type = "todo_entity",
 *   entity_bundle = "todo_entity",
 *   secure = true,
 *   name = "updateTodo",
 *   type = "EntityCrudOutput",
 *   arguments = {
 *      "id" = "String",
 *      "input" = "TodoInput"
 *   }
 * )
 */
class UpdateTodo extends UpdateEntityBase {

  /**
   * {@inheritdoc}
   */
  protected function extractEntityInput($value, array $args, ResolveContext $context, ResolveInfo $info) {
    // TODO figure out a more opitmal way to do this. Could it be the entity_reference? Experiment.
    $todo = TodoEntity::load($args['id']);
    $changes = array_filter([
      'state' => $args['input']['state'],
      'content' => $args['input']['content'],
    ]);
    foreach ($changes as $k => $v) {
      $todo->set($k, $v);
    }
    $todo->save();

    // TODO should do the entire job.
    return array_filter([
      'state' => $args['input']['state'],
      'content' => $args['input']['content'],
    ]);
  }
}
