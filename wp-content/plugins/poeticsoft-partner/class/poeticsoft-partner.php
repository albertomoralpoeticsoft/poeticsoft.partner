<?php

require_once __DIR__ . '/traits/trait-api.php';
require_once __DIR__ . '/traits/trait-ui.php';
require_once __DIR__ . '/traits/trait-postmeta.php';
require_once __DIR__ . '/traits/trait-postlist.php';

class Poeticsoft_Partner {

  use Poeticsoft_Partner_Trait_API;
  use Poeticsoft_Partner_Trait_UI;
  use Poeticsoft_Partner_Trait_PostMeta;
  use Poeticsoft_Partner_Trait_PostList;

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
    $this->register_postmeta();
    $this->register_apiroutes();
    $this->add_postlist_details();
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
      self::$path . '/log.txt',
      $message,
      FILE_APPEND
    );
  }
}
