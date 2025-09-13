<?php
trait Poeticsoft_Partner_Trait_PostList {

  public function add_postlist_details() { 

    add_filter(
      'manage_template_posts_columns',       
      [$this, 'postlist_addcolumn_image']
    );
    add_action(
      'manage_template_posts_custom_column', 
      [$this, 'postlist_rendercolumn_image'], 
      10, 
      2
    );    
    add_action(
      'admin_head', 
      [$this, 'postlist_column_width'], 
      10, 
      2
    );
  }

  public function postlist_addcolumn_image($columns) {
    
    $columns['post_image'] = 'Imagen';
    return $columns;
  }

  public function postlist_rendercolumn_image(
    $column_name, 
    $post_id
  ) {

    if ($column_name == 'post_image') {      

      $attachment_id = get_post_thumbnail_id($post_id);
      $image_data = wp_get_attachment_image_src($attachment_id, 'thumbnail');

      if(isset($image_data[0])) {
        
        echo '<img src="' . $image_data[0] . '" style="width: 80px" />';

      } else {

        echo '<p>Sin imagen</p>';
      }
    }
  } 
  
  public function postlist_column_width() {

    $screen = get_current_screen();
    if ($screen->post_type === 'template') {

      echo '<style>
        .column-post_image { 
          width: 120px;
          max-width: 120px;
          text-align: left;
        }
      </style>';
    }
  } 
}
