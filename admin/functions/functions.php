<?php
function conn()
{
    include("connection.php");
    return $conn;
}
include("welix.php");

echo "Hello World";
function  fetchCats()
{
    include("connection.php");
    $office_id = $_SESSION['welix_loged_in']['office_id'];
    $sql = "SELECT * FROM categories where office_id = '$office_id' and delete_status = 'no'";

    $result = $conn->query($sql);

    if (!$result) {
        echo mysqli_error($conn);
    } else {
        return $result;
    }
}

function oneCat($cat_id, $brand)
{
    include("connection.php");
    $office_id = $_SESSION['welix_loged_in']['office_id'];
    if ($brand == "All") {
        $sql = "SELECT * FROM categories where office_id = '$office_id' and delete_status = 'no' and cat_id ='$cat_id'";
    } else {
        $sql = "SELECT * FROM categories inner join brands on brands.cat_id = categories.cat_id where categories.office_id = '$office_id' and categories.delete_status = 'no' and categories.cat_id = '$cat_id'";
    }

    $query = mysqli_query($conn, $sql);

    if (!$query) {
        echo mysqli_error($conn);
    } else {
        if (mysqli_num_rows($query) > 0) {
            $result = mysqli_fetch_assoc($query);

            return $result;
        } else {
            return [];
        }
    }
}
function  countCats()
{
    include("connection.php");
    $office_id = $_SESSION['welix_loged_in']['office_id'];
    $sql = "SELECT count(cat_id) as cat_count FROM categories where office_id = '$office_id' and delete_status = 'no'";

    $result = $conn->query($sql);

    if (!$result) {
        echo mysqli_error($conn);
    } else {
        if ($result->num_rows > 0) {
            // return $result;

            $cat_count = $result->fetch_assoc();

            return $cat_count['cat_count'];
        } else {
            return "0";
        }
    }
}

function countCatItems($cat_id)
{
    include("connection.php");
    $office_id = $_SESSION['welix_loged_in']['office_id'];
    // Prepare and bind the statement
    $sql = "SELECT * FROM items inner join categories on categories.cat_id = items.cat_id where items.cat_id = '$cat_id' and items.delete_status = 'no' and items.has_sub = 'no' and categories.office_id ='$office_id'";

    $query = mysqli_query($conn, $sql);

    if(!$query){
        echo mysqli_error($conn);
    }else{
        $count = 0;
        if(mysqli_num_rows($query)>0){
            
            foreach($query as $item){
                $count = $count + $item['item_quantity'];
            }
        }

        return $count;
    }
}

function reOrderItem(){
    $office_id = $_SESSION['welix_loged_in']['office_id'];
    $sql = "SELECT * FROM items INNER JOIN categories ON items.cat_id = categories.cat_id WHERE item_quantity <= reorder_point and categories.office_id ='$office_id' AND  items.delete_status = 'no' and categories.delete_status = 'no'";

    $query = mysqli_query(conn(), $sql);

    if(!$query){
        echo mysqli_error(conn());
    }else{
        return $query;
    }
}

function fetchItem($category)
{
    include("connection.php");
    $office_id = $_SESSION['welix_loged_in']['office_id'];
    if ($category == "All") {
        $stmt = $conn->prepare("SELECT * FROM items INNER JOIN categories ON items.cat_id = categories.cat_id WHERE categories.office_id ='$office_id' AND  items.delete_status = 'no' and categories.delete_status = 'no'");
    } elseif ($category == "reorder") {
        $stmt = $conn->prepare("SELECT * FROM items INNER JOIN categories ON items.cat_id = categories.cat_id WHERE item_quantity <= reorder_point and categories.office_id =? AND  items.delete_status = 'no' and categories.delete_status = 'no'");
        $stmt->bind_param("s", $office_id);
    } elseif ($category == "outOfStock") {
        $stmt = $conn->prepare("SELECT * FROM items INNER JOIN categories ON items.cat_id = categories.cat_id WHERE item_quantity <= 0 and categories.office_id =? AND  items.delete_status = 'no' and categories.delete_status = 'no'");
        $stmt->bind_param("s", $office_id);
    } else {
        $stmt = $conn->prepare("SELECT * FROM items INNER JOIN categories ON items.cat_id = categories.cat_id WHERE categories.cat_name =? and categories.office_id =? AND  items.delete_status = 'no' AND  categories.delete_status = 'no' and categories.delete_status = 'no'");
        $stmt->bind_param("ss", $category, $office_id);
    }

    // Execute the statement
    if ($stmt->execute()) {
        // Fetch the count
        $result = $stmt->get_result();

        // Check if the count is greater than 0
        if ($result->num_rows > 0) {
            return $result;
        } else {
            return [];
        }
    } else {
        echo "Error executing query: " . $stmt->error;
    }
    // Close the statement and the connection
    $stmt->close();
    $conn->close();
}
function fetchItemSale($category, $prB)
{
    include("connection.php");
    $office_id = $_SESSION['welix_loged_in']['office_id'];

    if ($prB == "All") {
        if ($category == "All") {
            $stmt = $conn->prepare("SELECT * FROM items INNER JOIN categories ON items.cat_id = categories.cat_id WHERE categories.office_id ='$office_id' AND  items.delete_status = 'no' and categories.delete_status = 'no'");
        } elseif ($category == "reorder") {
            $stmt = $conn->prepare("SELECT * FROM items INNER JOIN categories ON items.cat_id = categories.cat_id WHERE item_quantity <= reorder_point and categories.office_id =? AND  items.delete_status = 'no' and categories.delete_status = 'no'");
            $stmt->bind_param("s", $office_id);
        } elseif ($category == "outOfStock") {
            $stmt = $conn->prepare("SELECT * FROM items INNER JOIN categories ON items.cat_id = categories.cat_id WHERE item_quantity <= 0 and categories.office_id =? AND  items.delete_status = 'no' and categories.delete_status = 'no'");
            $stmt->bind_param("s", $office_id);
        } else {
            $stmt = $conn->prepare("SELECT * FROM items INNER JOIN categories ON items.cat_id = categories.cat_id WHERE categories.cat_name =? and categories.office_id =? AND  items.delete_status = 'no' AND  categories.delete_status = 'no' and categories.delete_status = 'no'");
            $stmt->bind_param("ss", $category, $office_id);
        }
    } else {
        if ($category == "All") {
            $stmt = $conn->prepare("SELECT * FROM items INNER JOIN categories ON items.cat_id = categories.cat_id WHERE categories.office_id ='$office_id' AND  items.delete_status = 'no' and categories.delete_status = 'no' and items.item_price <= '$prB'");
        } elseif ($category == "reorder") {
            $stmt = $conn->prepare("SELECT * FROM items INNER JOIN categories ON items.cat_id = categories.cat_id WHERE item_quantity <= reorder_point and categories.office_id =? AND  items.delete_status = 'no' and categories.delete_status = 'no' and items.item_price <= '$prB'");
            $stmt->bind_param("s", $office_id);
        } elseif ($category == "outOfStock") {
            $stmt = $conn->prepare("SELECT * FROM items INNER JOIN categories ON items.cat_id = categories.cat_id WHERE item_quantity <= 0 and categories.office_id =? AND  items.delete_status = 'no' and categories.delete_status = 'no' and items.item_price <= '$prB'");
            $stmt->bind_param("s", $office_id);
        } else {
            $stmt = $conn->prepare("SELECT * FROM items INNER JOIN categories ON items.cat_id = categories.cat_id WHERE categories.cat_name =? and categories.office_id =? AND  items.delete_status = 'no' AND  categories.delete_status = 'no' and categories.delete_status = 'no' and items.item_price <= '$prB'");
            $stmt->bind_param("ss", $category, $office_id);
        }
    }


    // Execute the statement
    if ($stmt->execute()) {
        // Fetch the count
        $result = $stmt->get_result();

        // Check if the count is greater than 0
        if ($result->num_rows > 0) {
            return $result;
        } else {
            return [];
        }
    } else {
        echo "Error executing query: " . $stmt->error;
    }
    // Close the statement and the connection
    $stmt->close();
    $conn->close();
}

