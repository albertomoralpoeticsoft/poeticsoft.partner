<?php
trait Poeticsoft_Partner_Trait_Campaign_Media {

  public function register_campaign_media() { 
    
    add_filter('manage_upload_columns', [$this, 'media_uploadcolumn']);
    add_action('manage_media_custom_column', [$this, 'media_customcolumn'], 10, 2);
    add_action('wp_ajax_update_media_campaigns', [$this, 'media_update_campaigns']);
  }

  public function media_uploadcolumn($columns) {

    $columns['campaigns'] = 'Campañas';
    return $columns;
  }

  public function media_customcolumn($column_name, $attachment_id) {
    
    if ($column_name === 'campaigns') {
      
      $campaigns = get_posts(['post_type'=>'campaign', 'posts_per_page'=>-1]);
      $atachmentcampaigns = get_post_meta(
        $attachment_id, 
        'poeticsoft_partner_campaign_media_campaigns', 
        true
      );

      echo '<div 
        class="poeticsoft_partner_campaign_media_campaigns"
        data-attachment="' . $attachment_id . '"
      >' . 
        implode(
          '',
          (
            array_map(
              function($camp) use ($attachment_id, $atachmentcampaigns) {

                $hascampaign = in_array($camp->ID, $atachmentcampaigns);
                $checked = $hascampaign ? 'checked' : '';

                return '<div>
                  <input
                    class="media_campaign_checkbox"
                    type="checkbox"
                    id="media_campaigns_' . $attachment_id . '_' . $camp->ID . '"
                    name="media_campaigns_' . $attachment_id . '_' . $camp->ID . '"
                    value="' . $camp->ID . '" ' . 
                    $checked .
                  '/>
                  <label for="media_campaigns_' . $attachment_id . '_' . $camp->ID . '">' . 
                    $camp->post_title . 
                  '</label>
                </div>';
              },
              $campaigns
            )
          )
        ) . 
      '</div>';
    }
  } 

  public function media_update_campaigns() {

    check_ajax_referer('media_campaigns_nonce', 'nonce');

    $attachment_id = intval($_POST['attachment_id'] ?? 0);
    $campaigns = isset($_POST['campaigns']) ? 
      array_map(
        'intval', 
        (array) $_POST['campaigns']
      ) 
      : 
      [];

    if ($attachment_id) {

      if (!empty($campaigns)) {

        update_post_meta(
          $attachment_id, 
          'poeticsoft_partner_campaign_media_campaigns', 
          $campaigns
        );

      } else {

        delete_post_meta(
          $attachment_id, 
          'poeticsoft_partner_campaign_media_campaigns'
        );
      }

      wp_send_json_success(['message' => 'Relaciones actualizadas']);
    }

    wp_send_json_error(['message' => 'ID de attachment no válido']);
  }
}