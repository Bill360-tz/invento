<div class="general flex-c grid-gap-10  fill">
    <div class="flex-c gap-10">
        <div class="flex-c bg-w shadow-sec rad-3 pad-10">
            <h4 class="theme-text">TOTAL INVOICES</h4>
            <span class="size-1_4rem w-500 theme-text-c text-c font-four"><?= allInvo()['invoiceSum'] ?></span>
           
        </div>
        <div class="flex-c bg-w shadow-sec rad-3 pad-10">
            <h4 class="theme-text">OUTSTANDING INVOICES</h4>
            <span class="size-1_4rem theme-text-c text-c w-500 font-four"><?= number_format(outstandingInvo()['invoiceSum']) ?></span>
            <span class="fill theme-text-c text-r aliagn-l"><a href="outstanding-invoices" class="btn-pri-o">View All <i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
        </div>
    </div>
</div>