function fetchInvoiceNo()
{
    $office_id = $_SESSION['welix_loged_in']['office_id'];
    include("connection.php");
    $sql = "SELECT invoice_no FROM invoices WHERE office_id = '$office_id'and delete_status = 'false' ORDER BY invoice_date DESC LIMIT 1";
    $query = mysqli_query($conn, $sql);

    if (!$query) {
        echo mysqli_error($conn);
    } else {
        if (mysqli_num_rows($query) > 0) {
            $result = mysqli_fetch_assoc($query);

            $invoice = $result['invoice_no'] + 1;

            if (strlen(((string)$invoice)) == 1) {
                $invoice = '000' . $invoice;
            } elseif (strlen(((string)$invoice)) == 2) {
                $invoice = '00' . $invoice;
            } elseif (strlen(((string)$invoice)) == 3) {
                $invoice = '0' . $invoice;
            } else {
                $invoice == $invoice;
            }

            return $invoice;
        } else {
            return "0001";
        }
    }
}

function fetchOutstanding()
{
    include("connection.php");
    $office_id = $_SESSION['welix_loged_in']['office_id'];
    $sql = "SELECT * FROM invoices INNER JOIN customers ON invoices.cust_phone = customers.cust_phone WHERE invoices.payment_status = 'not_full_paid' and invoices.office_id = '$office_id'and invoices.delete_status = 'false' ORDER BY invoices.invoice_no desc";
    $query = mysqli_query($conn, $sql);

    if (!$query) {
        echo mysqli_error($conn);
    } else {
        return $query;
    }
}
function fetchInvoices()
{
    include("connection.php");
    $office_id = $_SESSION['welix_loged_in']['office_id'];
    if($_SESSION['expSeasion'] == 'today'){
        $sql = "SELECT * FROM invoices INNER JOIN customers ON invoices.cust_phone = customers.cust_phone WHERE invoices.office_id = '$office_id' and invoices.delete_status = 'false' AND YEAR(invoice_date) = YEAR(CURDATE()) AND MONTH(invoice_date) = MONTH(CURDATE()) AND DAY(invoice_date) = DAY(CURDATE())";
    }else if($_SESSION['expSeasion'] == 'week'){
        $sql = "SELECT * FROM invoices INNER JOIN customers ON invoices.cust_phone = customers.cust_phone WHERE invoices.office_id = '$office_id' and invoices.delete_status = 'false' AND  YEAR(invoice_date) = YEAR(CURDATE()) AND WEEK(invoice_date) = WEEK(CURDATE())";
    }else if($_SESSION['expSeasion'] == 'month'){
        $sql = "SELECT * FROM invoices INNER JOIN customers ON invoices.cust_phone = customers.cust_phone WHERE invoices.office_id = '$office_id' and invoices.delete_status = 'false' and YEAR(invoice_date) = YEAR(CURDATE()) AND MONTH(invoice_date) = MONTH(CURDATE())";
    }else if($_SESSION['expSeasion'] == 'year'){
        $sql = "SELECT * FROM invoices INNER JOIN customers ON invoices.cust_phone = customers.cust_phone WHERE invoices.office_id = '$office_id' and invoices.delete_status = 'false' and YEAR(invoice_date) = YEAR(CURDATE())";
    }else{
        $sql = "SELECT * FROM invoices INNER JOIN customers ON invoices.cust_phone = customers.cust_phone WHERE invoices.office_id = '$office_id' and invoices.delete_status = 'false'";
    }
    
    $query = mysqli_query($conn, $sql);

    if (!$query) {
        echo mysqli_error($conn);
    } else {
        return $query;
    }
}

function outstandingInvo()
{
    include("connection.php");
    $office_id = $_SESSION['welix_loged_in']['office_id'];
    $sql = "SELECT * FROM invoices INNER JOIN customers ON invoices.cust_phone = customers.cust_phone WHERE invoices.payment_status = 'not_full_paid' and invoices.office_id = '$office_id' and invoices.delete_status = 'false'";
    $query = mysqli_query($conn, $sql);

    if (!$query) {
        echo mysqli_error($conn);
    } else {

        $invoiceSum = 0;
        $invoicesRevenue = 0;
        if (mysqli_num_rows($query) > 0) {
            foreach ($query as $invoInfo) {
                $invoiceSum += 1;
                $invoicesRevenue += ((int)$invoInfo['amount_due']) - ((int)$invoInfo['amount_paid']);
            }
        }

        return array(
            'invoiceSum' => $invoiceSum,
            'invoicesRevenue' => $invoicesRevenue
        );
    }
}
function allInvo()
{
    include("connection.php");
    $office_id = $_SESSION['welix_loged_in']['office_id'];
    $sql = "SELECT * FROM invoices INNER JOIN customers ON invoices.cust_phone = customers.cust_phone WHERE invoices.office_id = '$office_id' and invoices.delete_status = 'false'";
    $query = mysqli_query($conn, $sql);

    if (!$query) {
        echo mysqli_error($conn);
    } else {

        $invoiceSum = 0;
        $invoicesRevenue = 0;
        if (mysqli_num_rows($query) > 0) {
            foreach ($query as $invoInfo) {
                $invoiceSum += 1;
                $invoicesRevenue += ((int)$invoInfo['amount_due']) - ((int)$invoInfo['amount_paid']);
            }
        }

        return array(
            'invoiceSum' => $invoiceSum,
            'invoicesRevenue' => $invoicesRevenue
        );
    }
}

