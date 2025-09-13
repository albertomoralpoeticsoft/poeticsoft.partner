<?php
trait Poeticsoft_Partner_Trait_Block {  

  public function register_block() {

    add_filter(
      'block_categories_all', 
      function (
        $categories, 
        $post 
      ) {

        return array_merge(
          [
            [
              'slug'  => 'poeticsoft',
              'title' => __( 'Poeticsoft', 'poeticsoft' ),
              'icon'  => 'superhero'
            ],
          ],
          $categories      
        );
      }, 
      10, 
      2 
    );

    add_action(
      'init', 
      function() {

        $blockdir = self::$dir . 'block';
        $blocknames = array_diff(
          scandir($blockdir),
          ['main.php', '..', '.']
        );

        foreach($blocknames as $key => $blockname) {
          
          $blockjsondir = $blockdir . '/' . $blockname;

          $registered = register_block_type($blockjsondir);
        }
      },
      5
    );
  }
}