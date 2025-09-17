<?php
trait Poeticsoft_Partner_Trait_Jitsi_UI {  

  public function register_jitsi_ui() {

    add_action( 
      'wp_enqueue_scripts', 
      function () {

        wp_enqueue_script(
          'poeticsoft-partner-jitsi-validate', 
          self::$url . '/ui/jquery.validate.min.js',
          [
            'jquery',
            'jquery-form'
          ], 
          filemtime(self::$dir . '/ui/jquery.validate.min.js'),
          true
        );

        wp_enqueue_script(
          'poeticsoft-partner-jitsi', 
          self::$url . '/ui/jitsi/main.js',
          [
            'poeticsoft-partner-jitsi-validate'
          ], 
          filemtime(self::$dir . '/ui/jitsi/main.js'),
          true
        );

        wp_enqueue_style( 
          'poeticsoft-partner-jitsi',
          self::$url . '/ui/jitsi/main.css', 
          [], 
          filemtime(self::$dir . '/ui/jitsi/main.css'),
          'all' 
        );
      }, 
      999 
    );
  }
}