function fetchScheduledCount($cust_phone = "all")
{
    include("connection.php");
    $office_id = $_SESSION['welix_loged_in']['office_id'];
    if ($cust_phone == "all") {
        $sql = "SELECT COUNT(scheduled_id) AS counts FROM scheduled_sms INNER JOIN sms_template ON  sms_template.temp_id = scheduled_sms.temp_id where sms_template.office_id = '$office_id' ";
    } else {
        $sql = "SELECT COUNT(scheduled_id) AS counts FROM scheduled_sms INNER JOIN sms_template ON  sms_tesms_templatemplate.temp_id = scheduled_sms.temp_id where sms_template.office_id = '$office_id' sms_template.sms_target = '$cust_phone'";
    }

    $query = mysqli_query($conn, $sql);

    if (!$query) {
        echo mysqli_error($conn);
    } else {
        $scheduledCount = 0;
        if (mysqli_num_rows($query) > 0) {
            $result = mysqli_fetch_assoc($query);
            $scheduledCount = $result['counts'];
        }

        return $scheduledCount;
    }
}
function fetchTemplatesCount()
{
    include("connection.php");
    $office_id = $_SESSION['welix_loged_in']['office_id'];
    $sql = "SELECT COUNT(temp_id) AS counts FROM sms_template WHERE office_id='$office_id'";
    $query = mysqli_query($conn, $sql);

    if (!$query) {
        echo mysqli_error($conn);
    } else {
        $templateCount = 0;
        if (mysqli_num_rows($query) > 0) {
            $result = mysqli_fetch_assoc($query);
            $templateCount = $result['counts'];
        }

        return $templateCount;
    }
}

function fetchAllSmsTemps()
{
    $office_id = $_SESSION['welix_loged_in']['office_id'];
    $sql = "SELECT * FROM sms_template WHERE office_id = '$office_id'";
    $query = mysqli_query(conn(), $sql);

    if (!$query) {
        echo mysqli_error(conn());
    } else {
        return $query;
    }
}

function countAllItems()
{
    $office_id = $_SESSION['welix_loged_in']['office_id'];
    $sql = "SELECT SUM(item_quantity	) AS itemCount FROM items INNER JOIN categories on items.cat_id = categories.cat_id WHERE categories.office_id ='$office_id' and items.delete_status = 'no'";
    $query = mysqli_query(conn(), $sql);

    if (!$query) {
        echo mysqli_error(conn());
    } else {
        $result = mysqli_fetch_assoc($query);

        $itemCount = $result['itemCount'];

        return $itemCount;
    }
}

function countReorders()
{
    $office_id = $_SESSION['welix_loged_in']['office_id'];
    $sql = "SELECT COUNT(item_name) AS reorder FROM items INNER JOIN categories ON items.cat_id = categories.cat_id WHERE  item_quantity <= reorder_point and categories.office_id ='$office_id' and items.reorder_point != '0'";

    $query = mysqli_query(conn(), $sql);

    if (!$query) {
        echo mysqli_error(conn());
    } else {
       if(mysqli_num_rows($query)>0){
        $result = mysqli_fetch_assoc($query);
        $reorder = $result['reorder'];

        $sql2 = "SELECT * FROM brands inner join categories on categories.cat_id = brands.cat_id where categories.office_id = '$office_id' and brands.delete_status = 'no'";

        $query2 = mysqli_query(conn(), $sql2);

        if(!$query2){
            echo mysqli_error(conn());
        }else{
            $reorder = 0;
            if(mysqli_num_rows($query2)>0){
                foreach($query2 as $brandI){
                    $limit = $brandI['re_order'];
                    $brand_id = $brandI['brand_id'];

                    $sql3 = "SELECT SUM(item_quantity) as quantSum FROM items where brand_id= '$brand_id' and items.delete_status ='no'";

                    $query3 = mysqli_query(conn(),$sql3);

                    if(!$query3){
                        echo mysqli_error(conn());
                    }else{
                        if(mysqli_num_rows($query3)>0){
                            $hhh = mysqli_fetch_assoc($query3);
                            
                            if((int) $hhh['quantSum'] <= (int)$limit){
                               $reorder += 1; 
                            }

                        }
                    }
                }
            }

            return $reorder;
        }
       }
    }
}
function getReorders()
{
    $office_id = $_SESSION['welix_loged_in']['office_id'];

        $sql2 = "SELECT * FROM brands inner join categories on categories.cat_id = brands.cat_id where categories.office_id = '$office_id' and brands.delete_status = 'no'";

        $query2 = mysqli_query(conn(), $sql2);

        if(!$query2){
            echo mysqli_error(conn());
        }else{
        
            return $query2;
        }
       
    
}

function fetchOutOfStock()
{
    $office_id = $_SESSION['welix_loged_in']['office_id'];
    $sql = "SELECT COUNT(item_name) AS outOfStock FROM items INNER JOIN categories ON items.cat_id = categories.cat_id WHERE item_quantity <= 0 and categories.office_id ='$office_id' and items.delete_status = 'no' and items.has_sub = 'no'";

    $query = mysqli_query(conn(), $sql);

    if (!$query) {
        echo mysqli_error(conn());
    } else {
        $result = mysqli_fetch_assoc($query);
        $outOfStock = $result['outOfStock'];

        return $outOfStock;
    }
}

function stockWorth(){
    $office_id = $_SESSION['welix_loged_in']['office_id'];

    $sql = "SELECT * FROM items inner join categories on categories.cat_id = items.cat_id where categories.office_id='$office_id' and categories.delete_status = 'no' and items.delete_status = 'no' and items.has_sub = 'no'";

    $query = mysqli_query(conn(), $sql);

    if(!$query){
       echo mysqli_error(conn()); 
    }else{
        $worth = 0;
        if(mysqli_num_rows($query)>0){
            foreach($query as $count){
                $worth = $worth + ((int)$count['item_quantity'] * (int)$count['item_cost']);
            }
        }
        return $worth;
    }
}

