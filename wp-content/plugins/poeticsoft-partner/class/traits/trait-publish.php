<?php
trait Poeticsoft_Partner_Trait_Publish {

  public function register_publish() {  
    
    add_action( 
      'admin_enqueue_scripts', 
      function () {

        wp_enqueue_script(
          'poeticsoft-partner-publish', 
          self::$url . '/ui/publish/post/main.js',
          [
            'lodash',
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
          filemtime(self::$dir . '/ui/publish/post/main.js'),
          true
        );

        wp_enqueue_style( 
          'poeticsoft-partner-publish',
          self::$url . '/ui/publish/post/main.css', 
          [], 
          filemtime(self::$dir . '/ui/publish/post/main.css'),
          'all' 
        );
      }, 
      15 
    ); 
  }
}  