<?php
trait Poeticsoft_Partner_Trait_API {

  public function api_post_list(WP_REST_Request $req) {

    global $wpdb;

    $res = new WP_REST_Response();

    try { 
      
      $meta_key = 'poeticsoft_partner_postmeta_publishable';
      $meta_value = 1;
      $sql = $wpdb->prepare(
          "
          SELECT
              ID, 
              post_name,
              post_title,
              post_type,
              post_mime_type,
              guid
          FROM
              {$wpdb->posts} AS p
          INNER JOIN
              {$wpdb->postmeta} AS pm ON p.ID = pm.post_id
          WHERE
              p.post_type != 'revision'
              AND p.post_status NOT IN ('draft', 'pending', 'private', 'trash', 'auto-draft')
              AND pm.meta_key = %s
              AND pm.meta_value = %s
          ",
          $meta_key,
          $meta_value
      );
      $results = $wpdb->get_results($sql);

      $posts = array_map(
        function($post) {

          if(
            $post->post_type == 'post'
            ||
            $post->post_type == 'page'
          ) {         

            $attachment_id = get_post_thumbnail_id($post->ID);
            $image_data = wp_get_attachment_image_src($attachment_id, 'thumbnail');

            $post->test = $attachment_id;

            if(isset($image_data[0])) {
              
              $post->image = $image_data[0];

            } else {

              $post->image = null;
            }
          }

          $this->log($post);

          return $post;
        },
        $results
      );

      $res->set_data($posts);      

    } catch (Exception $e) {
      
      $res->set_status($e->getCode());
      $res->set_data($e->getMessage());
    }

    return $res;
  }

  public function register_apiroutes() {

  
    add_action(
      'rest_api_init',
      function () {

        register_rest_route(
          'poeticsoft/partner',
          'post/list',
          array(
            array(
              'methods'  => 'GET',
              'callback' => [$this, 'api_post_list'],
              'permission_callback' => '__return_true'
            )
          )
        );
      }
    );
  }
}
