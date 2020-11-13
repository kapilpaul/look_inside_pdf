<div class="lipdf_container <?php echo $button_container_class; ?> text-center">
    <a href="javascript:void(0)" class="<?php echo $button_class; ?> lipdf_btn" id="lipdf_read_btn">
        <?php _e( $read_button_text, 'look-inside-pdf' ); ?>
    </a>
</div>

<!-- The Modal -->
<div id="lipdf_modal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <span class="close" id="limodalclose">&times;</span>

        <div id="canvas_container">
            <div id="lipdf_reader"></div>
        </div>
    </div>
</div>

<script>
    PDFObject.embed("<?php echo $pdf_url; ?>", "#lipdf_reader");
</script>
