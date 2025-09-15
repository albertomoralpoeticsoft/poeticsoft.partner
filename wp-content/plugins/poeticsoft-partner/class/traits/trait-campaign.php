<?php
trait Poeticsoft_Partner_Trait_Campaign {  

  // ID Instagram 
  // poetic.soft
  // 17841477384731714
  // IGAASbQAplbwpBZAE1LbU1uTXRRd0MwT1JBTHBIQm13NmU4YkVyZAmxSYVNuY3F2MWFybFp4ampER2F2Q1hRZAWpkSURqTmlMcnJjTkd3bGF1eEVwMlU0cXdrN2ZAmbU1xOG9uMWg3OC04TUwzYmlvb1VnWG4waFlnZAzlNbU9sOVZA1YwZDZD

  public function register_campaign() {

    add_action(
      'init',
      function () {

        $args = array(
          'public' => true,
          'show_ui' => true, 
          'show_in_menu' => 'poeticsoft-partner',
          'menu_position' => 3,
          'labels' => array(
            'name' => __('Campaigns'),
            'singular_name' => __('Campaign')
          ),
          'supports' => array(
            'title',
            'editor',
            'thumbnail',
            'revisions',
            'excerpt',
          ),
          'template' => array(
            array('poeticsoft/campaignmedia', array()),
            // array('poeticsoft/campaigncompose', array()),
            // array('poeticsoft/campaigntext', array()),
            // array('poeticsoft/campaignprogram', array())
          ),
          'template_lock' => 'all',
          'show_in_rest' => true
        );

        register_post_type(
          'campaign',
          $args
        );

        register_taxonomy(
          'campaignterm', 
          'campaign', 
          array(
          'hierarchical'       => true,
          'labels'             => array(
            'name'             => __('Campaigns categories'),
            'singular_name'    => __('Campaigns category'),
            'search_items'     => __('Search by category'),
            'all_items'        => __('All categories'),
            'parent_item'      => __('Parent category'),
            'parent_item_colon'=> __('Parent category:'),
            'edit_item'        => __('Edit category'),
            'update_item'      => __('Update category'),
            'add_new_item'     => __('Add new category'),
            'new_item_name'    => __('New category name')
          ),
          'public'             => true,
          'show_ui'            => true,
          'show_in_menu'       => true,
          'show_in_nav_menus'  => true,
          'show_in_rest'       => true,
          'show_in_quick_edit' => true,
          'query_var'          => true,
          'rewrite'            => array('slug' => 'campaignterm'),
        ));
      }, 
      30
    );

    add_action(
      'admin_menu', 
      function () { 

        add_submenu_page(
          'poeticsoft-partner', 
          __('Campaign categories'), 
          __('Campaign categories'), 
          'manage_categories', 
          'edit-tags.php?taxonomy=campaignterm&post_type=campaign'
        ); 
      } 
    ); 

    add_action(
      'parent_file', 
      function ($parent_file) {
        
        global $current_screen;

        if (
          $current_screen->taxonomy === 'campaignterm' 
          && 
          $current_screen->post_type === 'campaign'
        ) {

          $parent_file = 'poeticsoft-partner';
        }

        return $parent_file;
      }
    );

    add_action(
      'submenu_file', 
      function ($submenu_file) {

        global $current_screen;

        if (
          $current_screen->taxonomy === 'campaignterm' 
          && 
          $current_screen->post_type === 'campaign'
        ) {
            
          $submenu_file = 'edit-tags.php?taxonomy=campaignterm&post_type=campaign';
        }

        return $submenu_file;
      }
    );

    add_action(
      'restrict_manage_posts',
      function ($posttype) {

        if ($posttype == 'campaign') {

          $taxonomyslug = 'campaignterm';
          $taxonomy = get_taxonomy($taxonomyslug);
          $selected = isset( $_REQUEST[$taxonomyslug] ) ? $_REQUEST[$taxonomyslug] : '';
          
          wp_dropdown_categories(array(
            'show_option_all' =>  $taxonomy->labels->all_items,
            'taxonomy'        =>  $taxonomyslug,
            'name'            =>  $taxonomyslug,
            'orderby'         =>  'name',
            'selected'        =>  $selected,
            'value_field'     =>  'slug',
            'hierarchical'    =>  true,
            'depth'           =>  5,
            'show_count'      =>  true,
            'hide_empty'      =>  false
          ));
        }
      }
    );

    add_filter(
      'allowed_block_types_all',
      function ($allowed_blocks, $context) {
        
        if($context->post->post_type == 'campaign') {
          
          $allowed_blocks = array();

          $allowed_blocks[] = 'poeticsoft/campaignmedia';
        }
      
        return $allowed_blocks;
      },
      10,
      2
    );
  }
}