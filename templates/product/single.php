<?php
if ( 'image' === $show_on_product_thumb ) {
    ?>

    <div class="lipdf_container text-center">
        <a href="javascript:void(0)" class="lipdf_btn show_image_on_product_thumb lipdf_read_btn">
            <img src="<?php echo $lipdf_read_more_image_link; ?>" alt="">
        </a>
    </div>

    <?php
}

if ( 'text' === $show_on_product_thumb ) {
    ?>
    <div class="lipdf_container text-center">
        <a href="javascript:void(0)" class="lipdf_btn show_text_on_product_thumb lipdf_read_btn">
            <p><?php echo $lipdf_read_more_button_text; ?></p>
        </a>
    </div>
    <?php
}
?>

<?php
if ( 'yes' === $lipdf_show_read_more_button_after_product_thumb ) {
?>
    <div class="lipdf_container text-center">
        <a href="javascript:void(0)" class="button alt lipdf_btn after_product_thumb lipdf_read_btn">
            <?php echo $lipdf_read_more_button_text; ?>
        </a>
    </div>
<?php
}
?>

<!-- The Modal -->
<div id="lipdf_modal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <span class="close" id="limodalclose">&times;</span>

        <div id="canvas_container">
            <div id="lipdf_reader">
                <ul>
                    <?php
                    foreach ( $li_pdf_images as $li_pdf_image_id ) {
                        $attachment = wp_get_attachment_image_url( $li_pdf_image_id, 'large' );

                        // if attachment is empty skip.
                        if ( ! empty( $attachment ) ) {
                            ?>
                            <li><img class="li_pdf_single_image" src="<?php echo $attachment; ?>" alt=""></li>
                        <?php }
                    } ?>
                </ul>
            </div>
        </div>
    </div>
</div>
