<div class="completeSaleModel flex-c fill" style="display: none;">
    <div class="innerCompleteSaleModel width-40 fill pad-20 rad-5 m-fill">
        Are you sure you want to Complete the sale?
        <div class="grid-3 fill pad-10">
            <button id="closemakeSaleConfirmedModel" class="btn-sec close-btn font-two">CANCEL</button>
            <button id="makeSaleConfirmed" class="btn-pri flex flex-centered font-two">
                <span class="loader-container" id="loaderContainerxxx">
                    <div class="loader" id="loader"></div>
                </span>
                <span id="buttonTextxxx">COMPLETE</span>
            </button>
            <button onclick="goToPrint('<?= fetchInvoiceNo() ?>')" id="makeSaleConfirmedpPrint" class="btn-pri flex flex-centered font-two">
            <span class="loader-container" id="loaderContainerxxxp">
                    <div class="loader" id="loader"></div>
                </span>
                <span id="buttonTextxxxp">COMPLETE & PRINT</span>
            </button>
        </div>
    </div> 
</div>

<script>

</script>