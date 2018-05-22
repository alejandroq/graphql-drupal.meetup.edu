<?php

/**
 * @file
 * Contains todo_entity.page.inc.
 *
 * Page callback for Todo entity entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Todo entity templates.
 *
 * Default template: todo_entity.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_todo_entity(array &$variables) {
  // Fetch TodoEntity Entity Object.
  $todo_entity = $variables['elements']['#todo_entity'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
