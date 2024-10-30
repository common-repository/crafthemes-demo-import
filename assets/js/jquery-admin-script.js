( function( $ ){
    $( document ).ready( function(){
      $( '.jquery-btn-subscribe' ).on( 'click', function( e ) {
          e.preventDefault();
          $.post( ct_ajax_object.ajax_url, { 'action' : 'join_subscriber' }, function( response ){} );
      } );
    } );

    $( document ).on( 'click', '.notice-alert-subscribe-class .sub-notice-dismiss', function () {
        // Read the "data-notice" information to track which notice
        // is being dismissed and send it via AJAX
        var type = $( this ).closest( '.notice-alert-subscribe-class' ).data( 'notice' );
        // Make an AJAX call
        $.ajax( ajaxurl,
          {
            type: 'POST',
            data: {
              action: 'ct_ctdi_ajax_notice_handler',
              type: type,
            }
          } );
      } );

    $( document ).on( 'click', '.jquery-btn-subscribe, .jquery-btn-newsletter-ignore', function () {
          $(this).parents( '.notice-alert-subscribe-class' ).css( 'display', 'none' );
    } );

}( jQuery ) )
