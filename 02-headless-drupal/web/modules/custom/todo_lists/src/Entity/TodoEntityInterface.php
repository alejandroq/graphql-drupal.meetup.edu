<?php

namespace Drupal\todo_lists\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Todo entity entities.
 *
 * @ingroup todo_lists
 */
interface TodoEntityInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Todo entity name.
   *
   * @return string
   *   Name of the Todo entity.
   */
  public function getName();

  /**
   * Sets the Todo entity name.
   *
   * @param string $name
   *   The Todo entity name.
   *
   * @return \Drupal\todo_lists\Entity\TodoEntityInterface
   *   The called Todo entity entity.
   */
  public function setName($name);

  /**
   * Gets the Todo entity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Todo entity.
   */
  public function getCreatedTime();

  /**
   * Sets the Todo entity creation timestamp.
   *
   * @param int $timestamp
   *   The Todo entity creation timestamp.
   *
   * @return \Drupal\todo_lists\Entity\TodoEntityInterface
   *   The called Todo entity entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Todo entity published status indicator.
   *
   * Unpublished Todo entity are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Todo entity is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Todo entity.
   *
   * @param bool $published
   *   TRUE to set this Todo entity to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\todo_lists\Entity\TodoEntityInterface
   *   The called Todo entity entity.
   */
  public function setPublished($published);

  /**
   * Gets the Todo entity revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Todo entity revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\todo_lists\Entity\TodoEntityInterface
   *   The called Todo entity entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Todo entity revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Todo entity revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\todo_lists\Entity\TodoEntityInterface
   *   The called Todo entity entity.
   */
  public function setRevisionUserId($uid);

}
