<div class="options_group">
    <p class="form-field">
        <label for="wholesale_quantity">Upload Look Inside PDF Images</label>
        <a href="#" class="wp-core-ui button lipdf-upload-images" data-delete="<?php esc_attr_e( 'Delete image', 'look-inside-pdf' ); ?>" data-text="<?php esc_attr_e( 'Delete', 'look-inside-pdf' ); ?>">
            Upload Images
        </a>

        <input type="hidden" name="_li_pdf_images" value="<?php echo esc_attr( implode( ',', $li_pdf_images ) ); ?>" id="lipdf_images_ids" >
    </p>

    <div class="lipdf_gallery images_list">
        <ul class="product_images">
            <?php
            $update_meta         = false;
            $updated_gallery_ids = [];

            if ( ! empty( $li_pdf_images ) ) {
                foreach ( $li_pdf_images as $attachment_id ) {
                    $attachment = wp_get_attachment_image_url( $attachment_id );

                    // if attachment is empty skip.
                    if ( empty( $attachment ) ) {
                        $update_meta = true;
                        continue;
                    }
                    ?>
                    <li class="image" data-attachment_id="<?php echo esc_attr( $attachment_id ); ?>">
                        <img src="<?php echo $attachment; ?>">
                        <ul class="actions">
                            <li><a href="#" class="delete tips" data-tip="<?php esc_attr_e( 'Delete image', 'woocommerce' ); ?>"><?php esc_html_e( 'Delete', 'woocommerce' ); ?></a></li>
                        </ul>
                    </li>
                    <?php

                    // rebuild ids to be saved.
                    $updated_gallery_ids[] = $attachment_id;
                }
            }
            ?>
        </ul>
    </div>

</div>
