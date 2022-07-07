<?php

/**
 * @file
 * Contains manny_dev\manny_dev.views.inc..
 * Provide a custom views field data that isn't tied to any other module. */


/**
* Implements hook_views_data().
*/
function manny_dev_views_data() {

    $data['views']['table']['group'] = t('Custom Global');
    $data['views']['table']['join'] = [
      // #global is a special flag which allows a table to appear all the time.
      '#global' => [],
    ];

    $data['views']['custom_views_field'] = [
        'title' => t('Custom views field'),
        'help' => t('My awesome custom views field plugin 1.'),
        'field' => [
            'id' => 'custom_views_field',
        ],
    ];
    return $data;
}
