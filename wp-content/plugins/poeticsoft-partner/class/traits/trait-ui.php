<?php
trait Poeticsoft_Partner_Trait_UI {

  public function register_ui() {

    add_action('admin_enqueue_scripts', [$this, 'enqueue_admin']);      
    add_action('admin_menu', [$this, 'add_admin_menu']);
  }

  public function enqueue_admin() {

    $mainjs = 'ui/admin/main.js';
    wp_enqueue_script(
      'poeticsoft-partner-admin-script',
      self::$url . $mainjs ,
      [        
        'jquery'
      ],
      filemtime(self::$dir . $mainjs),
      true
    );

    $maincss = 'ui/admin/main.css';
    wp_enqueue_style(
      'poeticsoft-partner-admin-style',
      self::$url . $maincss,
      [
        
      ],
      filemtime(self::$dir . $maincss),
    );
  }  

  public function add_admin_menu() {

    add_menu_page(
      'Poeticsoft Partner',
      'Poeticsoft',
      'manage_options',
      'poeticsoft-partner',
      '',
      'dashicons-images-alt2',
      25
    );
  }
}
