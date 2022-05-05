<?php

/**
 * @return
 * Contains \Drupal\zin\Controller\ZinController.
 */
namespace Drupal\zin\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\file\Entity\File;

/**
 * Returns responses for zin routes.
 */
class ZinController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build() {
    $form = \Drupal::formBuilder()->getForm('Drupal\zin\Form\CatForm');
    $build['header'] = [
      '#type' => 'markup',
      '#markup' => '<div class="process-heading">' . $this->t('Hello! You can add here a photo of your cat.') . '</div>',
    ];
    $heading = [
      'name' => t('Cat\'s name'),
      'email' => t('E-mail'),
      'image' => t('Cat\'s image'),
      'timestamp' => t('Submitting date'),
    ];
    $cats['table'] = [
      '#type' => 'table',
      '#header' => $heading,
      '#rows' => $this->getCatsInfo(),
    ];
    $build['content'] = [
      '#form' => $form,
      '#theme' => 'zin-theme',
      '#cats' => $cats,
    ];
    return $build;
  }

  /**
   * {@inheritdoc}
   * 
   * Database output.
   * 
   */
  public function getCatsInfo() {
    $output = \Drupal::database()->select('zin', 'z')
      ->fields('z', ['id', 'name', 'email', 'image', 'timestamp'])
      ->orderBy('id', 'DESC')
      ->execute();
    $cats = [];
    foreach ($output as $cat) {
      $image = NULL;
      if ($cat->image != $image) {
        $image = File::load($cat->image)->createFileUrl(FALSE);
      }
      $cats[] = [
        'id' => $cat->id,
        'name' => $cat->name,
        'email' => $cat->email,
        'image' => $image,
        'timestamp' => date('Y-m-d h:m:s'),
      ];
    }
    return $cats;
  }

}
