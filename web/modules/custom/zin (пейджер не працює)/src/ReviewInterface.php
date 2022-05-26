<?php

namespace Drupal\zin;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\user\EntityOwnerInterface;
use Drupal\Core\Entity\EntityChangedInterface;

/**
 * Provides an interface defining a Review entity.
 *
 * We have this interface so we can join the other interfaces it extends.
 *
 * @ingroup zin
 */
interface ReviewInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
