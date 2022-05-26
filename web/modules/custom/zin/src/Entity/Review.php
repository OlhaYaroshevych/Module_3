<?php

namespace Drupal\zin\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\zin\ReviewInterface;
use Drupal\user\UserInterface;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\ContentEntityInterface;

/**
 * Defines the Zin entity.
 *
 * @ingroup zin
 *
 * This is the main definition of the entity type. From it, an EntityType object
 * is derived. The most important properties in this example are listed below.
 *
 * id: The unique identifier of this entity type. It follows the pattern
 * 'moduleName_xyz' to avoid naming conflicts.
 *
 * label: Human readable name of the entity type.
 *
 * handlers: Handler classes are used for different tasks. You can use
 * standard handlers provided by Drupal or build your own, most probably derived
 * from the ones provided by Drupal. In detail:
 *
 * - view_builder: we use the standard controller to view an instance. It is
 *   called when a route lists an '_entity_view' default for the entity type.
 *   You can see this in the entity.zin_review.canonical
 *   route in the zin.routing.yml file. The view can be
 *   manipulated by using the standard Drupal tools in the settings.
 *
 * - list_builder: We derive our own list builder class from EntityListBuilder
 *   to control the presentation. If there is a view available for this entity
 *   from the views module, it overrides the list builder if the "collection"
 *   key in the links array in the Entity annotation below is changed to the
 *   path of the View. In this case the entity collection route will give the
 *   view path.
 *
 * - form: We derive our own forms to add functionality like additional fields,
 *   redirects etc. These forms are used when the route specifies an
 *   '_entity_form' or '_entity_create_access' for the entity type. Depending on
 *   the suffix (.add/.default/.delete) of the '_entity_form' default in the
 *   route, the form specified in the annotation is used. The suffix then also
 *   becomes the $operation parameter to the access handler. We use the
 *   '.default' suffix for all operations that are not 'delete'.
 *
 * - access: Our own access controller, where we determine access rights based
 *   on permissions.
 *
 * More properties:
 *
 *  - base_table: Define the name of the table used to store the data. Make sure
 *    it is unique. The schema is automatically determined from the
 *    BaseFieldDefinitions below. The table is automatically created during
 *    installation.
 *
 *  - entity_keys: How to access the fields. Specify fields from
 *    baseFieldDefinitions() which can be used as keys.
 *
 *  - links: Provide links to do standard tasks. The 'edit-form' and
 *    'delete-form' links are added to the list built by the
 *    entityListController. They will show up as action buttons in an additional
 *    column.
 *
 *  - field_ui_base_route: The route name used by Field UI to attach its
 *    management pages. Field UI module will attach its Manage Fields,
 *    Manage Display, and Manage Form Display tabs to this route.
 *
 * There are many more properties to be used in an entity type definition. For
 * a complete overview, please refer to the '\Drupal\Core\Entity\EntityType'
 * class definition.
 *
 * The following construct is the actual definition of the entity type which
 * is read and cached. Don't forget to clear cache after changes.
 *
 * @ContentEntityType(
 *   id = "zin_review",
 *   label = @Translation("Review entity"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\zin\Entity\Controller\ReviewListBuilder",
 *     "form" = {
 *       "default" = "Drupal\zin\Form\ReviewForm",
 *       "delete" = "Drupal\zin\Form\ReviewDeleteForm",
 *     },
 *     "access" = "Drupal\zin\ReviewAccessControlHandler",
 *   },
 *   list_cache_contexts = { "user" },
 *   base_table = "review",
 *   admin_permission = "administer review entity",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/zin_review/{zin_review}",
 *     "edit-form" = "/zin_review/{zin_review}/edit",
 *     "delete-form" = "/review/{zin_review}/delete",
 *     "collection" = "/zin_review/list"
 *   },
 *   field_ui_base_route = "zin.review_settings",
 * )
 *
 * The 'links' above are defined by their path. For core to find the
 * corresponding route, the route name must follow the correct pattern:
 *
 * entity.<entity_type>.<link_name>
 *
 * Example: 'entity.zin_review.canonical'.
 *
 * See the routing file at zin.routing.yml for the
 * corresponding implementation.
 *
 * The Review class defines methods and fields for the review entity.
 *
 * Being derived from the ContentEntityBase class, we can override the methods
 * we want. In our case we want to provide access to the standard fields about
 * creation and changed time stamps.
 *
 * Our interface (see ReviewInterface) also exposes the EntityOwnerInterface.
 * This allows us to provide methods for setting and providing ownership
 * information.
 *
 * The most important part is the definitions of the field properties for this
 * entity type. These are of the same type as fields added through the GUI, but
 * they can by changed in code. In the definition we can define if the user with
 * the rights privileges can influence the presentation (view, edit) of each
 * field.
 *
 * The class also uses the EntityChangedTrait trait which allows it to record
 * timestamps of save operations.
 */
