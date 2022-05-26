<?php

namespace Drupal\zin\Entity\Controller;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Routing\UrlGeneratorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Url;

/**
 * Provides a list controller for zin entity.
 *
 * @ingroup zin
 */
class ReviewListBuilder extends EntityListBuilder {

  /**
   * Entity storage for node entities.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $storage;

  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $currentUser;

  /**
   * The url generator.
   *
   * @var \Drupal\Core\Routing\UrlGeneratorInterface
   */
  protected $urlGenerator;

  /**
   * {@inheritdoc}
   */
  public static function createInstance(ContainerInterface $container, EntityTypeInterface $entity_type) {
    return new static(
      $entity_type,
      $container->get('entity_type.manager')->getStorage($entity_type->id()),
      $container->get('url_generator'),
      $container->get('current_user')
    );
  }

  /**
   * Constructs a new ReviewListBuilder object.
   *
   * @param \Drupal\Core\Entity\EntityTypeInterface $entity_type
   *   The entity type definition.
   * @param \Drupal\Core\Entity\EntityStorageInterface $storage
   *   The entity storage class.
   * @param \Drupal\Core\Routing\UrlGeneratorInterface $url_generator
   *   The url generator.
   * @param \Drupal\Core\Session\AccountInterface $current_user
   *   The current user.
   */
  public function __construct(EntityTypeInterface $entity_type, EntityStorageInterface $storage, UrlGeneratorInterface $url_generator, AccountInterface $current_user) {
    parent::__construct($entity_type, $storage);
    $this->urlGenerator = $url_generator;    
    $this->storage = $storage;
    $this->currentUser = $current_user;
  }

  /**
   * {@inheritdoc}
   *
   * We override ::render() so that we can add our own content above the table.
   * parent::render() is where EntityListBuilder creates the table using our
   * buildHeader() and buildRow() implementations.
   */
  public function render() {
    $build['description'] = [
      '#markup' => $this->t('<div class="text-slogan">Here is what others have said.</div>'),
    ];
    $build['table'] = parent::render();
    $query = $this->storage->getQuery()
    ->sort('created', 'DESC')
    ->addTag('node_access')
    ->pager(5);
    if (!$this->currentUser->hasPermission('bypass node access')) {
      $query->condition('status', 1);
    }
    $entity_ids = $query->execute();
    $nodes = $this->storage->loadMultiple($entity_ids);
    $rows = [];
    foreach ($nodes as $node) {
      $rows[] = [
        'nid' => $node->access('view') ? $node->id() : $this->t('XXXXXX'),
//        'title' => $node->access('view') ? $node->getTitle() : $this->t('Redacted'),
      ];
    }  
    $build['pager'] = [
      '#type' => 'pager',
      '#weight' => 10,
    ];
    $build['content'] = [ 
      '#theme' => 'zin-theme',
      '#attached' => [
        'library' => [
          'zin/zin-css',
        ]
      ],
    ];
    return $build;
  }

  /**
   * {@inheritdoc}
   *
   * Building the header and content lines for the review list.
   *
   * Calling the parent::buildHeader() adds a column for the possible actions
   * and inserts the 'edit' and 'delete' links as defined for the entity type.
   */
  public function buildHeader() {
    $header['name'] = $this->t('User name');
    $header['user_image'] = $this->t('User photo');
    $header['created'] = $this->t('Review date');
    $header['message'] = $this->t('Feedback message');
    $header['image'] = $this->t('Feedback image');
    $header['email'] = $this->t('E-mail');
    $header['phone'] = $this->t('Phone number');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\zin\Entity\Review */
    // $row['id'] = $entity->id();
    $row['name'] = $entity->toLink()->toString();
    $row['user_image']['data'] = $entity->get('user_image')->view(['label' => 'hidden']);
    $row['created']['data'] = $entity->get('created')->view(['label' => 'hidden']);
    $row['message'] = $entity->message->value;
    $row['image']['data'] = $entity->get('image')->view(['label' => 'hidden']);
    $row['email']['data'] = $entity->get('email')->view(['label' => 'hidden']);
    $row['phone']['data'] = $entity->get('phone')->view(['label' => 'hidden']);  
    return $row + parent::buildRow($entity);
  }

}
