<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class FrontPage extends Controller
{

  /**
    * Function Name: Welcome Home()
    * This Function is used to return background, Headline, Subtitle and link For Welcome Section
    * @return array | the value of url image, text and link ACF
    * This function is called in home/section-welcome file
  */
  public function WelcomeHome() {
    $welcome_res = array(
      'image'          => get_field('image_welcome_banner', 'option'),
      'background'     => get_field('image_welcome_background', 'option'),
      'headline'       => get_field('headline_welcome_banner', 'option'),
      'description'    => get_field('sub_headline_welcome_banner', 'option'),
      'link'           => get_field('link_welcome_banner', 'option'),
    );
    return  $welcome_res;
  }

}
