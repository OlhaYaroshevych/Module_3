<?php

/**
 * @return
 * Contains \Drupal\zin\Controller\ZinController.
 */

namespace Drupal\zin\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for zin routes.
 */
class ZinController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function content() {
    $build = [];
    $build['heading'] = [
      '#type' => 'markup',
      '#markup' => '<div class="process-heading">' . $this->t('Hello! You can add here a photo of your cat.') . '</div>',
    ];
    $build['form'] = $this->formBuilder()->getForm('Drupal\zin\Form\CatForm');
    return $build;
  }

}
