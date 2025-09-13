<?php

require_once(WP_PLUGIN_DIR . '/poeticsoft-partner/tools/firebase/vendor/autoload.php');

use Firebase\JWT\JWT;

trait Poeticsoft_Partner_Trait_Jitsi_API {  

  public function register_jitsi_api() {

    add_action(
      'rest_api_init',
      function () {

        register_rest_route(
          'poeticsoft/partner',
          'jitsi/jwt',
          array(
            array(
              'methods'  => 'POST',
              'callback' => [$this, 'api_jitsi_jwt'],
              'permission_callback' => '__return_true'
            )
          )
        );
      }
    );
  }

  public function api_jitsi_jwt(WP_REST_Request $req) {
    
    $res = new WP_REST_Response();

    try {    
      
      $apikey = get_option('poeticsoft_partner_settings_jitsi_apikey', false);
      $appid = get_option('poeticsoft_partner_settings_jitsi_appid', false);
      $privatekey = get_option('poeticsoft_partner_settings_jitsi_privatekey', false);

      if(!$apikey && !$appid && !$privatekey) {

        throw new Exception('Faltan key|id|pk', 500);
      }

      $params = $req->get_params();
      $email = $params['email'];
      $title = $params['title'];
      $userid = $this->slugify($email);
      $username = ucwords(
        str_replace(
          '-', 
          ' ', 
          $this->slugify(
            strstr(
              $email, 
              "@", 
              true
            )
          )
        )
      );

      // $res->set_data([
      //   'email' => $email,
      //   'title' => $title,
      //   'userid' => $userid,
      //   'username' => $username,
      //   'pkey' => $privatekey
      // ]);

      // return $res;

      $API_KEY = $apikey;
      $APP_ID = $appid; 
      $USER_EMAIL = $email;
      $USER_NAME = $username;
      $USER_IS_MODERATOR = true;
      $USER_AVATAR_URL = 'https://poeticsoft.com/wp-content/uploads/2025/07/picto-a.png';
      $USER_ID = $email;
      $LIVESTREAMING_IS_ENABLED = true;
      $RECORDING_IS_ENABLED = true;
      $OUTBOUND_IS_ENABLED = false;
      $TRANSCRIPTION_IS_ENABLED = false;
      $EXP_DELAY_SEC = 7200;
      $NBF_DELAY_SEC = 0;

      function create_jaas_token(
        $api_key,
        $app_id,
        $user_email,
        $user_name,
        $user_is_moderator,
        $user_avatar_url,
        $user_id,
        $live_streaming_enabled,
        $recording_enabled,
        $outbound_enabled,
        $transcription_enabled,
        $exp_delay,
        $nbf_delay,
        $privatekey
      ) {

        $payload = array(
          'iss' => 'chat',
          'aud' => 'jitsi',
          'exp' => time() + $exp_delay,
          'nbf' => time() - $nbf_delay,
          'room'=> '*',
          'sub' => $app_id,
          'context' => [
            'user' => [
              'moderator' => $user_is_moderator ? 'true' : 'false',
              'email' => $user_email,
              'name' => $user_name,
              'avatar' => $user_avatar_url,
              'id' => $user_id
            ],
            'features' => [
              'recording' => $recording_enabled ? 'true' : 'false',
              'livestreaming' => $live_streaming_enabled ? 'true' : 'false',
              'transcription' => $transcription_enabled ? 'true' : 'false',
              'outbound-call' => $outbound_enabled ? 'true' : 'false'
            ]
          ]
        );

        return JWT::encode(
          $payload, 
          $privatekey, 
          'RS256', 
          $api_key
        );
      }

      $token = create_jaas_token(
        $API_KEY,
        $APP_ID,
        $USER_EMAIL,
        $USER_NAME,
        $USER_IS_MODERATOR,
        $USER_AVATAR_URL,
        $USER_ID,
        $LIVESTREAMING_IS_ENABLED,
        $RECORDING_IS_ENABLED,
        $OUTBOUND_IS_ENABLED,
        $TRANSCRIPTION_IS_ENABLED,
        $EXP_DELAY_SEC,
        $NBF_DELAY_SEC,
        $privatekey
      );

      $res->set_data([
        'appid' => $appid,
        'jwt' => $token,
        'room' => $title,
        'userid' => $userid,
        'username' => $username
      ]);

    } catch (Exception $e) {
      
      $res->set_status($e->getCode());
      $res->set_data($e->getMessage());
    }

    return $res;
  }
}
