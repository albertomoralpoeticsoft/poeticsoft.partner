<?php
trait Poeticsoft_Partner_Trait_Campaign_List {

  public function register_campaign_list() {

    add_filter('manage_campaign_posts_columns', [$this, 'campaign_addcolumns']);
    add_action('manage_campaign_posts_custom_column', [$this, 'campaign_rendercolumns'], 10, 2);    
    add_action('admin_head', [$this, 'campaign_column_width'], 10, 2);
    add_filter('manage_edit-campaign_sortable_columns', [$this, 'campaign_sortable_columns']);
  }

  public function campaign_addcolumns($columns) {  

    $new_columns = [];
    foreach ($columns as $key => $value) {

      $new_columns[$key] = $value;

      if ($key === 'date') {
          
        $new_columns['campaignterm'] = 'Categories';
        $new_columns['campaign_image'] = 'Imagen';
      }
    }
    return $new_columns;
  }

  public function campaign_rendercolumns(
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

    if ($column_name === 'campaignterm') {

      $terms = get_the_terms($post_id, 'campaignterm');
      if(!empty($terms) && !is_wp_error($terms)) {

          $links = [];
          foreach ($terms as $term) {

            $links[] = sprintf(
              '<a href="%s">%s</a>',
              esc_url(add_query_arg([
                'post_type'    => 'campaign',
                'campaignterm' => $term->slug,
              ], 'edit.php')),
              esc_html($term->name)
            );
          }
          echo implode(', ', $links);
      } else {

        echo __('—');
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

  public function campaign_sortable_columns($columns) {

    $columns['campaignterm'] = 'campaignterm';
    $columns['campaign_image'] = 'campaign_image';

    return $columns;
  }
}