function customers()
{
    $office_id = $_SESSION['welix_loged_in']['office_id'];
    $sql = "SELECT * FROM customers lEFT JOIN invoices ON customers.cust_phone = invoices.cust_phone WHERE invoices.office_id = '$office_id' and invoices.delete_status = 'false'";

    $query = mysqli_query(conn(), $sql);

    if (!$query) {
        echo mysqli_error(conn());
    } else {
        return $query;
    }
}
function customersInfo($invoice_no)
{
    $office_id = $_SESSION['welix_loged_in']['office_id'];
    $sql = "SELECT * FROM customers lEFT JOIN invoices ON customers.cust_phone = invoices.cust_phone WHERE invoices.office_id = '$office_id' and invoices.delete_status = 'false' and invoices.invoice_no = '$invoice_no'";

    $query = mysqli_query(conn(), $sql);

    if (!$query) {
        echo mysqli_error(conn());
    } else {
        if(mysqli_num_rows($query)>0){
            $result = mysqli_fetch_assoc($query);

            return $result;
        }
    }
}
function purchaseTimes($aaa)
{
    $office_id = $_SESSION['welix_loged_in']['office_id'];
    $sql = "SELECT COUNT(cust_phone) as purCount FROM invoices WHERE cust_phone = '$aaa' AND office_id = '$office_id'and delete_status = 'false'";

    $query = mysqli_query(conn(), $sql);

    if (!$query) {
        echo mysqli_error(conn());
    } else {
        $result = mysqli_fetch_assoc($query);
        $purCount = $result['purCount'];

        return $purCount;
    }
}

function resentPurc($aaa)
{
    $sql = "SELECT * FROM invoices where invoice_date = (SELECT MAX(invoice_date) from invoices where cust_phone = '$aaa') and delete_status = 'false'";

    $query = mysqli_query(conn(), $sql);

    if (!$query) {
        echo mysqli_error(conn());
    } else {
        $result = mysqli_fetch_assoc($query);
        return $result;
    }
}

function totalSales()
{
    $totalSale = 0;
    if ($_SESSION['season'] == 'today') {
        $sql = "SELECT amount_due FROM invoices WHERE YEAR(invoice_date) = YEAR(CURDATE()) AND MONTH(invoice_date) = MONTH(CURDATE()) AND DAY(invoice_date) = DAY(CURDATE()) and delete_status = 'false'";
    } elseif ($_SESSION['season'] == 'weak') {
        $sql = "SELECT amount_due FROM invoices WHERE YEAR(invoice_date) = YEAR(CURDATE()) AND WEEK(invoice_date) = WEEK(CURDATE()) and delete_status = 'false'";
    } elseif ($_SESSION['season'] == 'month') {
        $sql = "SELECT amount_due FROM invoices WHERE YEAR(invoice_date) = YEAR(CURDATE()) AND MONTH(invoice_date) = MONTH(CURDATE()) and delete_status = 'false'";
    } elseif ($_SESSION['season'] == 'year') {
        $sql = "SELECT amount_due FROM invoices WHERE YEAR(invoice_date) = YEAR(CURDATE()) and delete_status = 'false'";
    } elseif ($_SESSION['season'] == 'customized') {
        $start_date = $_SESSION['start_date'];
        $end_date = $_SESSION['end_date'];

        $sql = "SELECT amount_due FROM invoices WHERE DATE(invoice_date) BETWEEN '$start_date' AND '$end_date' and delete_status = 'false' ";
    } elseif ($_SESSION['season'] == 'byYear') {
        $year = $_SESSION['year'];

        $sql = "SELECT amount_due FROM invoices WHERE YEAR(invoice_date) = '$year' and delete_status = 'false'";
    }

    $query = mysqli_query(conn(), $sql);

    if (!$query) {
        echo mysqli_error(conn());
    } else {
        if (mysqli_num_rows($query) > 0) {
            foreach ($query as $sale) {
                $totalSale += (int)$sale['amount_due'];
            }
        } else {
            $totalSale = 0;
        }
    }

    return $totalSale;
}

function itemSold()
{
    $totalItems = 0;
    if ($_SESSION['season'] == 'today') {
        $sql = "SELECT item_id FROM sold_tems WHERE YEAR(date_sold) = YEAR(CURDATE()) AND MONTH(date_sold) = MONTH(CURDATE()) AND DAY(date_sold) = DAY(CURDATE())";
    } elseif ($_SESSION['season'] == 'weak') {
        $sql = "SELECT item_id FROM sold_tems WHERE YEAR(date_sold) = YEAR(CURDATE()) AND WEEK(date_sold) = WEEK(CURDATE());";
    } elseif ($_SESSION['season'] == 'month') {
        $sql = "SELECT item_id FROM sold_tems WHERE YEAR(date_sold) = YEAR(CURDATE()) AND MONTH(date_sold) = MONTH(CURDATE())";
    } elseif ($_SESSION['season'] == 'year') {
        $sql = "SELECT item_id FROM sold_tems WHERE YEAR(date_sold) = YEAR(CURDATE())";
    } elseif ($_SESSION['season'] == 'customized') {
        $start_date = $_SESSION['start_date'];
        $end_date = $_SESSION['end_date'];

        $sql = "SELECT item_id FROM sold_tems WHERE DATE(date_sold) BETWEEN '$start_date' AND '$end_date'";
    } elseif ($_SESSION['season'] == 'byYear') {

        $year = $_SESSION['year'];

        $sql = "SELECT item_id FROM sold_tems WHERE YEAR(date_sold) = '$year'";
    }

    $query = mysqli_query(conn(), $sql);

    if (!$query) {
        echo mysqli_error(conn());
    } else {


        if (mysqli_num_rows($query) > 0) {
            $inItem = array();
            foreach ($query as $item) {
                if (!in_array($item['item_id'], $inItem)) {
                    $totalItems += 1;
                }

                array_push($inItem, $item['item_id']);
            }
        }
    }

    return  $totalItems;
}

function expenses()
{
    $office_id = office_id();
    if ($_SESSION['expSeasion'] == 'today') {
        $sql = "SELECT * FROM expenses WHERE YEAR(ex_date) = YEAR(CURDATE()) AND MONTH(ex_date) = MONTH(CURDATE()) AND DAY(ex_date) = DAY(CURDATE()) AND office_id = '$office_id' and delete_status = 'no'";
    } elseif ($_SESSION['expSeasion'] == 'week') {
        $sql = "SELECT * FROM expenses WHERE YEAR(ex_date) = YEAR(CURDATE()) AND WEEK(ex_date) = WEEK(CURDATE()) AND office_id = '$office_id' and delete_status = 'no'";
    } elseif ($_SESSION['expSeasion'] == 'month') {
        $sql = "SELECT * FROM expenses WHERE YEAR(ex_date) = YEAR(CURDATE()) AND MONTH(ex_date) = MONTH(CURDATE()) AND office_id = '$office_id' and delete_status = 'no' and delete_status = 'no'";
    } elseif ($_SESSION['expSeasion'] == 'year') {
        $sql = "SELECT * FROM expenses WHERE YEAR(ex_date) = YEAR(CURDATE()) AND office_id = '$office_id' and delete_status = 'no'";
    } else {
    }

    $query = mysqli_query(conn(), $sql);

    if (!$query) {
        echo mysqli_error(conn());
    } else {
        return $query;
    }
}

