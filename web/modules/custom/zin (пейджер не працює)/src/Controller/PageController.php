<?php

namespace Drupal\zin\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityFormBuilder;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides route responses for the zin module.
 */
class PageController extends ControllerBase {

  /**
   * Construct ZinController.
   *
   * @param \Drupal\Core\Entity\EntityFormBuilder $entityFormBuilder
   *   The entity form builder.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   The entity type manager.
   */
  public function __construct(EntityFormBuilder $entityFormBuilder, EntityTypeManagerInterface $entityTypeManager) {
    $this->entityFormBuilder = $entityFormBuilder;
    $this->entityTypeManager = $entityTypeManager;
  }

  /**
   * {@inheritDoc}
   */
  public static function create(ContainerInterface $container): PageController {
    return new static(
      $container->get('entity.form_builder'),
      $container->get('entity_type.manager')
    );
  }

  /**
   * Builds the response.
   *
   * @return array
   *   Array of answers for the guestbook page.
   *
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   */
  public function build(): array {
    // Creates a new storage instance.
    $storage = $this->entityTypeManager->getStorage('zin_review');
    // Gets an array of forms to reproduce the entity type.
    $form = $this->entityFormBuilder->getForm($storage->create(), 'default');
    // Gets an array of user response records.
    $zin_reviews = $this->getZinReviews();
    // Forming an array to return.
    return [
      '#form' => $form,
      '#theme' => 'review',
      '#zin_review_list' => $zin_reviews,
    ];
  }

  /**
   * Receiving feedback from the database.
   *
   * @return array
   *   Array of user reviews.
   *
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   */
  public function getZinReviews(): array {
    // Creates a new storage instance.
    $storage = $this->entityTypeManager->getStorage('zin_review');
    // Send a query to the database.
    $query = $storage->getQuery()
      ->sort('created', 'DESC')
      ->pager(5)
      ->execute();
    // Loads one or more entities.
    $zin_reviews = $storage->loadMultiple($query);
    // Creates a new view builder instance for array.
    $zin_reviews = $this->entityTypeManager
      ->getViewBuilder('zin_review')
      ->viewMultiple($zin_reviews);
    // Forming an array to return.
    return [
      '#theme' => 'zin_review_list',
      '#zin_reviews' => $zin_reviews,
      '#pager' => [
        '#type' => 'pager',
      ],
    ];
  }

}