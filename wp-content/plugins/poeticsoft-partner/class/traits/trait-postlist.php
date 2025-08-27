<?php
trait Poeticsoft_Partner_Trait_PostList {

  public function add_postlist_details() { 

    add_filter(
      'manage_page_posts_columns',       
      [$this, 'postlist_addcolumn_image']
    );
    add_filter(
      'manage_post_posts_columns',       
      [$this, 'postlist_addcolumn_image']
    );
    add_action(
      'manage_page_posts_custom_column', 
      [$this, 'postlist_rendercolumn_image'], 
      10, 
      2
    );
    add_action(
      'manage_post_posts_custom_column', 
      [$this, 'postlist_rendercolumn_image'], 
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
}
