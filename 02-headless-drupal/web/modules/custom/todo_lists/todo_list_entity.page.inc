<?php

/**
 * @file
 * Contains todo_list_entity.page.inc.
 *
 * Page callback for Todo list entity entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Todo list entity templates.
 *
 * Default template: todo_list_entity.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_todo_list_entity(array &$variables) {
  // Fetch TodoListEntity Entity Object.
  $todo_list_entity = $variables['elements']['#todo_list_entity'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
