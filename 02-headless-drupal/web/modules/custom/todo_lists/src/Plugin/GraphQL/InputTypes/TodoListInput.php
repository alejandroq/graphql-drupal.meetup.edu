<?php

namespace Drupal\todo_lists\Plugin\GraphQL\InputTypes;

use Drupal\graphql\Plugin\GraphQL\InputTypes\InputTypePluginBase;

/**
 * The input type for article mutations.
 *
 * @GraphQLInputType(
 *   id = "todo_list_input",
 *   name = "TodoListInput",
 *   fields = {
 *     "name" = "String",
 *     "state" = "String",
 *   }
 * )
 */
class TodoListInput extends InputTypePluginBase {

}
