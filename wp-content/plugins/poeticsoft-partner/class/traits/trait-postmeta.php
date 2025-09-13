<?php
trait Poeticsoft_Partner_Trait_PostMeta {

  public function register_postmeta() {      

    register_post_meta(
      'post', 
      'poeticsoft_partner_postmeta_publishable', 
      [
        'show_in_rest' => true,
        'single'       => true,
        'type'         => 'boolean',
        'auth_callback' => '__return_true'
      ] 
   );

    add_action(
      'add_meta_boxes',                  
      [$this, 'poeticsoft_partner_postmeta_publishable_addmetaboxes']
    );
    add_action(
      'save_post',                       
      [$this, 'poeticsoft_partner_postmeta_publishable_savemetabox']
    );
    add_action(
      'edit_attachment',                 
      [$this, 'poeticsoft_partner_postmeta_publishable_savemetabox']
    );
    add_filter(
      'manage_page_posts_columns',       
      [$this, 'poeticsoft_partner_postmeta_publishable_addcolumn']
    );
    add_filter(
      'manage_post_posts_columns',       
      [$this, 'poeticsoft_partner_postmeta_publishable_addcolumn']
    );
    add_filter(
      'manage_media_columns',            
      [$this, 'poeticsoft_partner_postmeta_publishable_addcolumn']
    );
    add_action(
      'manage_page_posts_custom_column', 
      [$this, 'poeticsoft_partner_postmeta_publishable_rendercolumn'], 
      10, 
      2
    );
    add_action(
      'manage_post_posts_custom_column', 
      [$this, 'poeticsoft_partner_postmeta_publishable_rendercolumn'], 
      10, 
      2
    );
    add_action(
      'manage_media_custom_column',      
      [$this, 'poeticsoft_partner_postmeta_publishable_rendercolumn'], 
      10, 
      2
    );
    add_action(
      'admin_enqueue_scripts',           
      [$this, 'poeticsoft_partner_postmeta_publishable_enqueuescript']
    );
    add_action(
      'wp_ajax_update_poeticsoft_partner_postmeta_publishable',  
      [$this, 'poeticsoft_partner_postmeta_publishable_ajaxupdate']
    );
    add_action(
      'quick_edit_custom_box', 
      [$this, 'poeticsoft_partner_postmeta_publishable_quick_edit'],
      10, 
      2
    );
    add_action(
      'admin_footer-edit.php', 
      [$this, 'poeticsoft_partner_postmeta_publishable_quickeditscript']
    );
    add_action(
      'save_post', 
      [$this, 'poeticsoft_partner_postmeta_publishable_quickeditsave']
    );
    add_action(
      'bulk_edit_custom_box', 
      [$this, 'poeticsoft_partner_postmeta_publishable_bulkedit'], 
      10, 
      2
    );
    add_action(
      'save_post', 
      [$this, 'poeticsoft_partner_postmeta_publishable_savebulkedit'], 
      10, 
      2
    );
  }

  public function poeticsoft_partner_postmeta_publishable_addmetaboxes() {

    add_meta_box(
      'poeticsoft_partner_postmeta_publishable_metabox', // ID de la meta box
      'Poeticsoft Partner',
      function ($post) {

        $value = get_post_meta(
          $post->ID, 
          'poeticsoft_partner_postmeta_publishable', 
          true
       );

        echo '<label 
          for="poeticsoft_partner_postmeta_publishable"
        >
          <input 
            type="checkbox" 
            id="poeticsoft_partner_postmeta_publishable" 
            name="poeticsoft_partner_postmeta_publishable" 
            value="1" ' . 
            checked(1, $value, false) . 
            ' 
          />
          Publicable en redes
        </label>';
      },
      [
        'page', 
        'post', 
        'attachment'
      ],
      'side', // side, normal, advanced
      'high'
   );
  }

  public function poeticsoft_partner_postmeta_publishable_savemetabox($post_id) {

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        
      return $post_id;
    }
    
    if (
      isset($_POST['post_type'])
      &&
      'post' == $_POST['post_type'] 
      && 
      !current_user_can('edit_post', $post_id)
   ) {
        
      return $post_id;
    }