function store(){
    $office_id = office_id();

    $sql = "SELECT * FROM store WHERE office_id = '$office_id' and delete_status = 'no'";

    $query = mysqli_query(conn(), $sql);

    if(!$query){
        echo mysqli_error(conn());
    }else{
        
        return $query;
    }
}
function ordered(){
    $office_id = office_id();

    $sql = "SELECT * FROM ordered WHERE office_id = '$office_id' and delete_status = 'no'";

    $query = mysqli_query(conn(), $sql);

    if(!$query){
        echo mysqli_error(conn());
    }else{
        
        return $query;
    }
}

function sumExpenses()
{
    if ($_SESSION['expSeasion'] == 'today') {
        $sql = "SELECT SUM(ex_amount) AS ex_amount FROM expenses WHERE YEAR(ex_date) = YEAR(CURDATE()) AND MONTH(ex_date) = MONTH(CURDATE()) AND DAY(ex_date) = DAY(CURDATE()) and delete_status = 'no'";
    } elseif ($_SESSION['expSeasion'] == 'week') {
        $sql = "SELECT SUM(ex_amount) AS ex_amount FROM expenses WHERE YEAR(ex_date) = YEAR(CURDATE()) AND WEEK(ex_date) = WEEK(CURDATE()) and delete_status = 'no'";
    } elseif ($_SESSION['expSeasion'] == 'month') {
        $sql = "SELECT SUM(ex_amount) AS ex_amount FROM expenses WHERE YEAR(ex_date) = YEAR(CURDATE()) AND MONTH(ex_date) = MONTH(CURDATE()) and delete_status = 'no'";
    } elseif ($_SESSION['expSeasion'] == 'year') {
        $sql = "SELECT SUM(ex_amount) AS ex_amount FROM expenses WHERE YEAR(ex_date) = YEAR(CURDATE()) and delete_status = 'no'";
    } else {
    }

    $query = mysqli_query(conn(), $sql);

    if (!$query) {
        echo mysqli_error(conn());
    } else {
        $result = mysqli_fetch_assoc($query);

        return number_format($result['ex_amount']) . " Tsh";
    }
}
function sumStore()
{
    $sql = "SELECT SUM(item_cost) AS tol from store where delete_status = 'no'";

    $query = mysqli_query(conn(), $sql);

    if (!$query) {
        echo mysqli_error(conn());
    } else {
        $result = mysqli_fetch_assoc($query);

        return $result['tol'];
    }
}
function sumOrdered()
{
    $sql = "SELECT SUM(item_cost) AS tol from ordered where delete_status = 'no'";

    $query = mysqli_query(conn(), $sql);

    if (!$query) {
        echo mysqli_error(conn());
    } else {
        $result = mysqli_fetch_assoc($query);

        return $result['tol'] ;
    }
}
function sum_xpenses()
{
    $office_id = $_SESSION['welix_loged_in']['office_id'];
    if ($_SESSION['season'] == 'today') {
        $sql = "SELECT SUM(ex_amount) AS ex_amount FROM expenses WHERE YEAR(ex_date) = YEAR(CURDATE()) AND MONTH(ex_date) = MONTH(CURDATE()) AND DAY(ex_date) = DAY(CURDATE()) and delete_status = 'no' and office_id = '$office_id'";
    } elseif ($_SESSION['season'] == 'weak') {
        $sql = "SELECT SUM(ex_amount) AS ex_amount FROM expenses WHERE YEAR(ex_date) = YEAR(CURDATE()) AND WEEK(ex_date) = WEEK(CURDATE()) and delete_status = 'no' and office_id = '$office_id'";
    } elseif ($_SESSION['season'] == 'month') {
        $sql = "SELECT SUM(ex_amount) AS ex_amount FROM expenses WHERE YEAR(ex_date) = YEAR(CURDATE()) AND MONTH(ex_date) = MONTH(CURDATE()) and delete_status = 'no' and office_id = '$office_id'";
    } elseif ($_SESSION['season'] == 'year') {
        $sql = "SELECT SUM(ex_amount) AS ex_amount FROM expenses WHERE YEAR(ex_date) = YEAR(CURDATE()) and delete_status = 'no' and office_id = '$office_id'";
    } elseif ($_SESSION['season'] == 'customized') {
        $start_date = $_SESSION['start_date'];
        $end_date = $_SESSION['end_date'];

        $sql = "SELECT SUM(ex_amount) AS ex_amount FROM expenses WHERE DATE(ex_date) between '$start_date' and '$end_date' and delete_status = 'no' and office_id = '$office_id'";
    } elseif ($_SESSION['season'] == 'byYear') {
        $year = $_SESSION['year'];

        $sql = "SELECT SUM(ex_amount) AS ex_amount FROM expenses WHERE YEAR(ex_date) = '$year' and delete_status = 'no' and office_id = '$office_id'";
    }

    $query = mysqli_query(conn(), $sql);

    if (!$query) {
        echo mysqli_error(conn());
    } else {
        $result = mysqli_fetch_assoc($query);

        return $result['ex_amount'];
    }
}

