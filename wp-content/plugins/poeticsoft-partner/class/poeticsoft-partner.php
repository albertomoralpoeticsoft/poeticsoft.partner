<?php

require_once __DIR__ . '/traits/trait-ui.php';

class Poeticsoft_Partner {

  use Poeticsoft_Partner_Trait_UI;

  private static $instance = null;
  public static $path;
  public static $url;

  public static function get_instance() {

    if (self::$instance === null) {

      self::$instance = new self();
    }

    return self::$instance;
  }

  private function __construct() {

    $this->set_vars();
    
    $this->register_ui();
  }

  private function set_vars() {

    self::$path = plugin_dir_path(dirname(__FILE__));
    self::$url  = plugin_dir_url(dirname(__FILE__));
  }

  public function log($display, $withdate = false) { 

    $text = is_string($display) ? 
    $display 
    : 
    json_encode($display, JSON_PRETTY_PRINT);

    $message = $withdate ? 
    date("d-m-y h:i:s") . PHP_EOL
    :
    '';

    $message .= $text . PHP_EOL;

    file_put_contents(
      WP_CONTENT_DIR . '/plugin_log.txt',
      $message,
      FILE_APPEND
    );
  }
}
