<?php

namespace Drupal\reviewer\Form;

use Drupal\file\Entity\File;
use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Defines a confirmation form to confirm deletion review by id.
 */
class ReviewerDeleteForm extends ConfirmFormBase {

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
    //Database connection
    $database = \Drupal::database();
    // Delete a user_image from the database
    $result = $database->select('reviewer', 'r')
      ->fields('r', ['user_image', 'image'])
      ->condition('id', $this->id)
      ->execute()->fetch();
    if ($result->user_image) {
       File::load($result->user_image)->delete();
     }
    // Delete an image from the database
    if ($result->image) {
      File::load($result->image)->delete();
    }  
    // Delete slected item from the database
    $database->delete('reviewer')
    ->condition('id', $this->id)
    ->execute();
     // Display a successful removal message
    \Drupal::messenger()->addStatus('Review was succesfully deleted.');
    $form_state->setRedirect('reviewer.content');  
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() : string {
    return "reviewer_delete_form";
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() : Url {
    return new Url('reviewer.content');
  }

  /**
   * {@inheritdoc}
   * 
   * Popup output.
   * 
   */
  public function getQuestion() {
    $database = \Drupal::database();
    $result = $database->select('reviewer', 'r')
      ->fields('r', ['id'])
      ->condition('id', $this->id)
      ->execute()
      ->fetch();
    return $this->t('Are you sure you want to delete this item?');
  }

}