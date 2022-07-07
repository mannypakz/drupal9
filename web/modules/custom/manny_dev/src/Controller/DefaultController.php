<?php

namespace Drupal\manny_dev\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Routing\TrustedRedirectResponse;

/**
 * Defines DefaultController class.
 */
class DefaultController extends ControllerBase {

  /**
   * Display the markup.
   *
   * @return array
   *   Return markup array.
   */
  public function content($name) {
    $query = \Drupal::database()->select('manny_dev', 'md');
    $query->fields('md', ['id', 'short_url', 'long_url']);
    $query->condition('md.short_url', \Drupal::request()->getSchemeAndHttpHost() . '/md/' . $name);
    $results = $query->execute()->fetch();

    if($results) {
      return new TrustedRedirectResponse($results->long_url);
    }

    return [
      '#type' => 'markup',
      '#markup' => 'Short URL not found' ,
    ];
  }

}