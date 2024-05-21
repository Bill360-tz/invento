
<div class="general grid-2 grid-gap-10  fill">
                            <div class="flex-c gap-10">
                                <div class="flex-c bg-w shadow-pri rad-3 pad-10">
                                    <h4 class="theme-text">TOTAL OUTSTANDING INVOICES</h4>
                                    <span class="size-1_4rem w-500 theme-text-c text-c font-four"><?= outstandingInvo()['invoiceSum'] ?></span>
                                </div>
                                <div class="flex-c bg-w shadow-pri rad-3 pad-10">
                                    <h4 class="theme-text">OUTSTANDING REVENUE</h4>
                                    <span class="size-1_4rem theme-text-c text-c w-500 font-four"><?= number_format(outstandingInvo()['invoicesRevenue']) . ' Tsh.' ?></span>
                                </div>
                                <div class="flex-c bg-w shadow-pri rad-3 pad-10">
                                    <h4 class="theme-text">TOTAL INVOICES</h4>
                                    <span class="size-1_4rem w-500 theme-text-c text-c font-four"><?= allInvo()['invoiceSum'] ?></span>
                                    <span class="fill theme-text-c text-r aliagn-l"><a href="invoices" class="btn-pri-o">View All <i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
                                </div>
                            </div>
                            <div class="flex-c gap-10">
                                <div class="flex-c fill pad-10 rad-3 bg-w  shadow-pri rad-3">
                                    <div class="flex fill btn-pri-o pad-r-5">
                                        <h3 class="theme-text fill flex-s-btn"><span><i class="fas fa-signature    "></i> SMS ALL NOW </span> <span><i class="fa fa-paper-plane totate-90" aria-hidden="true"></i></span></h3>
                                    </div>
                                </div>
                                <div class="flex-c fill pad-10 bg-w shadow-pri rad-3">
                                    <h3 class="flex flex-s-btn fill theme-text-c  w-500">

                                        <span>
                                            <span id="tempCountSpan" class="font-two"><?= number_format((int)fetchTemplatesCount()) ?></span> SMS TEMPLATES
                                        </span>
                                        <span><i class="fa fa-list theme-text" aria-hidden="true"></i></span>
                                    </h3>
                                    <div class="grid-2 fill">
                                        <button id="viewTempsBtn" class="btn-pri-o">View</button>
                                        <button id="addTempsBtn" class="btn-pri-o">Add</button>
                                    </div>
                                </div>
                                <div class="flex-c fill pad-10 bg-w shadow-pri rad-3">
                                    <h3 class="flex flex-s-btn fill theme-text-c w-500">

                                        <span>
                                            <span id="scheCountSpan" class="font-two"><?= number_format((int) fetchScheduledCount()) ?></span> SCHEDULED SMS
                                        </span>
                                        <span><i class="fa fa-list theme-text" aria-hidden="true"></i></span>
                                    </h3>
                                    <div class="grid-2 fill">
                                        <button id="viewScheBtn" class="btn-pri-o">View</button>
                                        <button id="addScheBtn" class="btn-pri-o">Add</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    