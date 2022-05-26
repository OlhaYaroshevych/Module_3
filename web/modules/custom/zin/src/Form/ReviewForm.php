<?php

namespace Drupal\zin\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Language\Language;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\RedirectCommand;

/**
 * Form controller for the zin entity edit forms.
 *
 * @ingroup zin
 */
class ReviewForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\zin\Entity\Review */
    $form = parent::buildForm($form, $form_state);
    $form['#prefix'] = '<div id="review-form"';
    $form['#suffix'] = '</div>';
    $form['actions']['submit']['#ajax'] = [
      'callback' => '::submitAjax',
      'wrapper' => 'review-form',
      'progress' => [
        'type' => 'throbber',
        'message' => t('Sharing your feedback..'),
      ],  
    ];
    $form['content'] = [ 
      '#attached' => [
        'library' => [
          'zin/zin-css',
        ]
      ],
    ];
    return $form;
  }

   /**
   * AJAX validation and confirmation of the form.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @return array|\Drupal\core\Ajax\AjaxResponse
   *   Return form or Ajax response.
   */
  public function submitAjax(array $form, FormStateInterface $form_state) {
    if ($form_state->hasAnyErrors()) {
      return $form;
    }
    $zin_review = new AjaxResponse();
    $zin_review->addCommand(new RedirectCommand('/zin_review/list'));
    return $zin_review;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $form_state->setRedirect('entity.zin_review.collection');
    $entity = $this->getEntity();
    $result = $entity->save();
    $link = $entity->toLink($this->t('View'))->toRenderable();
    $message_arguments = ['%label' => $this->entity->label()];
    $logger_arguments = $message_arguments + ['link' => render($link)];

    if ($result == SAVED_NEW) {
      $this->messenger()->addStatus($this->t('New review %label has been created.', $message_arguments));
      $this->logger('zin_review')->notice('Created new review from %label', $logger_arguments);
    }
    else {
      $this->messenger()->addStatus($this->t('The review %label has been updated.', $message_arguments));
      $this->logger('zin_review')->notice('Updated new review from %label.', $logger_arguments);
    }
  }

}