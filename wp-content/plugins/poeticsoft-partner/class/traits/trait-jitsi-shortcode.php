<?php
  
trait Poeticsoft_Partner_Trait_Jitsi_Shortcode {

  public function register_jitsi_shortcode() {

    add_shortcode(
      'jitsi',
      function ($atts) {

        global $post;

        $posttitle = $post ? $post->post_title : 'no post';

        $connecttext = isset($atts['connect']) ?
          $atts['connect']
          :
          'Conectar';
        $invalidtext = isset($atts['invalid']) ? 
          $atts['invalid'] 
          :  
          'Escribe una dirección de correo válida';
        $errortext = isset($atts['error']) ? 
          $atts['error'] 
          :  
          'Error conectando, vuelve a intentarlo, por favor.';
        $oktext = isset($atts['ok']) ? 
          $atts['ok'] 
          :  
          'Conectando...';

        return '<div class="shortcode jitsi">
          <form>
            <div class="field">
              <input 
                id="email"
                name="email"
                type="email"
                data-message-invalid="'. $invalidtext . '" 
                data-message-error="'. $errortext . '"  
                data-message-ok="'. $oktext . '" 
                required 
              />
              <input
                id="title"
                name="title"
                type="hidden"
                value="' . $posttitle . '"
              />
            </div>      
            <div class="wp-block-button">
              <a 
                class="wp-block-button__link wp-element-button disabled" 
                href="#Init"
              >'
              . $connecttext .
              '</a>
            </div>
          </form>
          <div class="message"></div>
        </div>';
      }
    );
  }
}
