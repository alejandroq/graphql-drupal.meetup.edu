<?php

namespace Drupal\todo_lists\Plugin\GraphQL\InputTypes;

use Drupal\graphql\Plugin\GraphQL\InputTypes\InputTypePluginBase;

/**
 * The input type for article mutations.
 *
 * @GraphQLInputType(
 *   id = "todo_input",
 *   name = "TodoInput",
 *   fields = {
 *     "lid" = "ID",
 *     "state" = "String",
 *     "content" = "String",
 *   }
 * )
 */
class TodoInput extends InputTypePluginBase {

}
