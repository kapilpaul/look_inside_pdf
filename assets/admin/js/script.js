jQuery(function ($) {
    var $image_gallery_ids = $( '#lipdf_images_ids' );
    var $product_images    = $( '.lipdf_gallery' ).find( 'ul.product_images' );

    // on upload button click
    $('body').on('click', '.lipdf-upload-images', function (e) {

        e.preventDefault();

        // Product gallery file uploads.
        var $el = $( this );

        var button = $(this),
            custom_uploader = wp.media({
                title: 'Insert image',
                library: {
                    // uploadedTo : wp.media.view.settings.post.id, // attach to the current post?
                    type: 'image'
                },
                button: {
                    text: 'Use this images' // button label text
                },
                multiple: true
            }).on('select', function () { // it also has "open" and "close" events
                var selection = custom_uploader.state().get('selection');
                var attachment_ids = $image_gallery_ids.val();

                selection.map( function( attachment ) {
                    attachment = attachment.toJSON();

                    if ( attachment.id ) {
                        attachment_ids   = attachment_ids ? attachment_ids + ',' + attachment.id : attachment.id;
                        var attachment_image = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;

                        $product_images.append(
                            '<li class="image" data-attachment_id="' + attachment.id + '"><img src="' + attachment_image +
                            '" /><ul class="actions"><li><a href="#" class="delete" title="' + $el.data('delete') + '">' +
                            $el.data('text') + '</a></li></ul></li>'
                        );
                    }
                });

                $image_gallery_ids.val( attachment_ids );
            }).open();

    });

    // Remove images.
    $( '.lipdf_gallery.images_list' ).on( 'click', 'a.delete', function() {
        $( this ).closest( 'li.image' ).remove();

        var attachment_ids = '';

        $( '.lipdf_gallery.images_list' ).find( 'ul li.image' ).css( 'cursor', 'default' ).each( function() {
            var attachment_id = $( this ).attr( 'data-attachment_id' );
            attachment_ids = attachment_ids + attachment_id + ',';
        });

        $image_gallery_ids.val( attachment_ids );

        // Remove any lingering tooltips.
        $( '#tiptip_holder' ).removeAttr( 'style' );
        $( '#tiptip_arrow' ).removeAttr( 'style' );

        return false;
    });

    /**
     * admin options settings
     * @type {*|jQuery|HTMLElement}
     * @private
     */
    let _lipdf_type_of_data_show_on_product_thumb = $('#_lipdf_type_of_data_show_on_product_thumb');

    let _lipdf_type_of_data_show_on_product_thumb_val = _lipdf_type_of_data_show_on_product_thumb.val();

    if (_lipdf_type_of_data_show_on_product_thumb_val === 'image') {
        $('tr._lipdf_read_more_image_link').show();
    } else {
        $('tr._lipdf_read_more_image_link').hide();
    }

    _lipdf_type_of_data_show_on_product_thumb.on('change', function (e) {
        if (e.target.value === 'image') {
            $('tr._lipdf_read_more_image_link').show();
        } else {
            $('tr._lipdf_read_more_image_link').hide();
        }
    });
});
