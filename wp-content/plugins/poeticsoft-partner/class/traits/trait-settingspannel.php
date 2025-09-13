<?php
trait Poeticsoft_Partner_Trait_SettingsPanel {

  public function register_settingspanel() {  
    
    add_action( 
      'admin_enqueue_scripts', 
      function () {

        $dir = plugin_dir_path(__FILE__);
        $url = plugin_dir_url(__FILE__);

        wp_enqueue_script(
          'poeticsoft-settingspanel-publish', 
          $url . 'main.js',
          [
            'wp-i18n',
            'wp-core-data',
            'wp-edit-post',
            'wp-element',
            'wp-data',
            'wp-blocks',
            'wp-block-editor',
            'wp-components',
            'wp-plugins'
          ], 
          filemtime($dir . '/main.js'),
          true
        );

        wp_enqueue_style( 
          'poeticsoft-settingspanel-publish',
          $url . 'main.css', 
          [], 
          filemtime($dir . '/main.css'),
          'all' 
        );
      }, 
      15 
    );

    add_action(
      'init', 
      function() {        

        register_post_meta(
          'template', 
          'poeticsoft_template_publish_rules', 
          [
            'show_in_rest' => true,
            'single'       => true,
            'type'         => 'boolean',
            'auth_callback' => '__return_true'
          ] 
        );

        $settingspaneldir = self::$dir . '/settingspanel';
        $settingspanelnames = array_diff(
          scandir($settingspaneldir),
          ['main.php', '..', '.']
        );

        foreach($settingspanelnames as $key => $settingspanelname) {
          
          $settingspaneljsondir = $settingspaneldir . '/' . $settingspanelname;      
          
          require_once($settingspaneljsondir . '/main.php'); 
        }
      },
      5
    );   
  }
}  