    $value = isset($_POST['poeticsoft_partner_postmeta_publishable']) ? '1' : '0';
    update_post_meta(
      $post_id, 
      'poeticsoft_partner_postmeta_publishable', 
      $value
   );
  }

  public function poeticsoft_partner_postmeta_publishable_addcolumn($columns) {
    
    $columns['poeticsoft_partner_postmeta_publishable'] = 'Publicable en redes';
    return $columns;
  }

  public function poeticsoft_partner_postmeta_publishable_rendercolumn(
    $column_name, 
    $post_id
  ) {

    if ($column_name == 'poeticsoft_partner_postmeta_publishable') {

      $value = get_post_meta(
        $post_id, 
        'poeticsoft_partner_postmeta_publishable', 
        true
      );

      $checked = $value == '1' ? 'checked' : '';

      echo '<input 
        type="checkbox" 
        class="poeticsoft_partner_postmeta_publishable_toggle" 
        data-postid="' . $post_id . '" 
        ' . $checked . ' 
      />';
    }
  } 

  public function poeticsoft_partner_postmeta_publishable_enqueuescript() {
    
    $mainjs = 'postmeta/main.js';
    wp_enqueue_script(
      'poeticsoft_partner_postmeta_publishable_script',
      self::$url . $mainjs ,
      [        
        'jquery'
      ],
      filemtime(self::$dir . $mainjs),
      true
   );

    wp_localize_script(
      'poeticsoft_partner_postmeta_publishable_script', 
      'PoeticsoftPartnerPostmetaPublishableAjax', 
      [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('poeticsoft_partner_postmeta_publishable')
      ]
   );
  }

  public function poeticsoft_partner_postmeta_publishable_ajaxupdate() {

    check_ajax_referer(
      'poeticsoft_partner_postmeta_publishable', 
      'nonce'
   );

    $post_id = intval($_POST['post_id']);
    $value = intval($_POST['value']);

    if (!current_user_can('edit_post', $post_id)) {
        
      wp_send_json_error('Permisos insuficientes');
    }

    update_post_meta(
      $post_id, 
      'poeticsoft_partner_postmeta_publishable', 
      $value
   );

    wp_send_json_success();
  }

  public function poeticsoft_partner_postmeta_publishable_quick_edit(
    $column_name, 
    $post_type
  ) {

    if ($column_name == 'poeticsoft_partner_postmeta_publishable') {

      echo '<fieldset class="inline-edit-col-right">
        <div class="inline-edit-col">
          <label class="poeticsoft_partner_postmeta_publishable_inline-edit">
            <input 
              type="checkbox" 
              name="poeticsoft_partner_postmeta_publishable" 
              value="1" 
            />
            <span class="checkbox-title">
              Publicable en redes
            </span>
          </label>
        </div>
      </fieldset>';
    }
  }

  public function poeticsoft_partner_postmeta_publishable_quickeditscript() {

    ?>
    <script type="text/javascript">
      jQuery(document)
      .ready(function($) {

        $('#the-list')
        .on(
          'click', 
          '.editinline', 
          function() {

            var post_id = $(this)
            .closest('tr')
            .attr('id')
            .replace('post-', '');

            var flag = $('#post-' + post_id)
            .find('.poeticsoft_partner_postmeta_publishable_toggle')
            .is(':checked') ? '1' : '0';

            $('.inline-edit-row')
            .find('input[name="poeticsoft_partner_postmeta_publishable"]')
            .prop('checked', (flag === '1'));
        });

        // Guardar el campo
        $('#bulk_edit')
        .on(
          'click', 
          function() {

            var post_ids = new Array();

            $('#the-list input[name="post[]"]:checked')
            .each(function() {
                
              post_ids.push($(this).val());
            });

            var flag_value = $('.inline-edit-row input[name="poeticsoft_partner_postmeta_publishable"]')
            .is(':checked') ? '1' : '0';

            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                  action: 'quick_edit_update_my_boolean_flag',
                  post_ids: post_ids,
                  flag_value: flag_value,
                  nonce: '<?php echo wp_create_nonce('my_boolean_flag_quick_edit_nonce'); ?>'
                }
            });
        });
      });
    </script>
    <?php
  }

  public function poeticsoft_partner_postmeta_publishable_quickeditsave($post_id) {

    if (!current_user_can('edit_post', $post_id)) {

      return;
    }

    if (isset($_POST['poeticsoft_partner_postmeta_publishable'])) {

      update_post_meta(
        $post_id, 
        'poeticsoft_partner_postmeta_publishable', 
        '1'
      );

    } else {

      update_post_meta(
        $post_id, 
        'poeticsoft_partner_postmeta_publishable', 
        '0'
      );
    }
  }

  public function poeticsoft_partner_postmeta_publishable_bulkedit(
    $column_name, 
    $post_type
  ) {

    if ($column_name == 'poeticsoft_partner_postmeta_publishable') {

      echo '<fieldset class="inline-edit-col-right">
        <div class="inline-edit-col">
          <label class="inline-edit-poeticsoft_partner_postmeta_publishable">
            <span class="checkbox-title">
              Publicar en redes
            </span>
            <select
              name="poeticsoft_partner_postmeta_publishable"
            >
              <option value="nocambiar">-- Sin cambios --</option>
              <option value="activar">Si</option>
              <option value="desactivar">No</option>
            </select>
          </label>
        </div>
      </fieldset>';
    }
  }

  public function poeticsoft_partner_postmeta_publishable_savebulkedit($data) {

    if (
      !isset($_REQUEST['bulk_edit']) 
      || 
      !$_REQUEST['bulk_edit'] 
      || 
      !current_user_can('edit_posts')
    ) {

      return;
    }

    if (
      isset($_REQUEST['poeticsoft_partner_postmeta_publishable'])
      &&
      isset($_REQUEST['post'])
      &&
      is_array($_REQUEST['post'])
      &&
      count($_REQUEST['post'])
    ) {

      foreach($_REQUEST['post'] as $post_id) {

        if('activar' == $_REQUEST['poeticsoft_partner_postmeta_publishable']) {

          update_post_meta(
            $post_id, 
            'poeticsoft_partner_postmeta_publishable', 
            '1'
          );

        } else if ('desactivar' == $_REQUEST['poeticsoft_partner_postmeta_publishable']) {

          update_post_meta(
            $post_id, 
            'poeticsoft_partner_postmeta_publishable', 
            '0'
          );
        }
      }
    } 
  }
}