function productCots()
{
    $office_id = $_SESSION['welix_loged_in']['office_id'];
    if ($_SESSION['season'] == 'today') {
        $sql = "SELECT SUM(item_cost*item_count) AS item_cost FROM sold_tems INNER JOIN invoices ON invoices.invoice_no = sold_tems.invoice_no WHERE YEAR(sold_tems.date_sold) = YEAR(CURDATE()) AND MONTH(sold_tems.date_sold) = MONTH(CURDATE()) AND DAY(sold_tems.date_sold) = DAY(CURDATE()) AND invoices.office_id = '$office_id'";
    } elseif ($_SESSION['season'] == 'weak') {
        $sql = "SELECT SUM(item_cost*item_count) AS item_cost FROM sold_tems INNER JOIN invoices ON invoices.invoice_no = sold_tems.invoice_no WHERE YEAR(sold_tems.date_sold) = YEAR(CURDATE()) AND WEEK(sold_tems.date_sold) = WEEK(CURDATE());";
    } elseif ($_SESSION['season'] == 'month') {
        $sql = "SELECT SUM(item_cost*item_count) AS item_cost FROM sold_tems INNER JOIN invoices ON invoices.invoice_no = sold_tems.invoice_no WHERE YEAR(sold_tems.date_sold) = YEAR(CURDATE()) AND MONTH(sold_tems.date_sold) = MONTH(CURDATE())";
    } elseif ($_SESSION['season'] == 'year') {
        $sql = "SELECT SUM(item_cost*item_count) AS item_cost FROM sold_tems INNER JOIN invoices ON invoices.invoice_no = sold_tems.invoice_no WHERE YEAR(sold_tems.date_sold) = YEAR(CURDATE())";
    } elseif ($_SESSION['season'] == 'customized') {
        $start_date = $_SESSION['start_date'];
        $end_date = $_SESSION['end_date'];
        $sql = "SELECT SUM(item_cost*item_count) AS item_cost FROM sold_tems INNER JOIN invoices ON invoices.invoice_no = sold_tems.invoice_no WHERE DATE(sold_tems.date_sold) BETWEEN '$start_date' and '$end_date'";
    } elseif ($_SESSION['season'] == 'byYear') {
        $year = $_SESSION['year'];

        $sql = "SELECT SUM(item_cost*item_count) AS item_cost FROM sold_tems INNER JOIN invoices ON invoices.invoice_no = sold_tems.invoice_no WHERE YEAR(sold_tems.date_sold) = '$year'";
    }

    $query = mysqli_query(conn(), $sql);

    if (!$query) {
        echo mysqli_error(conn());
    } else {
        $result = mysqli_fetch_assoc($query);

        return $result['item_cost'];
    }
}
function perOutstanding()
{
    $office_id = $_SESSION['welix_loged_in']['office_id'];
    if ($_SESSION['season'] == 'today') {
        $sql = "SELECT SUM(amount_paid - amount_due) AS total_due FROM invoices WHERE YEAR(invoice_date) = YEAR(CURDATE()) AND MONTH(invoice_date) = MONTH(CURDATE()) AND DAY(invoice_date) = DAY(CURDATE()) AND payment_status = 'not_full_paid' and office_id = '$office_id'";
    } elseif ($_SESSION['season'] == 'weak') {
        $sql = "SELECT SUM(amount_paid - amount_due) AS total_due FROM invoices WHERE YEAR(invoice_date) = YEAR(CURDATE()) AND WEEK(invoice_date) = WEEK(CURDATE()) AND payment_status = 'not_full_paid'";
    } elseif ($_SESSION['season'] == 'month') {
        $sql = "SELECT SUM(amount_paid - amount_due) AS total_due FROM invoices WHERE YEAR(invoice_date) = YEAR(CURDATE()) AND MONTH(invoice_date) = MONTH(CURDATE()) and office_id = '$office_id'";
    } elseif ($_SESSION['season'] == 'year') {
        $sql = "SELECT SUM(amount_paid - amount_due) AS total_due FROM invoices WHERE YEAR(invoice_date) = YEAR(CURDATE()) and office_id = '$office_id'";
    } elseif ($_SESSION['season'] == 'customized') {
        $start_date = $_SESSION['start_date'];
        $end_date = $_SESSION['end_date'];

        $sql = "SELECT SUM(amount_paid - amount_due) AS total_due FROM invoices WHERE office_id = '$office_id' AND DATE(invoice_date) between '$start_date' and '$end_date'";
    } elseif ($_SESSION['season'] == 'byYear') {
        $year = $_SESSION['year'];

        $sql = "SELECT SUM(amount_paid - amount_due) AS total_due FROM invoices WHERE YEAR(invoice_date) = '$year' and office_id = '$office_id'";
    }

    $query = mysqli_query(conn(), $sql);

    if (!$query) {
        echo mysqli_error(conn());
    } else {
        $result = mysqli_fetch_assoc($query);

        return $result['total_due'];
    }
}

function profit()
{

    $margin = totalSales() - (sum_xpenses() + productCots());
    return number_format($margin);
}

function officeUsers()
{
    $office_id = $_SESSION['welix_loged_in']['office_id'];
    $user_id = $_SESSION['welix_loged_in']['user_id'];
    $sql = "SELECT * FROM invento_users where office_id = '$office_id' and user_id != '$user_id'";

    $query = mysqli_query(conn(), $sql);

    if (!$query) {
        echo mysqli_error(conn());
    } else {
        return $query;
    }
}
function currentUsers()
{
    $office_id = $_SESSION['welix_loged_in']['office_id'];
    $user_id = $_SESSION['welix_loged_in']['user_id'];
    $sql = "SELECT * FROM invento_users where office_id = '$office_id' and user_id = '$user_id'";

    $query = mysqli_query(conn(), $sql);

    if (!$query) {
        echo mysqli_error(conn());
    } else {
        return $query;
    }
}

function singleUser($user_id)
{
    include("connection.php");
    $office_id = $_SESSION['welix_loged_in']['office_id'];
    $stmt = $conn->prepare("SELECT * FROM invento_users WHERE user_id = ? and office_id =?");

    $stmt->bind_param("ss", $user_id, $office_id);
    if ($stmt->execute()) {
        $result = $stmt->get_result();

        return $result;
    } else {
        echo $stmt->error;
    }
}

function dashSales()
{
    include("connection.php");
    $sql = "SELECT * FROM invoices WHERE YEAR(invoice_date) = YEAR(CURDATE()) AND MONTH(invoice_date) = MONTH(CURDATE()) AND DAY(invoice_date) = DAY(CURDATE()) and delete_status = 'false'";

    $query = mysqli_query($conn, $sql);

    if (!$query) {
        echo mysqli_error($conn);
    } else {
        return $query;
    }
}
function dashExpenses()
{
    include("connection.php");
    $sql = "SELECT * FROM expenses WHERE YEAR(ex_date) = YEAR(CURDATE()) AND MONTH(ex_date) = MONTH(CURDATE()) AND DAY(ex_date) = DAY(CURDATE()) and delete_status = 'no'";

    $query = mysqli_query($conn, $sql);

    if (!$query) {
        echo mysqli_error($conn);
    } else {
        return $query;
    }
}

