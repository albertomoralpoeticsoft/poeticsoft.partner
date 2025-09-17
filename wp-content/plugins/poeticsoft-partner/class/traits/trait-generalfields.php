<?php
trait Poeticsoft_Partner_Trait_Generalfields {  

  public function register_generalfields() {

    add_filter(
      'admin_init', 
      function () {

        add_settings_section(
          'poeticsoft_partner_settings_manager', 
          '⚙️ Ajustes de conexión al Manager (Partner)',
          function() {
              echo '<p>Datos del manager para el control de acceso y utils.</p>';
          },
          'general'
        );

        $fields = [ 

          'manager_api_url' => [
            'hidden' => true,
            'title' => 'Api Url',
            'value' => 'https://poeticsoft.com/wp-json/manager',
            'section' => 'poeticsoft_partner_settings_manager'
          ]
        ];

        foreach($fields as $key => $field) {

          register_setting(
            'general', 
            'poeticsoft_partner_settings_' . $key,
            [
              'type' => 'string',
              'default' => $field['value'],
              'show_in_rest' => true
            ]
          );

          // if(isset($field['hidden'])) { continue; }

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
            $field['section']
          );  
        }  
      }
    );
  }
}
