jQuery(document)
.ready(function($) {

  $(document)
  .on(
    'change', 
    '.poeticsoft_partner_postmeta_publishable_toggle', 
    function() {

      var $checkbox = $(this);
      var postID = $checkbox.data('postid');
      var value = $checkbox.is(':checked') ? 1 : 0;

      $.ajax({
        url: PoeticsoftPartnerPostmetaPublishableAjax.ajaxurl,
        method: 'POST',
        data: {
          action: 'update_poeticsoft_partner_postmeta_publishable',
          post_id: postID,
          value: value,
          nonce: PoeticsoftPartnerPostmetaPublishableAjax.nonce
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