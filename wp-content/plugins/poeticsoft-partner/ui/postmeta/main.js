jQuery(document)
.ready(function($) {

  $(document)
  .on(
    'change', 
    '.poeticsoft_partner_campaign_meta_publishable_toggle', 
    function() {

      var $checkbox = $(this);
      var postID = $checkbox.data('campaignid');
      var value = $checkbox.is(':checked') ? 1 : 0;

      $.ajax({
        url: PoeticsoftPartnerCampaignMetaPublishableAjax.ajaxurl,
        method: 'POST',
        data: {
          action: 'update_poeticsoft_partner_campaign_meta_publishable',
          post_id: postID,
          value: value,
          nonce: PoeticsoftPartnerCampaignMetaPublishableAjax.nonce
        },
        success: function(response) {

          if (response.success) {
            
            console.log('Flag actualizado.');

          } else {
            
            console.error('Error al actualizar el flag.');

          }
        },
        error: function() {

          console.error('Error de AJAX.');
        }
      });
  });
});