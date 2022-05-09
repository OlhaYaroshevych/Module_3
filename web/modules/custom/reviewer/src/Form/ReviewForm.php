<?php

/**
 * @file
 * Contains \Drupal\reviewer\Form\ReviewForm.
 */

namespace Drupal\reviewer\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\MessageCommand;
use Drupal\file\Entity\File;

class ReviewForm extends FormBase {
  
  /**
   * {@inheritdoc}
   * 
   * Build form with fields.
   * 
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['container'] = [
      '#type' => 'container',
      '#attributes' => ['id' => 'box-container'],
    ];
    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Your name:'),
      '#maxlength' => 100,
      '#description' => $this->t('Note that the name lenghth must be at least 2 characters. The maximum length of the field is 100 characters'),
      '#required' => TRUE,
    ];
    $form['email'] = [
      '#type' => 'email',
      '#title' => $this -> t('Your e-mail:'),
      '#required' => TRUE,
      '#ajax' => [
        'callback' => '::validateEmailAjax',
        'event' => 'keyup',
        'progress' => [
          'type' => 'throbber',
          'message' => t('Veryfying e-mail..'),
        ],
      ],
      '#suffix' => '<div class="email-validation-message"></div>'
    ];
    $form['phone'] = [
      '#type' => 'textfield',
      '#title' => $this -> t('Your phone number:'),
      '#required' => TRUE,
      '#ajax' => [
        'callback' => '::validatePhoneAjax',
        'event' => 'keyup',
        'progress' => [
          'type' => 'throbber',
          'message' => t('Veryfying phone number..'),
        ],
      ],
      '#suffix' => '<div class="phone-validation-message"></div>'
    ];
    $form['message'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Your message:'),
      '#maxlength' => 600,
      '#required' => TRUE,
    ];
    $form['user_image'] = [
      '#type' => 'managed_file',
      '#title' => $this -> t('Upload a profile photo:'),
      '#name' => 'user_image',
      '#description' => $this->t('Only JPG, PNG and JPEG files are allowed. Size limit is 2MB'),
      '#upload_valiators' => [
        'file_validate_extensions' => ['jpeg jpg png'],
        'file_validate_size' => [2097152],
      ],
      '#upload_location' => 'public://images/user_image/',
    ];
    $form['image'] = [
      '#type' => 'managed_file',
      '#title' => $this -> t('Upload an image file:'),
      '#name' => 'image',
      '#description' => $this->t('Only JPG, PNG and JPEG files are allowed. Size limit is 5MB'),
      '#upload_valiators' => [
        'file_validate_extensions' => ['jpeg jpg png'],
        'file_validate_size' => [5242880],
      ],
      '#upload_location' => 'public://images/',
    ];
    $form['actions']['#type'] = 'actions';
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Share feedback'),
      '#button_type' => 'primary',
      '#ajax' => [
        'callback' => '::submitAjax',
        'wrapper' => 'box-container',
        'event' => 'click',
        'progress' => [
          'type' => 'throbber',
          'message' => t('Sharing your feedback..'),
        ],        
      ],  
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   * 
   * Get form ID
   * 
   */
  public function getFormId() {
    return 'reviewer_reviewform_form';
  }

    /**
   * {@inheritdoc}
   * 
   * Name field validation.
   * 
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (strlen($form_state->getValue('name')) < 2) {
      $form_state->setErrorByName('name', $this->t('Your name is too short.'));
    }
    if (strlen($form_state->getValue('name')) > 100) {
      $form_state->setErrorByName('name', $this->t('Your name is too long.'));
    }  
  }

  /**
   * {@inheritdoc}
   * 
   * Email validation.
   * 
   */
  protected function validateEmail(array &$form, FormStateInterface $form_state) {
    $email = $form_state->getValue('email');
    $stableExpression = '/^[A-Za-z_\-]+@\w+(?:\.\w+)+$/';
    if (preg_match($stableExpression, $email)){
      return TRUE;
    }
    return FALSE;
  }

  /**
   * {@inheritdoc}
   * 
   * Ajax email validation.
   * 
   */
  public function validateEmailAjax(array &$form, FormStateInterface $form_state) {
    $valid = $this->validateEmail($form, $form_state);
    $response = new AjaxResponse();
    if ($valid) {
      $css = ['box-shadow' => 'inset 0 0 10px green'];
    }
    else {
      $css = ['box-shadow' => 'inset 0 0 10px red'];
      $message = $this->t('E-mail is not valid.');
    }
    $response->addCommand(new CssCommand('#edit-email', $css));
    $response->addCommand(new HtmlCommand('.email-validation-message', $message));
    return $response;
  }

  /**
   * {@inheritdoc}
   * 
   * Phone validation.
   * 
   */
  protected function validatePhone(array &$form, FormStateInterface $form_state) {
    $phone = $form_state->getValue('phone');
    if(preg_match("/^0[0-9]{9}$/", $phone)) {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * {@inheritdoc}
   * 
   * Ajax phone validation.
   * 
   */
  public function validatePhoneAjax(array &$form, FormStateInterface $form_state) {
    $valid = $this->validatePhone($form, $form_state);
    $response = new AjaxResponse();
    if ($valid) {
      $css = ['box-shadow' => 'inset 0 0 10px green'];
    }
    else {
      $css = ['box-shadow' => 'inset 0 0 10px red'];
      $message = $this->t('Please, use only digits.');
    }
    $response->addCommand(new CssCommand('#edit-phone', $css));
    $response->addCommand(new HtmlCommand('.phone-validation-message', $message));
    return $response;
  }

  /**
   * {@inheritdoc}
   * 
   * Submit form.
   * 
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $user_image = $form_state->getValue('user_image');
    $image = $form_state->getValue('image');
    //If the image is uploaded, save it in the database
    if ($user_image) {
      $file = File::load($user_image[0]);
      $file->setPermanent();
      $file->save();
    }
    if ($image) {
      $file = File::load($image[0]);
      $file->setPermanent();
      $file->save();
    }
    //Database connection
    $database = \Drupal::database();
    $database->insert('reviewer')
    ->fields([
      'name' => $form_state->getValue('name'),
      'email' => $form_state->getValue('email'),
      'phone' => $form_state->getValue('phone'),
      'message' => $form_state->getValue('message'),
      'user_image' => $user_image[0],
      'image' => $image[0],
    ])
      ->execute();
  }
  
  /**
   * {@inheritdoc}
   * 
   * Ajax submit form.
   * 
   */
  public function submitAjax(array &$form, FormStateInterface $form_state) {
    $response = new AjaxResponse();
    // Modal message about errors in form
    if ($form_state->getErrors()) {
      foreach ($form_state->getErrors() as $err) {
        $response->addCommand(new MessageCommand($err, NULL, ['type' => 'error']));
      }
      $form_state->clearErrors();
    }  
    // Modal message about successful data save.
    else {
      $response->addCommand(new MessageCommand($this->t('Thanks for sharing your feedback!'), NULL, ['type' => 'status'], TRUE));
      $form_state->setRebuild(TRUE);
    }
    $this->messenger()->deleteAll();
    return $response;
  }

}
