<?php
trait Poeticsoft_Partner_Trait_Jitsi_Setup {  

  public function register_jitsi_setup() {

    add_filter(
      'admin_init', 
      function () {

        $fields = [     

          'jitsi_appid' => [
            'title' => 'Jitsi APP ID',
            'value' => ''
          ], 

          'jitsi_apikey' => [
            'title' => 'Jitsi API Key',
            'value' => ''
          ],    

          'jitsi_privatekey' => [
            'title' => 'Jitsi Private Key',
            'value' => '',
            'type' => 'textarea'
          ] 
        ];

        foreach($fields as $key => $field) {

          register_setting(
            'general', 
            'poeticsoft_partner_settings_' . $key
          );

          add_settings_field(
            'poeticsoft_partner_' . $key, 
            '<label for="poeticsoft_partner_settings_' . $key . '">' . 
              __($field['title']) .
            '</label>',
            function () use ($key, $field){

              $value = get_option('poeticsoft_partner_settings_' . $key, $field['value']);

              if(isset($field['type'])) {

                if('checkbox' == $field['type']) {

                  echo '<input type="checkbox" 
                              id="poeticsoft_partner_settings_' . $key . '" 
                              name="poeticsoft_partner_settings_' . $key . '" 
                              class="regular-text"
                              ' . ($value ? 'checked="chedked"' : '') . ' />';

                }   

                if('textarea' == $field['type']) {

                  echo '<textarea
                          id="poeticsoft_partner_settings_' . $key . '" 
                          name="poeticsoft_partner_settings_' . $key . '" 
                          class="regular-text"
                        >' . 
                          $value . 
                        '</textarea>';
                }   
                
              } else {

                echo '<input type="text" 
                            id="poeticsoft_partner_settings_' . $key . '" 
                            name="poeticsoft_partner_settings_' . $key . '" 
                            class="regular-text"
                            value="' . $value . '" />';
              }
            },
            'general'
          );  
        }  
      }
    );

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
