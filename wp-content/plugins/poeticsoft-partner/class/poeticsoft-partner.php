<?php

require_once __DIR__ . '/traits/trait-api.php';
require_once __DIR__ . '/traits/trait-ui.php';
require_once __DIR__ . '/traits/trait-campaign.php';
require_once __DIR__ . '/traits/trait-campaign-postlist.php';
require_once __DIR__ . '/traits/trait-campaign-meta.php';
require_once __DIR__ . '/traits/trait-block.php';
require_once __DIR__ . '/traits/trait-jitsi.php';
require_once __DIR__ . '/traits/trait-jitsi-api.php';
require_once __DIR__ . '/traits/trait-jitsi-setup.php';
require_once __DIR__ . '/traits/trait-jitsi-shortcode.php';

// require_once __DIR__ . '/traits/trait-settingspannel.php';
// require_once __DIR__ . '/traits/trait-postmeta.php';

class Poeticsoft_Partner {

  use Poeticsoft_Partner_Trait_API;
  use Poeticsoft_Partner_Trait_UI;
  use Poeticsoft_Partner_Trait_Campaign;
  use Poeticsoft_Partner_Trait_Campaign_PostList;
  use Poeticsoft_Partner_Trait_Campaign_Meta;
  use Poeticsoft_Partner_Trait_Block;
  use Poeticsoft_Partner_Trait_Jitsi;
  use Poeticsoft_Partner_Trait_Jitsi_API;
  use Poeticsoft_Partner_Trait_Jitsi_Setup;
  use Poeticsoft_Partner_Trait_Jitsi_Shortcode;

  // use Poeticsoft_Partner_Trait_SettingsPanel;
  // use Poeticsoft_Partner_Trait_PostMeta;

  private static $instance = null;
  public static $dir;
  public static $url;

  public static function get_instance() {

    if (self::$instance === null) {

      self::$instance = new self();
    }

    return self::$instance;
  }

  private function __construct() {

    $this->set_vars();    

    /* Conditional load of tools */

    $this->register_ui();
    $this->register_api();
    $this->register_campaign();
    $this->register_campaign_postlist();
    $this->register_campaign_meta();
    $this->register_block();
    $this->register_jitsi();
    $this->register_jitsi_api();
    $this->register_jitsi_setup();
    $this->register_jitsi_shortcode();
    
    // $this->register_settingspanel();
    // $this->register_postmeta();
  }

  private function set_vars() {

    self::$dir = plugin_dir_path(dirname(__FILE__));
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
      self::$dir . '/log.txt',
      $message,
      FILE_APPEND
    );
  }

  public function slugify($text) {
  
    $text = strtolower($text);
    $text = preg_replace('~[^\\pL\\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT//IGNORE', $text);
    $text = preg_replace('~-+~', '-', $text);
    if (empty($text)) {
        
      return 'n-a';
    }
    
    return $text;
  }
}
