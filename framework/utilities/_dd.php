<?php
/**
* Function Name: DD - dd();
* This dd function dumps the given variables and ends execution of the script with simple style
* @param ($args)
* @return (Wow)
*/
function dump(...$objects) {
  echo "<pre class='pre-dd'>";
  foreach ($objects as $object) {
    ?>
    <style media="screen">
    .pre-dd{
      direction: ltr;
      display: block;
      padding: 9.5px;
      margin: 0 0 10px;
      font-size: 13px;
      line-height: 1.42857143;
      color: #333;
      word-break: break-all;
      word-wrap: break-word;
      background-color: #f5f5f5;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    </style>
    <?php
    var_dump($object);
    echo "\n";
  }
  echo "</pre>";
  die();
}
