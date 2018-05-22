<?php

namespace Drupal\todo_lists\Plugin\GraphQL\Mutations;

use Drupal\graphql_core\Plugin\GraphQL\Mutations\Entity\CreateEntityBase;
use Drupal\graphql\GraphQL\Execution\ResolveContext;
use GraphQL\Type\Definition\ResolveInfo;

/**
 * Simple mutation for creating a new article node.
 *
 * @GraphQLMutation(
 *   id = "create_todo_list",
 *   entity_type = "todo_list_entity",
 *   entity_bundle = "todo_list_entity",
 *   secure = true,
 *   name = "createTodoList",
 *   type = "EntityCrudOutput!",
 *   arguments = {
 *      "input" = "TodoListInput"
 *   }
 * )
 */
class CreateTodoList extends CreateEntityBase {

  /**
   * {@inheritdoc}
   */
  protected function extractEntityInput($value, array $args, ResolveContext $context, ResolveInfo $info) {
    return [
      'name' => $args['input']['name'],
    ];
  }

}
