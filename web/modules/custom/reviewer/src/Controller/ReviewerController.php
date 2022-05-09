<?php

/**
 * @return
 * Contains \Drupal\reviewer\Controller\ReviewerController.
 */
namespace Drupal\reviewer\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\file\Entity\File;
use Symfony\Component\Routing\Generator\UrlGenerator;

/**
 * Returns responses for reviewer routes.
 */
class ReviewerController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build() {
    $form = \Drupal::formBuilder()->getForm('Drupal\reviewer\Form\ReviewForm');
    $build['header'] = [
      '#type' => 'markup',
      '#markup' => '<div class="process-heading">' . $this->t('Got feedback? We\'d love to hear it!') . '</div>',
    ];
    $heading = [
      'user_image' => t('Personal Info'),
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
    $db = \Drupal::database();
    $output = $db->select('reviewer', 'r')
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
        'timestamp' => date("m/j/Y H:i:s"),
      ];
    }
  return $reviews;
  }
  
}
