<?php

namespace Drupal\manny_dev\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the manny_dev module.
 */
class DefaultControllerTest extends WebTestBase {


  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return [
      'name' => "manny_dev DefaultController's controller functionality",
      'description' => 'Test Unit for module manny_dev and controller DefaultController.',
      'group' => 'Other',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
  }

  /**
   * Tests manny_dev functionality.
   */
  public function testDefaultController() {
    // Check that the basic functions of module manny_dev.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via Drupal Console.');
  }

}
