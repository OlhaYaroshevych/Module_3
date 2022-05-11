<?php

/**
 * @return
 * Contains \Drupal\reviewer\Controller\ReviewerController.
 */
namespace Drupal\reviewer\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\file\Entity\File;
use Drupal\Core\Datetime\DrupalDateTime; 
use Drupal\Core\Form\FormBuilder;
use Drupal\Core\Database\Connection;
use Drupal\file\FileUsage\FileUsageInterface;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Returns responses for reviewer routes.
 */
class ReviewerController extends ControllerBase {

    /**
   * The form builder.
   *
   * @var \Drupal\Core\Form\FormBuilder
   */
  protected $formBuilder;

    /**
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

    /**
   * The file usage interface.
   *
   * @var \Drupal\file\FileUsage\FileUsageInterface
   */
  protected $fileUsage;

  /**
   * ModalFormContactController constructor.
   *
   * @param \Drupal\Core\Database\Connection $database
   * 
   * @param \Drupal\Core\Form\FormBuilder $form_builder
   *   The form builder.
   */
  public function __construct(FormBuilder $form_builder,Connection $database, FileUsageInterface $file_usage) {
    $this->formBuilder = $form_builder;
    $this->database = $database;
    $this->fileUsage = $file_usage;
  }

  /**
   * {@inheritdoc}
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   The Drupal service container.
   *
   * @return static
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('form_builder'),
      $container->get('database'),
      $container->get('file.usage'),
    );
  }
  /**
   * Builds the response.
   */
  public function build() {
    $form = $this->formBuilder()->getForm('Drupal\reviewer\Form\ReviewForm');
    $build['header'] = [
      '#type' => 'markup',
      '#markup' => '<div class="process-heading">' . $this->t('Got feedback? We\'d love to hear it!') . '</div>',
    ];
    $heading = [
      'user_image' => $this->t('Personal Info'),
      'message' => t('Feedback message'),
      'email' => t('Contact Info'),
    ];
    $reviews['table'] = [
      '#type' => 'table',
      '#header' => $heading,
      '#rows' => $this->getReviews(),
    ];
    $build['content'] = [
      '#form' => $form, 
      '#theme' => 'reviewer-theme',
      '#attached' => [
        'library' => [
          'reviewer/reviewer-css',
        ]
      ],
      '#reviews' => $reviews,     
    ];
    return $build;
  }

  /**
   * {@inheritdoc}
   * 
   * Database output.
   * 
   */
  public function getReviews() {
// Db connection
    $output = $this->database->select('reviewer', 'r')
      ->fields('r', ['id','name', 'email', 'phone', 'message', 'user_image', 'image', 'timestamp'])
      ->orderBy('id', 'DESC')
     ->execute();
    $reviews = [];
    foreach ($output as $review) {
      $user_image = NULL;
      $image = NULL;
      if ($review->user_image != $user_image) {
        $user_image = File::load($review->user_image)->createFileUrl(false);
      }
      if ($review->image != $image) {
        $image = File::load($review->image)->createFileUrl(false);
      }
      $reviews[] = [
        'id' => $review->id,
        'name' => $review->name,
        'email' => $review->email,
        'phone' => $review->phone,
        'message' => $review->message,
        'user_image' => $user_image,
        'image' => $image,
        'timestamp' => $review->timestamp,
        //'timestamp' => date('m/j/Y H:i:s', strtotime('+3 hour')),
      ];
    }
  return $reviews;
  }
  
}
