<?php

/**
 * @file
 * Contains \Drupal\zin\Form\CatForm.
 */

namespace Drupal\zin\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\MessageCommand;

class CatForm extends FormBase {
  
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['container'] = [
      '#type' => 'container',
      '#attributes' => ['id' => 'box-container'],
    ];
    $form['cat_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Your cat\'s name:'),
      '#maxlength' => 32,
      '#description' => $this->t('Note that the name of your cat must be at least 2 characters in length. The maximum length of the field is 32 characters'),
      '#required' => TRUE,
    ];
    $form['email'] = [
      '#type' => 'email',
      '#title' => $this -> t('Your e-mail:'),
      '#description' => $this -> t('Please use only Latin letters, underscores or hyphens'),
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
    $form['my_file']['image_dir'] = [
      '#type' => 'managed_file',
      '#title' => 'Upload image:',
      '#description' => $this->t('Only JPG, PNG and JPEG files are allowed. Size limit is 2MB'),
      '#required' => TRUE,
      '#upload_valiators' => [
        //'file_validate_is_image' => [],
        'file_validate_extensions' => ['jpeg jpg png'],
        'file_validate_size' => [25600000],
      ],
      '#upload_location' => 'public://'
    ];
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Add cat'),
      '#button_type' => 'primary',
      '#ajax' => [
        'callback' => '::ajaxSubmit',
        'wrapper' => 'box-container',
        'progress' => [
          'type' => 'throbber',
          'message' => t('Adding the cat\'s name..'),
        ],        
      ],  
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'zin_catform_form';
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (strlen($form_state->getValue('cat_name')) < 2) {
      $form_state->setErrorByName('cat_name', $this->t('Name of the cat is too short.'));
    }
    if (strlen($form_state->getValue('cat_name')) > 32) {
      $form_state->setErrorByName('cat_name', $this->t('Name of the cat is too long.'));
    }  
    $img = $form_state->getValue(['my_file' => 'image_dir']);
    if (empty($img)) {
      $form_state->setErrorByName('my_file', $this->t('No image available'));
    }
  }

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
  */
  public function validateEmailAjax(array &$form, FormStateInterface $form_state) {
    $valid = $this->validateEmail($form, $form_state);
    $response = new AjaxResponse();
    if ($valid) {
      $css = ['box-shadow' => 'inset 0 0 10px green'];
      $message = $this->t('E-mail is valid.');
    }
    else {
      $css = ['box-shadow' => 'inset 0 0 10px red'];
      $message = $this->t('E-mail is not valid.');
    }
    $response->addCommand(new CssCommand('#edit-email', $css));
    $response->addCommand(new HtmlCommand('.email-validation-message', $message));
    return $response;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->messenger()->addStatus(t("Name of the cat was added!"));
  }
  
  /**
   * {@inheritdoc}
   */
  public function ajaxSubmit(array &$form, FormStateInterface $form_state) {
    $element = $form['container'];
    $email = $form_state->getValue('email');
    $stableExpression = '/^[A-Za-z_\-]+@\w+(?:\.\w+)+$/';
    if (($form_state->hasAnyErrors()) || (!preg_match($stableExpression, $email))) {
      return $element;
    }
    return $element;
  }

}