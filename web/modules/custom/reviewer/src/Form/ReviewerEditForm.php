<?php

namespace Drupal\reviewer\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\MessageCommand;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\RemoveCommand;
use Drupal\Core\Ajax\CloseModalDialogCommand;

class ReviewerEditForm extends ReviewForm {

  /**
   *
   * @var int
   */
  protected object $review;

  /**
   * {@inheritdoc}
   */
  public function getFormId() : string {
    return "reviewer_edit_form";
  }

  /**
   * {@inheritdoc}
   * 
   * Build form.
   * 
   */
  public function buildForm(array $form, FormStateInterface $form_state, int $id = NULL): array {
    $database = \Drupal::database();
    $result = $database->select('reviewer', 'r')
      ->fields('r', ['id', 'name', 'email', 'phone', 'message', 'user_image', 'image'])
      ->condition('id', $id)
      ->execute()->fetch();
    $this->review = $result;
    $form = parent::buildForm($form, $form_state);
    $form['name']['#default_value'] = $result->name;
    $form['name']['#prefix'] = '<div class="error-massage-modal"></div>';
    $form['email']['#default_value'] = $result->email;
    $form['email']['#prefix'] = '<div class="email-massage-modal"></div>';
    $form['phone']['#default_value'] = $result->phone;
    $form['phone']['#prefix'] = '<div class="phone-massage-modal"></div>';
    $form['message']['#default_value'] = $result->message;
    $form['message']['#prefix'] = '<div class="error-massage-modal"></div>';
    if ($result->user_image) {
      $form['user_image']['#default_value'][] = $result->user_image;
    }
    if ($result->image) {
      $form['image']['#default_value'][] = $result->image;
    }
    $form['submit']['#value'] = $this->t('Edit review');
    return $form;
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
    $response->addCommand(new CssCommand('input[data-drupal-selector = "edit-email"]', $css));
    $response->addCommand(new HtmlCommand('.email-validation-message', $message));
    return $response;
  }

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
  public function validatePhoneAjax(array &$form, FormStateInterface $form_state): AjaxResponse {
    $valid = $this->validatePhone($form, $form_state);
    $response = new AjaxResponse();
    if ($valid) {
      $css = ['box-shadow' => 'inset 0 0 10px green'];
    }
    else {
      $css = ['box-shadow' => 'inset 0 0 10px red'];
      $message = $this->t('Please, use only digits.');
    }
    $response->addCommand(new CssCommand('input[data-drupal-selector = "edit-phone"]', $css));
    $response->addCommand(new HtmlCommand('.phone-validation-message', $message));
    return $response;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    $valid = $this->validatePhone($form, $form_state);
    $email = $form_state->getValue('email');
    $stableExpression = '/^[A-Za-z_\-]+@\w+(?:\.\w+)+$/';
    if (strlen($form_state->getValue('name')) < 2) {
      $form_state->setErrorByName('name', $this->t('Your name is too short.'));
    }
    if (strlen($form_state->getValue('name')) > 100) {
      $form_state->setErrorByName('name', $this->t('Your name is too long.'));
    }
    if (!$valid) {
      $form_state->setErrorByName('phone');
    }
    if (!preg_match($stableExpression, $email)){
      $form_state->setErrorByName('email');;
    }

  }
  /**
   * {@inheritdoc}
   * 
   * Ajax submit form.
   * 
   */
  public function submitAjax(array &$form, FormStateInterface $form_state): AjaxResponse {
    $response = new AjaxResponse();
    if ($form_state->getErrors()) {
      foreach ($form_state->getErrors() as $err) {
        $response->addCommand(new MessageCommand(
          $err, '.error-massage-modal', ['type' => 'error']));
      }
      $form_state->clearErrors();
    }
    else {
      $response->addCommand(new MessageCommand(
        $this->t('Review was edited.'),
        NULL,
        ['type' => 'status'],
        TRUE));
      $response->addCommand(new CloseModalDialogCommand());
    }
    $this->messenger()->deleteAll();
    return $response;
  } 
  
  /**
   * {@inheritdoc}
   * 
   * Submit form.
   * 
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $user_image = NULL;
    $image = NULL;
    if ($form_state->getValue('user_image')[0] && $form_state->getValue('user_image')[0] != $this->response->user_image) {
      $user_image = $form_state->getValue('user_image')[0];
      $file = File::load($user_image);
      $file->setPermanent();
      $file->save();
    }
    elseif ($form_state->getValue('user_image')[0]) {
      $user_image = $this->response->user_image;
    }
    elseif ($this->response->user_image) {
      File::load($this->response->user_image)->delete();
    }

   
    if ($form_state->getValue('image')[0] && $form_state->getValue('image')[0] != $this->response->image) {
      $image = $form_state->getValue('image')[0];
      $file = File::load($image);
      $file->setPermanent();
      $file->save();
    }
    elseif ($form_state->getValue('image')[0]) {
      $image = $this->response->image;
    }
    elseif ($this->response->image) {
      File::load($this->response->image)->delete();
    }
    // if ($edited['user_image'] != $this->review->user_image) {
    //   $file = File::load($edited['user_image']);
    //   $file->setPermanent();
    //   $file->save();
    //   File::load($this->review->user_image)->delete(); 
    // }
    // if ($edited['image'] != $this->review->image) {
    //   $file = File::load($edited['image']);
    //   $file->setPermanent();
    //   $file->save();
    //   File::load($this->review->image)->delete(); 
    // }
    $edited = [
      'name' => $form_state->getValue('name'),
      'email' => $form_state->getValue('email'),
      'phone' => $form_state->getValue('phone'),
      'message' => $form_state->getValue('message'),
      'user_image' => $form_state->getValue('user_image')[0],
      'image' => $form_state->getValue('image')[0],
    ];
    $database = \Drupal::database();
    $database->update('reviewer')
      ->condition('id', $this->review->id)
      ->fields($edited)
      ->execute();
  }
 
}
