<?php

namespace Drupal\todo_lists\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Todo list entity entities.
 *
 * @ingroup todo_lists
 */
interface TodoListEntityInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Todo list entity name.
   *
   * @return string
   *   Name of the Todo list entity.
   */
  public function getName();

  /**
   * Sets the Todo list entity name.
   *
   * @param string $name
   *   The Todo list entity name.
   *
   * @return \Drupal\todo_lists\Entity\TodoListEntityInterface
   *   The called Todo list entity entity.
   */
  public function setName($name);

  /**
   * Gets the Todo list entity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Todo list entity.
   */
  public function getCreatedTime();

  /**
   * Sets the Todo list entity creation timestamp.
   *
   * @param int $timestamp
   *   The Todo list entity creation timestamp.
   *
   * @return \Drupal\todo_lists\Entity\TodoListEntityInterface
   *   The called Todo list entity entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Todo list entity published status indicator.
   *
   * Unpublished Todo list entity are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Todo list entity is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Todo list entity.
   *
   * @param bool $published
   *   TRUE to set this Todo list entity to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\todo_lists\Entity\TodoListEntityInterface
   *   The called Todo list entity entity.
   */
  public function setPublished($published);

  /**
   * Gets the Todo list entity revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Todo list entity revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\todo_lists\Entity\TodoListEntityInterface
   *   The called Todo list entity entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Todo list entity revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Todo list entity revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\todo_lists\Entity\TodoListEntityInterface
   *   The called Todo list entity entity.
   */
  public function setRevisionUserId($uid);

}
