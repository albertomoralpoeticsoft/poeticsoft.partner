<?php
trait Poeticsoft_Partner_Trait_Campaign_Postlist {

  public function register_campaign_postlist() {

    add_filter(
      'manage_campaign_posts_columns',       
      [$this, 'campaign_addcolumn_image']
    );
    add_action(
      'manage_campaign_posts_custom_column', 
      [$this, 'campaign_rendercolumn_image'], 
      10, 
      2
    );    
    add_action(
      'admin_head', 
      [$this, 'campaign_column_width'], 
      10, 
      2
    );
  }

  public function campaign_addcolumn_image($columns) {
    
    $columns['campaign_image'] = 'Imagen';
    return $columns;
  }

  public function campaign_rendercolumn_image(
    $column_name, 
    $post_id
  ) {

    if ($column_name == 'campaign_image') {      

      $attachment_id = get_post_thumbnail_id($post_id);
      $image_data = wp_get_attachment_image_src($attachment_id, 'thumbnail');

      if(isset($image_data[0])) {
        
        echo '<img src="' . $image_data[0] . '" style="width: 80px" />';

      } else {

        echo '<p>Sin imagen</p>';
      }
    }
  } 
  
  public function campaign_column_width() {

    $screen = get_current_screen();
    if ($screen->post_type === 'campaign') {

      echo '<style>
        .column-campaign_image { 
          width: 120px;
          max-width: 120px;
          text-align: left;
        }

        .column-campaign_image img { 
          border: solid 1px #cccccc;
        }
      </style>';
    }
  } 
}