function allSalesRev()
{
    include("connection.php");
    $office_id = $_SESSION['welix_loged_in']['office_id'];
    if ($_SESSION['season'] == 'today') {
        $sql = "SELECT items.item_name, items.item_id, sold_tems.item_cost, sold_tems.item_price,sold_tems.item_count, SUM(sold_tems.total_cost) AS frequency
            FROM sold_tems
            JOIN items ON sold_tems.item_id = items.item_id join categories on items.cat_id = categories.cat_id WHERE YEAR(sold_tems.date_sold) = YEAR(CURDATE()) AND MONTH(sold_tems.date_sold) = MONTH(CURDATE()) AND DAY(sold_tems.date_sold) = DAY(CURDATE()) and categories.office_id = '$office_id'
            GROUP BY sold_tems.item_id
            ORDER BY frequency DESC";
    } elseif ($_SESSION['season'] == 'weak') {
        $sql = "SELECT items.item_name, items.item_id, sold_tems.item_cost, sold_tems.item_price,sold_tems.item_count, SUM(sold_tems.total_cost) AS frequency
            FROM sold_tems
            JOIN items ON sold_tems.item_id = items.item_id join categories on items.cat_id = categories.cat_id WHERE YEAR(sold_tems.date_sold) = YEAR(CURDATE()) AND WEEK(sold_tems.date_sold) = WEEK(CURDATE()) and categories.office_id = '$office_id'
            GROUP BY sold_tems.item_id
            ORDER BY frequency DESC ";
    } elseif ($_SESSION['season'] == 'month') {
        $sql = "SELECT items.item_name, items.item_id, sold_tems.item_cost, sold_tems.item_price, sold_tems.item_count, SUM(sold_tems.total_cost) AS frequency
            FROM sold_tems
            JOIN items ON sold_tems.item_id = items.item_id join categories on items.cat_id = categories.cat_id WHERE YEAR(sold_tems.date_sold) = YEAR(CURDATE()) AND MONTH(sold_tems.date_sold) = MONTH(CURDATE()) and categories.office_id = '$office_id'
            GROUP BY sold_tems.item_id
            ORDER BY frequency DESC";
    } elseif ($_SESSION['season'] == 'year') {
        $sql = "SELECT items.item_name, items.item_id, sold_tems.item_cost, sold_tems.item_price,sold_tems.item_count, SUM(sold_tems.total_cost) AS frequency
        FROM sold_tems
        JOIN items ON sold_tems.item_id = items.item_id join categories on items.cat_id = categories.cat_id WHERE YEAR(sold_tems.date_sold) = YEAR(CURDATE()) and categories.office_id = '$office_id'
        GROUP BY sold_tems.item_id
        ORDER BY frequency DESC";
    } elseif ($_SESSION['season'] == 'customized') {
        $start_date = $_SESSION['start_date'];
        $end_date = $_SESSION['end_date'];

        $sql = "SELECT items.item_name, items.item_id, sold_tems.item_cost, sold_tems.item_price,sold_tems.item_count, SUM(sold_tems.total_cost) AS frequency
            FROM sold_tems JOIN items ON sold_tems.item_id = items.item_id join categories on items.cat_id = categories.cat_id WHERE DATE(sold_tems.date_sold) BETWEEN '$start_date' AND '$end_date' and categories.office_id = '$office_id' GROUP BY sold_tems.item_id
            ORDER BY frequency DESC";
    } elseif ($_SESSION['season'] == 'byYear') {
        $year = $_SESSION['year'];

        $sql = "SELECT items.item_name, items.item_id, sold_tems.item_cost, sold_tems.item_price,sold_tems.item_count, SUM(sold_tems.total_cost) AS frequency
            FROM sold_tems JOIN items ON sold_tems.item_id = items.item_id join categories on items.cat_id = categories.cat_id WHERE YEAR(sold_tems.date_sold) = '$year' and categories.office_id = '$office_id' GROUP BY sold_tems.item_id
            ORDER BY frequency DESC";
    }



    $query = mysqli_query($conn, $sql);

    if (!$query) {
        echo mysqli_error($conn);
    } else {
        return $query;
    }
}

function saleCount($item_id)
{
    include("connection.php");
    if ($_SESSION['season'] == 'today') {
        $sql = "SELECT SUM(sold_tems.item_count) AS counts
        FROM sold_tems
        WHERE YEAR(sold_tems.date_sold) = YEAR(CURDATE()) AND MONTH(sold_tems.date_sold) = MONTH(CURDATE()) AND DAY(sold_tems.date_sold) = DAY(CURDATE())
        AND sold_tems.item_id ='$item_id'";
    } elseif ($_SESSION['season'] == 'weak') {
        $sql = "SELECT SUM(sold_tems.item_count) AS counts
        FROM sold_tems
        WHERE YEAR(sold_tems.date_sold) = YEAR(CURDATE()) AND WEEK(sold_tems.date_sold) = WEEK(CURDATE())
        AND sold_tems.item_id ='$item_id'";
    } elseif ($_SESSION['season'] == 'month') {
        $sql = "SELECT SUM(sold_tems.item_count) AS counts
        FROM sold_tems
        WHERE YEAR(sold_tems.date_sold) = YEAR(CURDATE()) AND MONTH(sold_tems.date_sold) = MONTH(CURDATE())
        AND sold_tems.item_id ='$item_id'";
    } elseif ($_SESSION['season'] == 'year') {
        $sql = "SELECT SUM(sold_tems.item_count) AS counts
    FROM sold_tems WHERE YEAR(sold_tems.date_sold) = YEAR(CURDATE())
    AND sold_tems.item_id ='$item_id'";
    } elseif ($_SESSION['season'] == 'customized') {
        $start_date = $_SESSION['start_date'];
        $end_date = $_SESSION['end_date'];
        $sql = "SELECT SUM(sold_tems.item_count) AS counts
        FROM sold_tems
        WHERE DATE(sold_tems.date_sold) BETWEEN '$start_date' AND '$end_date'
        AND sold_tems.item_id ='$item_id'";
    } elseif ($_SESSION['season'] == 'byYear') {
        $year = $_SESSION['year'];

        $sql = "SELECT SUM(sold_tems.item_count) AS counts
        FROM sold_tems
        WHERE YEAR(sold_tems.date_sold) = '$year'
        AND sold_tems.item_id ='$item_id'";
    }



    $query = mysqli_query($conn, $sql);

    if (!$query) {
        echo mysqli_error($conn);
    } else {
        if (mysqli_num_rows($query) > 0) {
            $result = mysqli_fetch_assoc($query);
            return $result;
        }
    }
}

function payments($invo_id)
{
    include("connection.php");
    $stmt = $conn->prepare("SELECT * FROM payments WHERE invoice_no =? and office_id = ?");
    $stmt->bind_param("ss", $invo_id, $office_id);

    $office_id = $_SESSION['welix_loged_in']['office_id'];

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        return $result;
    } else {
        echo $stmt->error;
    }
}

function saleYears()
{
    include("connection.php");
    $sql = "SELECT DISTINCT YEAR(date_sold) as yr FROM sold_tems";

    $query = mysqli_query($conn, $sql);

    if (!$query) {
        echo mysqli_error($conn);
    } else {
        return $query;
    }
}


function brands($cat_id)
{
    include("connection.php");
    $office_id = $_SESSION['welix_loged_in']['office_id'];
    $cat_id = mysqli_escape_string($conn, $cat_id);

    $sql = "SELECT * FROM brands INNER JOIN categories on categories.cat_id = brands.cat_id where categories.cat_id = '$cat_id' and categories.office_id= '$office_id' and brands.delete_status = 'no'";

    $query = mysqli_query($conn, $sql);

    if (!$query) {
        echo mysqli_error($conn);
    } else {
        return $query;
    }
}
function oneBrands($brand)
{
    include("connection.php");
    $office_id = $_SESSION['welix_loged_in']['office_id'];
    $cat_id = mysqli_escape_string($conn, $brand);

    $sql = "SELECT * FROM brands INNER JOIN categories on categories.cat_id = brands.cat_id where brands.brand_id = '$brand' and categories.office_id= '$office_id'";

    $query = mysqli_query($conn, $sql);

    if (!$query) {
        echo mysqli_error($conn);
    } else {
        if (mysqli_num_rows($query) > 0) {
            $result = mysqli_fetch_assoc($query);
            return $result;
        }
    }
}

