<?php
function get_all_form_fields($form_id){
  $form = RGFormsModel::get_form_meta($form_id);
  $fields = array();
  if(is_array($form["fields"])){
    foreach($form["fields"] as $field){
      // dd($field);
      if ($field["populateTaxonomy"]) {
        $taxonomy = true;
      } else {
        $taxonomy = false;
      }

      if ($field["defaultValue"]) {
        $default = true;
      } else {
        $default = false;
      }

      $fields[] = [
        'type' => $field['type'],
        'id' => $field['id'],
        'label' => $field["label"],
        'taxonomy' => $taxonomy,
        'custom' => $field["populateTaxonomy"],
        'choices' => $field["choices"],
        'default' => $default,
        'defaultValue' => $field["defaultValue"],
      ];
    }
  }
  return $fields;
}
