<div class="lipdf_container text-center">
    <button class="single_add_to_cart_button button alt lipdf_btn" id="myBtn">Read PDF</button>
</div>

<!-- The Modal -->
<div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <span class="close">&times;</span>

        <div id="canvas_container">
            <canvas id="cnv"></canvas>
        </div>

        <div>
            <button id="prev">Prev</button>
            <button id="next">Next</button>
        </div>
    </div>
</div>

<script>
    const PDFStart = (nameRoute) => {
        let loadingTask = pdfjsLib.getDocument(nameRoute),
            pdfDoc = null,
            canvas = document.querySelector("#cnv"),
            ctx = canvas.getContext("2d"),
            scale = 1.5,
            numPage = 1;

        const GeneratePDF = (numPage) => {
            pdfDoc.getPage(numPage).then((page) => {
                var container = document.getElementById('canvas_container');

                var viewport = page.getViewport({ scale: 1 });
                let clientWidth = container.clientWidth ? container.clientWidth : 923;
                scale = clientWidth / viewport.width;

                viewport = page.getViewport({ scale: scale });

                canvas.height = viewport.height;
                canvas.width = viewport.width;

                let renderContext = {
                    canvasContext: ctx,
                    viewport: viewport,
                };

                page.render(renderContext);
            });
        };

        const PrevPage = () => {
            if (numPage === 1) {
                return;
            }
            numPage--;
            GeneratePDF(numPage);
        };

        const NextPage = () => {
            if (numPage >= pdfDoc.numPages) {
                return;
            }
            numPage++;
            GeneratePDF(numPage);
        };

        document.querySelector("#prev").addEventListener("click", PrevPage);
        document.querySelector("#next").addEventListener("click", NextPage);

        loadingTask.promise.then((pdfDoc_) => {
            pdfDoc = pdfDoc_;
            GeneratePDF(numPage);
        });
    };

    const startPdf = () => {
        PDFStart("<?php echo $pdf_url; ?>");
    };

    window.addEventListener("load", startPdf);
</script>
