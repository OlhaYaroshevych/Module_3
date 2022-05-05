<?php

namespace Drupal\zin\Form;

use Drupal\file\Entity\File;
use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Defines a confirmation form to confirm deletion cat by id.
 */
class DeleteForm extends ConfirmFormBase {

  /**
   * ID of the item to delete.
   *
   * @var int
   */
  protected int $id;

  /**
   * {@inheritdoc}
   * 
   * Build form.
   * 
   */
  public function buildForm(array $form, FormStateInterface $form_state, string $id = NULL): array {
    $this->id = $id;
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   * 
   * Submit form.
   * 
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $image = $form_state->getValue('image');
    $database = \Drupal::database();
    // Delete an image from the database.
    $result = $database->select('zin', 'z')
      ->fields('z', ['image'])
      ->condition('id', $this->id)
      ->execute()->fetch();
    if ($result->image) {
      File::load($result->image)->delete();
    }
    $database->delete('zin')
    ->condition('id', $this->id)
    ->execute();
    // Displays a successful removal message.
    \Drupal::messenger()->addStatus('Succesfully deleted.');
    $form_state->setRedirect('zin.cats');
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() : string {
    return "delete_form";
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() : Url {
    return new Url('zin.cats');
  }

  /**
   * {@inheritdoc}
   * 
   * Output a modal question window.
   * 
   */
  public function getQuestion() {
    $database = \Drupal::database();
    $result = $database->select('zin', 'z')
      ->fields('z', ['id'])
      ->condition('id', $this->id)
      ->execute()
      ->fetch();
    return $this->t('Do you want to delete this cat?');
  }

}