class Review extends ContentEntityBase implements ReviewInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   *
   * When a new entity instance is added, set the user_id entity reference to
   * the current user as the creator of the instance.
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += [
      'user_id' => \Drupal::currentUser()->id(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   *
   * Define the field properties here.
   *
   * Field name, type and size determine the table structure.
   *
   * In addition, we can define how the field and its content can be manipulated
   * in the GUI. The behaviour of the widgets used can be determined here.
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    // Standard field, used as unique if primary index.
    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the Review entity.'))
      ->setReadOnly(TRUE);

    // Standard field, unique outside of the scope of the current project.
    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the Review entity.'))
      ->setReadOnly(TRUE);

    // Name field for the review.
    // We set display options for the view as well as the form.
    // Users with correct privileges can change the view and edit configuration.
    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Your name'))
      ->setDescription(t('Note that the name lenghth must be at least 2 characters. The maximum length of the field is 100 characters'))
      ->setSettings([
        'max_length' => 100,
        'text_processing' => 0,
      ])
      ->setPropertyConstraints('value', [
        'Length' => [
          'min' => 2,
          'max' => 100,
          'minMessage' => t('Min name length is 2 characters.'),
          'maxMessage' => t('Max name length is 100 characters.'),       
        ],
      ])
      ->setRequired(TRUE)
      ->setDefaultValue(NULL)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -6,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -6,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    // Email field for the review.  
    $fields['email'] = BaseFieldDefinition::create('email')
    ->setLabel(t('Your e-mail'))
    ->setSettings([
      'max_length' => 255,
      'text_processing' => 0,
    ])
    ->setPropertyConstraints('value', [
      'Regex' => [
        'pattern' => '/^[A-Za-z_\-]+@\w+(?:\.\w+)+$/',
        'message' => t('E-mail is not valid. Please, use only latin letters'),
      ],
    ])
    ->setRequired(TRUE)
    ->setDefaultValue(NULL)
    ->setDisplayOptions('view', [
      'label' => 'above',
      'type' => 'email_mailto',
      'weight' => -5,
    ])
    ->setDisplayOptions('form', [
      'type' => 'email_default',
      'weight' => -5,
    ])
    ->setDisplayConfigurable('form', TRUE)
    ->setDisplayConfigurable('view', TRUE);

    // Phone field for the review.
    $fields['phone'] = BaseFieldDefinition::create('telephone')
    ->setLabel(t('Your phone number'))
    ->setDescription(t('Note that only digits allowed.'))
    ->setSettings([
      'max_length' => 10,
      'text_processing' => 0,
    ])
    ->setPropertyConstraints('value', [
      'Regex' => [
        'pattern' => '/^0[0-9]{9}$/',
        'message' => t('Phone number is not valid. Please, use only digits'),
      ],
    ])
    ->setRequired(TRUE)
    ->setDefaultValue(NULL)
    ->setDisplayOptions('view', [
      'label' => 'above',
      'type' => 'telephone_link',
      'weight' => -5,
    ])
    ->setDisplayOptions('form', [
      'type' => 'telephone_default',
      'weight' => -5,
    ])
    ->setDisplayConfigurable('form', TRUE)
    ->setDisplayConfigurable('view', TRUE);  
    
    // Feedback field for the review.
    $fields['message'] = BaseFieldDefinition::create('string_long')
      ->setLabel(t('Your message'))
      ->setSettings([
        'max_length' => 600,
        'text_processing' => 0,
      ])
      ->setRequired(TRUE)
      ->setDefaultValue(NULL)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'text_default',
        'weight' => -5,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textarea',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    // User_image field for the review.
    $fields['user_image'] = BaseFieldDefinition::create('image')
      ->setLabel(t('Your photo'))
      ->setDefaultValue(NULL)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'image',
        'settings' => [
          'image_link' => 'file',
          'image_style' => 'thumbnail',
        ],
        'weight' => -5,
      ])
      ->setDisplayOptions('form', [
        'type' => 'image',
        'weight' => -5,
      ])
      ->setSettings([
        'alt_field' => FALSE,
        'max_filesize' => 2097152,
        'file_extensions' => 'jpeg jpg png',
        'file_directory' => 'zin/user_images',
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);
      
    // Feedback image field for the review.
    $fields['image'] = BaseFieldDefinition::create('image')
      ->setLabel(t('Image'))
      ->setDefaultValue(NULL)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'image',
        'settings' => [
          'image_link' => 'file',
          'image_style' => 'large',
        ],
        'weight' => -5,
      ])
      ->setDisplayOptions('form', [
        'type' => 'image',
        'weight' => -5,
      ])
      ->setSettings([
        'alt_field' => FALSE,
        'max_filesize' => 5242880,
        'file_extensions' => 'jpeg jpg png',
        'file_directory' => 'zin/images',
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);    

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Date'))
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'timestamp',
        'settings' => [
          'date_format' => 'custom',
          'custom_date_format' => 'm/j/Y H:i:s',
        ],
        'weight' => 20,
      ])
      ->setDisplayOptions('form', [
        'type' => 'datetime_timestamp',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);;

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
