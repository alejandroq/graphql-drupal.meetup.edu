<?php

namespace Drupal\todo_lists\Plugin\GraphQL\Mutations;

use Drupal\graphql_core\Plugin\GraphQL\Mutations\Entity\UpdateEntityBase;
use Drupal\graphql\GraphQL\Execution\ResolveContext;
use GraphQL\Type\Definition\ResolveInfo;

/**
 * Simple mutation for updating an existing article node.
 *
 * @GraphQLMutation(
 *   id = "update_todo_list",
 *   entity_type = "todo_list_entity",
 *   entity_bundle = "todo_list_entity",
 *   secure = true,
 *   name = "updateTodoList",
 *   type = "EntityCrudOutput",
 *   arguments = {
 *      "id" = "String",
 *      "input" = "TodoListInput"
 *   }
 * )
 */
class UpdateTodoList extends UpdateEntityBase {

  /**
   * {@inheritdoc}
   */
  protected function extractEntityInput($value, array $args, ResolveContext $context, ResolveInfo $info) {
    return array_filter([
      'name' => $args['input']['name'],
      'state' => $args['input']['state'],
    ]);
  }
}
