<?php

namespace Drupal\manny_dev\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\Html;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\Random;

/**
 * Plugin implementation of the 'example_field_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "example_field_formatter",
 *   label = @Translation("Example field formatter"),
 *   field_types = {
 *     "link"
 *   }
 * )
 */
class ExampleFieldFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      // Implement default settings.
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    return [
      // Implement settings form.
    ] + parent::settingsForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    // Implement settings summary.

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];
    $node = \Drupal::routeMatch()->getParameter('node');
    $random = new Random();
    $shortUrl = '';
     $longUrl = '';

    if ($node instanceof \Drupal\node\NodeInterface) {
      $nid = $node->id();
      $flag = true;

      $query = \Drupal::database()->select('manny_dev', 'md');
      $query->fields('md', ['id', 'short_url', 'long_url']);
      $query->condition('md.nid', $nid);
      $results = $query->execute()->fetch();

      if(!$results) {
        while($flag) {
          $rand = $random->name();
          $query = \Drupal::database()->select('manny_dev', 'md');
          $query->addField('md', 'id');
          $query->condition('md.short_url', $rand);
          $results = $query->execute()->fetchAll();

          if(count($results) == 0) {
            $fieldValue = $node->get('field_manny_links')->getValue();
            $connection = \Drupal::service('database');
            $result = $connection->insert('manny_dev')
              ->fields([
                'nid' => $nid,
                'long_url' => $fieldValue[0]['uri'],
                'short_url' => \Drupal::request()->getSchemeAndHttpHost() . '/md/' . $rand,
              ])
              ->execute();
            $shortUrl = $rand;
            $shortUrl = \Drupal::request()->getSchemeAndHttpHost() . '/md/' . $rand;
            $longUrl = $fieldValue[0]['uri'];
            $flag = false;
          }
        }
      }
      else {
        $shortUrl = $results->short_url;
        $longUrl = $results->long_url;
      }

      foreach ($items as $delta => $item) {
        // print_r($item->mainPropertyName());
        $elements[$delta] = [
          '#markup' => '<a href="'.$longUrl.'" target="_blank">' . $shortUrl . '</a>'
        ];
      }

    }

    return $elements;
  }

  /**
   * Generate the output appropriate for one field item.
   *
   * @param \Drupal\Core\Field\FieldItemInterface $item
   *   One field item.
   *
   * @return string
   *   The textual output generated.
   */
  protected function viewValue(FieldItemInterface $item) {
    // The text value has no text format assigned to it, so the user input
    // should equal the output, including newlines.
    return nl2br(Html::escape($item->value));
  }

}
