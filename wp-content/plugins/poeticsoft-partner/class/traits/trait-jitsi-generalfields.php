<?php
trait Poeticsoft_Partner_Trait_Jitsi_Generalfields {  

  public function register_jitsi_generalfields() {

    add_filter(
      'admin_init', 
      function () {

        add_settings_section(
          'poeticsoft_partner_settings_jitsi', 
          '👩‍💻 Ajustes de conexión a Jitsi (Partner)',
          function() {
              echo '<p>Configura la conexión con el servicio de videoconferencias.</p>';
          },
          'general'
        );

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
            'general',
            'poeticsoft_partner_settings_jitsi'
          );  
        }  
      }
    );
  }
}
