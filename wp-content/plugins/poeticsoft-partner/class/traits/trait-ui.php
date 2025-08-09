<?php
trait Poeticsoft_Partner_Trait_UI {

  public function register_ui() {

    add_action('admin_enqueue_scripts', [$this, 'enqueue_admin']);      
    add_action('admin_menu', [$this, 'add_admin_menu']);
  }

  public function enqueue_admin() {

    $mainjs = 'ui/main.js';
    wp_enqueue_script(
      'poeticsoft-partner-admin-script',
      self::$url . $mainjs ,
      [        
        'wp-i18n',
        'wp-element',
        'wp-data',
        'wp-blocks',
        'wp-block-editor',
        'wp-components'
      ],
      filemtime(self::$path . $mainjs),
      true
   );

    $maincss = 'ui/main.css';
    wp_enqueue_style(
      'poeticsoft-partner-admin-style',
      self::$url . $maincss,
      [
        'wp-components'
      ],
      filemtime(self::$path . $maincss),
   );
  }  

  public function add_admin_menu() {

    add_menu_page(
      'Poeticsoft Partner',
      'Poeticsoft Partner',
      'manage_options',
      'poeticsoft-partner',
      [$this, 'render_admin_page'],
      'dashicons-admin-generic',
      25
   );
  }
  
  public function render_admin_page() {
    ?>
    <div 
      id="PoeticsoftPartnerAdmin" 
      class="wrap"
    ></div>
    <script>

      document.addEventListener('DOMContentLoaded', () => {
        window.PoeticsoftPartnerAdmin &&
        window.PoeticsoftPartnerAdmin('PoeticsoftPartnerAdmin')
      })
    </script>
    <?php
  }
}
