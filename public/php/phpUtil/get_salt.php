<?php
function get_salt()
{
  $filepath = $_SERVER['DOCUMENT_ROOT'] . "/../salt.txt";
  $file = fopen($filepath);
  $text = fread($file, filesize($filepath));
  return trim($text);
}
?>
