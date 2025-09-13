<?php
trait Poeticsoft_Partner_Trait_Piece {  

  public function register_piece() {

    add_action(
      'init',
      function () {

        $args = array(
          'public' => true,
          'show_ui' => true, 
          'show_in_menu' => 'poeticsoft-partner',
          'menu_position' => 3,
          'labels' => array(
            'name' => __('Pieces'),
            'singular_name' => __('Piece')
          ),
          'supports' => array(
            'title',
            'editor',
            'thumbnail',
            'revisions',
            'excerpt',
          ),
          'template' => array(
            array('poeticsoft/piecemedia', array()),
            array('poeticsoft/piececompose', array()),
            array('poeticsoft/piecetext', array()),
            array('poeticsoft/pieceprogram', array())
          ),
          'template_lock' => 'all',
          'show_in_rest' => true
        );

        register_post_type(
          'piece',
          $args
        );

        register_taxonomy(
          'pieceterm', 
          'piece', 
          array(
          'hierarchical'       => true,
          'labels'             => array(
            'name'             => __('Pieces categories'),
            'singular_name'    => __('Pieces category'),
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
          'rewrite'            => array('slug' => 'pieceterm'),
        ));
      }, 
      30
    );

    add_action(
      'admin_menu', 
      function () { 

        add_submenu_page(
          'poeticsoft-partner', 
          __('Piece categories'), 
          __('Piece categories'), 
          'manage_categories', 
          'edit-tags.php?taxonomy=pieceterm&post_type=piece'
        ); 
      } 
    ); 

    add_action(
      'parent_file', 
      function ($parent_file) {
        
        global $current_screen;

        if (
          $current_screen->taxonomy === 'pieceterm' 
          && 
          $current_screen->post_type === 'piece'
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
          $current_screen->taxonomy === 'pieceterm' 
          && 
          $current_screen->post_type === 'piece'
        ) {
            
          $submenu_file = 'edit-tags.php?taxonomy=pieceterm&post_type=piece';
        }

        return $submenu_file;
      }
    );

    add_action(
      'restrict_manage_posts',
      function ($posttype) {

        if ($posttype == 'piece') {

          $taxonomyslug = 'pieceterm';
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
        
        if($context->post->post_type == 'piece') {
          
          $allowed_blocks = array();

          $allowed_blocks[] = 'poeticsoft/piecemedia';
        }
      
        return $allowed_blocks;
      },
      10,
      2
    );
  }
}