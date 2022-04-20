<?php

/**
 * @file
 * Contains \Drupal\zin\Form\CatForm.
 */

namespace Drupal\zin\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\StringTranslation\TranslationInterface;

class CatForm extends FormBase {
  
  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['cat_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Your cats name:'),
      '#maxlength' => 32,
      '#description' => $this->t('Note that the name of your cat must be at least 2 characters in length. The maximum length of the field is 32 characters.'),
      '#required' => TRUE,
    ];
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Add cat'),
      '#button_type' => 'primary',
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
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->messenger()->addStatus(t("Name of the cat was added!"));
  }
  function callback($form, $form_state) {
    return $form['cat_name'];
  }

  // public function __construct(TranslationInterface $string_translation) {
  //   // You can skip injecting this service, the trait will fall back to \Drupal::translation()
  //   // but it is recommended to do so, for easier testability,
  //   $this->stringTranslation = $string_translation;
  // }

}