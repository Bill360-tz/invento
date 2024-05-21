<div class="flex-c marg-t-10 bg-w fill m-pad-5">
    <div class="fill m-fill">

        <div class="fill grid-2 pad-10 m-flex-r">
            <div id="selectItemWraper" class=" flex-c m-fill scroll-x">
                <div class="flex flex-s-btn pad-5 theme-border-b-2">
                    <select id="changeCat" class="pad-5 input-s width-50 theme-text">
                        <option value="<?= $cat ?>"><?= $cat ?></option>
                        <option value="All">All</option>
                        <?php
                        foreach (fetchCats() as $category) {
                        ?>
                            <option value="<?= $category['cat_name'] ?>"><?= $category['cat_name'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <div class="flex">
                        <label for="priceBelow" class="theme-text-c">Price Below:</label>
                        <input id="priceBelow" value="<?= $prB ?>"  type="number" class="input-s pad-5">
                        <button id="priceBelowFetch" class="btn-pri-o"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </div>
                </div>
                <input type="hidden" id="invoiceNumber" value="<?= fetchInvoiceNo() ?>">
                <table id="selectItemTable">
                    <thead>
                        <tr class="theme-text">
                            <th>Item Name</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach (fetchItemSale($cat, $prB) as $product) {
                        ?>
                            <tr class="normal-text">
                                <td><?= $product['item_name'] ?></td> 
                                <td><?= number_format($product['item_price']) ?></td>
                                <td class="flex">
                                    <button onclick="addToCart('<?= $product['item_id'] ?>','<?= $product['item_name'] ?>','<?= $product['item_price'] ?>','<?= $product['item_cost'] ?>')" class="btn-pri-o fill">SELECT</button>
                                    <button title="<?= $product['item_des'] ?>'" onclick="alert(`<?= $product['item_des'] ?>`)" class="btn-pri-o fill"><i class="fa fa-info" aria-hidden="true"></i></button>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>

                    </tbody>
                </table>
            </div>
            <div class="hsgsjd_invioce flex-c m-fill">
                <div class="flex fill pad-10 pad-b-0">
                    <h3 class="theme-text">Invoice: <?= fetchInvoiceNo() ?></h3>
                </div>
                <div class="selectedItems fill flex-c">

                </div>
                <div id="invoLast" class="invoiceInfoInpt flex-c fill theme-text-c" style="display: none;">
                    <div class="fill pad-5 grid-2">
                        <div class="">

                        </div>
                        <div class="flex flex-end">
                            <label class="flex">Total Price</label>
                            <input id="totalPrice" type="text" disabled value="0" style="width: 90px; text-align:right;border:none; font-weight:600;font-size:15px">
                        </div>
                    </div>
                    <div class="fill pad-5 grid-2">
                        <div class="
                               "></div>
                        <div class="flex flex-end">
                            <label class="flex">Discount </label>
                            <input id="discount" class="input-s pad-5" type="number" oninput="processDiscount(this.value)" value="0" style="width: 90px;  text-align:right;">
                        </div>
                    </div>
                    <div class="fill pad-5 grid-2">
                        <div class="">

                        </div>
                        <div class="flex flex-end">
                            <label class="flex">Amount Due</label>
                            <input id="amountDue" type="text" disabled value="0" style="width: 90px; border:none; text-align:right;font-weight:600;font-size:15px">
                        </div>
                    </div>
                    <div class="flex flex-centered">
                        <div class="startMakeSaleBtns fill grid-2">
                            <button class="closemakeSale btn-sec-o pad-10 w-600">CANCEL</button>
                            <button id="startMakeSale" class="btn-pri-o pad-10">NEXT</button>
                        </div>
                    </div>
                </div>

            </div>
            <div class="finalizingSale flex-c" style="display: none;">
                <div class="grid-2 pad-10 pad-b-0 fill">
                    <h3 class="them-text">Payment</h3>
                    <!-- <div class="statDis flexn text-r">Full Paid</div> -->
                </div>
                <div class="flex-c fill">
                    <label for="amountPaid">Amount Paid</label>
                    <input id="amountPaid" type="number" class="input-s pad-5">
                </div>
                <div class="flex-c fill">
                    <label for="paymentMethod">Amount Paid</label>
                    <select id="paymentMethod" class="input-s pad-5">
                        <option value="cash">Cash</option>
                        <option value="Lipa namba - tigo">Lipa namba - Tigo</option>
                        <option value="Lipa namba - vode">Lipa namba - Voda</option>
                        <option value="Lipa namba Airtel">Lipa namba - Airtel</option>
                    </select>
                </div>
                <div class="flex-c">
                    <label for="custPhoness">Customer Phone</label>
                    <input id="custPhoness" oninput="phoneinpu(this.value)" type="phone" placeholder="eg. 0789123456" class="input-s pad-5">
                </div>
                <div class="flex-c">
                    <label for="custName">Customer Name</label>
                    <input id="custName" type="phone" class="input-s pad-5">
                </div>
                <div class="grid-3qe fill marg-t-10">
                    <button id="selectionBackBtn" title="Back" class="btn-sec"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i></button>
                    <button id="completeSaleBtnss" class="btn-pri">COMPLETE SALE</button>
                </div>
            </div>
        </div>
    </div>
</div>