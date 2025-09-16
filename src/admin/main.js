import './main.scss'

(function($) {

  console.log('poeticsoft_partner_campaign_media_campaigns')
  
  $(document)
  .on(
    'change', 
    '.poeticsoft_partner_campaign_media_campaigns input.media_campaign_checkbox', 
    function() {

      let $container = $(this).closest('.poeticsoft_partner_campaign_media_campaigns');      
      let attachment_id = $container.data('attachment');
      let campaigns = $container
      .find('input:checked')
      .map(function() {

        return $(this).val();
      })
      .get();

      console.log('------------------------------')
      console.log(attachment_id)
      console.log(campaigns)

      wp.ajax.post(
        'update_media_campaigns', {

          nonce: poeticsoft_media_campaigns.nonce,
          attachment_id: attachment_id,
          campaigns: campaigns

        }
      )
    }
  );

})(jQuery)