function itemsPerBranda($cat_id, $brand, $sub)
{
    include("connection.php");
    $cat_id = mysqli_escape_string($conn, $cat_id);
    $brand = mysqli_escape_string($conn, $brand);
    $office_id = $_SESSION['welix_loged_in']['office_id'];
    if ($brand == "All") {

        if($sub == "All"){
            $sql = "SELECT * FROM items INNER JOIN categories on items.cat_id = categories.cat_id where categories.cat_id = '$cat_id' and categories.office_id = '$office_id' and categories.delete_status = 'no' and items.has_sub='no' and items.delete_status = 'no' ";
        }else{
            $sql = "SELECT * FROM items INNER JOIN categories on items.cat_id = categories.cat_id where categories.cat_id = '$cat_id' and categories.office_id = '$office_id' and categories.delete_status = 'no' and items.has_sub='no' and items.sub_item_of = '$sub' and items.delete_status = 'no'";
        }
        
    } else {
        if($sub == "All"){
            $sql = "SELECT * FROM items INNER JOIN categories on items.cat_id = categories.cat_id where categories.cat_id = '$cat_id' and categories.office_id = '$office_id' and categories.delete_status = 'no' and items.brand_id ='$brand' and items.has_sub='no'";
        }else{
            $sql = "SELECT * FROM items INNER JOIN categories on items.cat_id = categories.cat_id where categories.cat_id = '$cat_id' and categories.office_id = '$office_id' and categories.delete_status = 'no' and items.brand_id ='$brand' and items.has_sub='no'and items.sub_item_of = '$sub'";
        }
       
    }

    $query = mysqli_query($conn, $sql);

    if (!$query) {
        echo mysqli_error($conn);
    } else {
        return $query;
    }
}
function itemsPerBrandaToSubs($cat_id, $brand, $sub)
{
    include("connection.php");
    $cat_id = mysqli_escape_string($conn, $cat_id);
    $brand = mysqli_escape_string($conn, $brand);
    $office_id = $_SESSION['welix_loged_in']['office_id'];
    if ($brand == "All") {

        if($sub == "All"){
            $sql = "SELECT * FROM items INNER JOIN categories on items.cat_id = categories.cat_id where categories.cat_id = '$cat_id' and categories.office_id = '$office_id' and categories.delete_status = 'no' and items.has_sub='yes' ";
        }else{
            $sql = "SELECT * FROM items INNER JOIN categories on items.cat_id = categories.cat_id where categories.cat_id = '$cat_id' and categories.office_id = '$office_id' and categories.delete_status = 'no' and items.has_sub='yes' and items.sub_item_of = '$sub' ";
        }
        
    } else {
        if($sub == "All"){
            $sql = "SELECT * FROM items INNER JOIN categories on items.cat_id = categories.cat_id where categories.cat_id = '$cat_id' and categories.office_id = '$office_id' and categories.delete_status = 'no' and items.brand_id ='$brand' and items.has_sub='yes'";
        }else{
            $sql = "SELECT * FROM items INNER JOIN categories on items.cat_id = categories.cat_id where categories.cat_id = '$cat_id' and categories.office_id = '$office_id' and categories.delete_status = 'no' and items.brand_id ='$brand' and items.has_sub='yes'and items.sub_item_of = '$sub'";
        }
       
    }

    $query = mysqli_query($conn, $sql);

    if (!$query) {
        echo mysqli_error($conn);
    } else {
        return $query;
    }
}
function catsInItems($cat_id)
{
    include("connection.php");
    $cat_id = mysqli_escape_string($conn, $cat_id);
    // $brand = mysqli_escape_string($conn, $brand);
    $office_id = $_SESSION['welix_loged_in']['office_id'];
    if ($cat_id == "All") {
        $sql = "SELECT * FROM items INNER JOIN categories on items.cat_id = categories.cat_id where categories.cat_id = '$cat_id' and categories.office_id = '$office_id' and categories.delete_status = 'no' and items.has_sub='yes' and items.delete_status = 'no'";
    } else {
        $sql = "SELECT * FROM items INNER JOIN categories on items.cat_id = categories.cat_id where categories.cat_id = '$cat_id' and categories.office_id = '$office_id' and categories.delete_status = 'no' and items.cat_id ='$cat_id' and items.has_sub='yes' and items.delete_status = 'no'";
    }

    $query = mysqli_query($conn, $sql);

    if (!$query) {
        echo mysqli_error($conn);
    } else {
        return $query;
    }
}

function fetchSubsIten($item_id)
{
    include("connection.php");
    // $cat_id = mysqli_escape_string($conn, $cat_id);
    $item_id = mysqli_escape_string($conn, $item_id);
    $office_id = $_SESSION['welix_loged_in']['office_id'];

    $sql = "SELECT * FROM items INNER JOIN categories on items.cat_id = categories.cat_id where items.sub_item_of = '$item_id' and categories.office_id = '$office_id' and categories.delete_status = 'no' and items.delete_status = 'no'";

    $query = mysqli_query($conn, $sql);

    if (!$query) {
        echo mysqli_error($conn);
    } else {
        return $query;
    }
}


function subReoder(){
    $office_id = $_SESSION['welix_loged_in']['office_id'];

    $sql = "SELECT * FROM items INNER JOIN categories on categories.cat_id = items.cat_id  WHERE items.has_sub = 'yes' and categories.office_id = '$office_id' and categories.delete_status ='no' and items.delete_status ='no'";

    $query = mysqli_query(conn(), $sql);

    if(!$query){
        echo mysqli_error(conn());
    }else{
        return $query;
    }
}

function invoiceItems($invoice_no) {
    $office_id = $_SESSION['welix_loged_in']['office_id'];
    $sql= "SELECT * FROM sold_tems join items on items.item_id =  sold_tems.item_id join invoices on sold_tems.invoice_no = invoices.invoice_no WHERE sold_tems.invoice_no = '$invoice_no' AND invoices.office_id = '$office_id' ";

    $query = mysqli_query(conn(), $sql);

    if(!$query){
        echo mysqli_error(conn());
    }else{
        return $query;
    }
}

function invoiceFigures($invoice_no){
    $office_id = $_SESSION['welix_loged_in']['office_id'];
    $sql ="SELECT * FROM invoices where invoice_no ='$invoice_no' and office_id = '$office_id' ";

    $query = mysqli_query(conn(), $sql);

    if(!$query){
        echo mysqli_error(conn());
    }else{
        if(mysqli_num_rows($query)>0){
            $result = mysqli_fetch_assoc($query);

            return $result;
        }
    }
}