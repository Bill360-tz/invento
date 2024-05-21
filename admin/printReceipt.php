<?php
session_start();
if (!isset($_SESSION['welix_loged_in'])) {
    header("location: login");
}
if (!isset($_GET['invoice_no']) || $_GET['invoice_no'] == "") {
    echo "<script>document.location = 'index.php'</script>";
} else {
    $invoice_no = htmlspecialchars_decode($_GET['invoice_no']);
}
include("functions/functions.php");
// include("functions/welix.php") ; 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Recipt</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/welix.css">
    <!-- <link rel="stylesheet" href="../assets/css/welix-dark.css"> -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../assets/DataTables/datatables.min.css">
    <link rel="stylesheet" href="../assets/fontawasome5/css/all.min.css">
    <link rel="shortcut icon" href="../assets/img/fav.ico" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../assets/js/jquery-3.6.0.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
    <script src="../assets/js/welix.js"></script>
    <script src="../assets/DataTables/datatables.min.js"></script>
    <script src="../assets/fontawasome5/js/all.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
</head>

<body>

    <div class="flex-c fill">
        <div class="flex flex-centered fill pad-20">
            <div class="flex fill bordered border-b-2 border-slate-600 bg-slate-300">
                <div class="flex-c flex-centered w-3q">
                    <h3 class="theme-text  font-bold m-0 p-0" style="font-size: 2.4rem;">ARUSHA LAPTOP <span class="font-two" style="font-size: 2.4rem;">&</span> GADGETS</h3>
                    <div class="flex w-full flex-col item-center justify-center m-0 p-0">
                        <h3 class="text-2xl flex no-center m-0 p-0 text-slate-700">Contacts: 0752 198 921 / 0673 198 921
                        </h3>

                    </div>
                </div>
                <div class="flex flex-c pb-1 " style="width: 20%;">
                    <img src="../assets/img/logo.png" alt="" style="width: 90%;">
                </div>
            </div>
        </div>
        <div class="grid grid-cols-3 w-full pad-20">
            <div class="flex-c">
                <span class="text-slate-700 text-xl font-semi-bold">SOLD TO:</span>
                <span class="normal-text capitalize pad-0 marg-0"><?= customersInfo($invoice_no)['cust_name'] ?></span>
                <span class="normal-text capitalize pad-0 marg-0"><?= customersInfo($invoice_no)['cust_phone'] ?></span>
            </div>
            <div class="flex-c">
                <span class="text-slate-700 text-xl font-semi-bold">PAYMENT DATE:</span>
                <span class="normal-text capitalize pad-0 marg-0"><?= formatDate(invoiceFigures($invoice_no)['invoice_date'])   ?></span>

            </div>
            <div class="flex-c">
                <span class="text-slate-700 text-xl font-semi-bold">RECEIPT NO:</span>
                <span class="normal-text capitalize pad-0 marg-0"><?= $invoice_no ?></span>

            </div>
        </div>
        <div class="flex-c fill pad-20">
            <table class="table">
                <thead class="bg-slate-500 p-2 text-white">
                    <tr>
                        <th class="p-1 text-l w-500">DESCRIPTION</th>
                        <th class="p-1 text-l w-500">QUANTINITY</th>
                        <th class="p-1 text-l w-500">UNITY PRICE</th>
                        <th class="p-1 text-l w-500">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows(invoiceItems($invoice_no)) > 0) {
                        foreach (invoiceItems($invoice_no) as $ite) {
                    ?>

                            <tr class="text-slate-600">
                                <td class="p-1"><?= $ite['item_name'] ?> </td>
                                <td class="p-1"><?= number_format($ite['item_count']) ?> </td>
                                <td class="p-1"><?= number_format($ite['item_price']) ?></td>
                                <td class="p-1"><?= number_format($ite['total_cost']) ?></td>
                            </tr>
                            <div class="grid-3qs fill pad-5">
                                <div class="flex">
                                    <span></span>
                                    <span class="grey"></span>

                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>


                </tbody>
            </table>
        </div>
        <div class="flex fill pad-20 justify-end">
            <div class="flex-c ">


                <div style="width: 150px;" class="flex text-slate-700">
                    <span style="width: 70px;">Sub Total</span>
                    <span>:<?= number_format(invoiceFigures($invoice_no)['total_price']) . "/=" ?></span>
                </div>
                <div style="width: 150px;" class="flex text-slate-700">
                    <span style="width: 70px;">Discount</span>
                    <span>:<?= number_format(invoiceFigures($invoice_no)['discount']) . "/=" ?></span>
                </div>
                <div style="width: 150px;" class="flex text-slate-700 font-semibold">
                    <span style="width: 70px;">Total</span>
                    <span>:<?= number_format(invoiceFigures($invoice_no)['amount_due'])."/=" ?></span>
                </div>
               

            </div>
            
        </div>

        <div class="flex flex-c justify-center fill  pad-20 flex-centered fill">
        <div class="flex fill bordered border-t-2 border-slate-700 "></div>
            <div class="grid-2 width-50 no-print ">
                <button onclick="window.close()" class="bordered border-slate-600 bg-slate-300 rounded pad-5 text-slate-700 flex flex-centered"><i class="fa fa-times-circle" aria-hidden="true"></i> CANCEL</button>
                <button onclick="window.print()" class="bordered border-slate-600 bg-slate-400 rounded pad-5 text-slate-700 flex flex-centered btn"><i class="fas fa-print    "></i> PRINT</button>
            </div>
        </div>
    </div>

</body>

</html>