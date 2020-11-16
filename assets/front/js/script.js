jQuery(function ($) {
    const lipdf = {
        init: function () {
            // Get the modal
            var modal = $("#lipdf_modal");
            var btn = $(".lipdf_read_btn");

            if (!btn) {
                return;
            }

            var span = $("#limodalclose");

            btn.on('click', function () {
                modal.show();
            });

            span.on('click', function () {
                modal.hide();
            });
        }
    };

    lipdf.init();
});
