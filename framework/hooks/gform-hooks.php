<?php

/**
 * Gravity Forms Bootstrap Styles
 *
 * Applies bootstrap classes to various common field types.
 * Requires Bootstrap to be in use by the theme.
 *
 * Using this function allows use of Gravity Forms default CSS
 * in conjuction with Bootstrap (benefit for fields types such as Address).
 *
 * @see  gform_field_content
 * @link http://www.gravityhelp.com/documentation/page/Gform_field_content
 * @link https://www.gravityhelp.com/documentation/gravity-forms/extending-gravity-forms/hooks/filters/gform_field_content/
 * @link https://github.com/5t3ph/gravity-forms-snippets/blob/master/gravity-forms-bootstrap-styles.php
 *
 * @return string Modified field content
 */
add_filter("gform_field_content", "bootstrap_styles_for_gravityforms_fields", 10, 5);

function bootstrap_styles_for_gravityforms_fields($content, $field, $value, $lead_id, $form_id) {

    // Currently only applies to most common field types, but could be expanded.

    if ($field["type"] != 'hidden' && $field["type"] != 'list' && $field["type"] != 'multiselect' && $field["type"] != 'checkbox' && $field["type"] != 'fileupload' && $field["type"] != 'date' && $field["type"] != 'html' && $field["type"] != 'address') {
        $content = str_replace('class=\'medium', 'class=\'form-control', $content);
    }

    if ($field["type"] == 'tel' || $field["type"] == 'text' || $field["type"] == 'name' || $field["type"] == 'address' || $field["type"] == 'email' || $field["type"] == 'number') {
        $content = str_replace('<input ', '<input class=\'form-control\' ', $content);
    }

    if ($field["type"] == 'textarea') {
        $content = str_replace('class=\'textarea', 'class=\'form-control textarea', $content);
    }

    if ($field["type"] == 'select') {
        $content = str_replace('<select ', '<select class=\'form-control\' ', $content);
    }

    if ($field["type"] == 'checkbox') {
        $content = str_replace('li class=\'', 'li class=\'checkbox ', $content);
        $content = str_replace('<input ', '<input style=\'margin-left:1px;\' ', $content);
    }

    if ($field["type"] == 'radio') {
        $content = str_replace('li class=\'', 'li class=\'radio ', $content);
        $content = str_replace('<input ', '<input style=\'margin-left:1px;\' ', $content);
    }

    return $content;
}

/**
 * Adjusting the HTML of the submit button to match design
 *
 *
 * @param $button string required The text string of the button we're editing
 * @param $form array required The whole form object
 *
 * @return string The new HTML for the button
 *
 * @see  gform_submit_button
 * @link https://www.gravityhelp.com/documentation/gravity-forms/extending-gravity-forms/hooks/filters/gform_submit_button/
 */
add_filter('gform_submit_button', 'theme_t_wp_submit_button', 10, 2);

function theme_t_wp_submit_button($button, $form) {
    return "<button id='gform_submit_button_{$form['id']}' class='btn button-green'><span>" . $form['button']['text'] . "</span></button>";
}
