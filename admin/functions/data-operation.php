<?php
session_start();
include("connection.php");
function conn()
{
    include("connection.php");
    return $conn;
}
include("welix.php");
if (isset($_POST['saveNewCat'])) {
    // Prepare and bind the statement
    $stmt = $conn->prepare("INSERT INTO categories (office_id, cat_name, cat_des) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $office_id, $cat_name, $cat_des);

    // Get the values from the POST request
    $office_id = $_SESSION['welix_loged_in']['office_id'];
    $cat_name = $_POST['cat_name'];
    $cat_des = $_POST['cat_des'];

    // Execute the statement
    if ($stmt->execute()) {
        echo 1;
    } else {
        echo "Error inserting data: " . $stmt->error;
    }

    // Close the statement and the connection
    $stmt->close();
    $conn->close();
}

if (isset($_POST['saveCatEdit'])) {
    // Prepare and bind the statement
    $stmt = $conn->prepare("UPDATE categories SET cat_name = ?, cat_des = ? WHERE cat_id = ?");
    $stmt->bind_param("ssi", $cat_name, $cat_des, $cat_id);

    // Get the values from the POST request
    $cat_name = $_POST['catNameEdit'];
    $cat_des = $_POST['catDesEdit'];
    $cat_id = $_POST['edit_cat_id'];

    // Execute the statement
    if ($stmt->execute()) {
        echo 1;
    } else {
        echo "Error updating data: " . $stmt->error;
    }

    // Close the statement and the connection
    $stmt->close();
    $conn->close();
}

if(isset($_POST['checkPassword'])){
    $password = $_POST['password'];
    $pro_password = md5($password);

    $user_id = $_SESSION['welix_loged_in']['user_id'];

    $sql = "SELECT * FROM invento_users WHERE user_id = '$user_id' and `user_password` = '$pro_password'";

    $query = mysqli_query($conn, $sql);

    if(!$query){
        echo mysqli_error($conn);
    }else{
        if(mysqli_num_rows($query)>0){
            echo 1;
        }else{
            echo "none";
        }
    }
}

if (isset($_POST['addItem'])) {
    $stmt = $conn->prepare("INSERT INTO items (cat_id,brand_id, item_name, item_des,item_unit, item_cost, item_price, item_quantity, reorder_point) VALUES (?, ?,?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssssss", $cat_id, $ItemBrand, $item_name, $item_des, $item_unit, $item_cost, $item_price, $item_quantity, $reorder_point);

    // Get the values from the POST request
    $cat_id = $_POST['catIdToAdd'];
    $item_name = $_POST['itemName'];
    $item_des = $_POST['itemDes'];
    $item_unit = $_POST['itemUnit'];
    $item_cost = $_POST['itemCost'];
    $item_price = $_POST['itemPrice'];
    $item_quantity = $_POST['itemQuantity'];
    $reorder_point = $_POST['reorderPoint'];
    $ItemBrand = $_POST['ItemBrand'];

    // Execute the statement
    if ($stmt->execute()) {
        echo 1;
    } else {
        echo "Error inserting data: " . $stmt->error;
    }

    // Close the statement and the connection
    $stmt->close();
    $conn->close();
}
if (isset($_POST['editItem'])) {
    $stmt = $conn->prepare("UPDATE items SET item_name=?, item_des=?,item_unit=?,item_cost=?,item_price=?, item_quantity=?, reorder_point=? WHERE item_id = ?");
    $stmt->bind_param("ssssssss", $item_name, $item_des, $item_unit, $item_cost, $item_price, $item_quantity, $reorder_point, $item_id);

    // Get the values from the POST request
    $item_id = $_POST['itemIdToEdit'];
    $item_name = $_POST['itemName'];
    $item_des = $_POST['itemDes'];
    $item_unit = $_POST['itemUnit'];
    $item_cost = $_POST['itemCost'];
    $item_price = $_POST['itemPrice'];
    $item_quantity = $_POST['itemQuantity'];
    $reorder_point = $_POST['reorderPoint'];

    // Execute the statement
    if ($stmt->execute()) {
        echo 1;
    } else {
        echo "Error inserting data: " . $stmt->error;
    }

    // Close the statement and the connection
    $stmt->close();
    $conn->close();
}

if (isset($_POST['addToItem'])) {
    $stmt = $conn->prepare("UPDATE items SET item_quantity = (item_quantity + ?) WHERE item_id=?");
    $stmt->bind_param("ss", $item_quantity, $item_id);

    $item_id = $_POST['item_id'];
    $item_quantity = $_POST['amountToAdd'];

    if ($stmt->execute()) {
        echo 1;
    } else {
        echo "Error inserting data: " . $stmt->error;
    }
}

if (isset($_POST['saveSMSTemplate'])) {
    $stmt = $conn->prepare("INSERT INTO sms_template (office_id, smsTitle, sms_target, sms_content) VALUES (?,?,?,?)");

    $stmt->bind_param("ssss", $office_id, $smsTitle, $smsTarget, $smsContent);

    $office_id = $_SESSION['welix_loged_in']['office_id'];
    $smsTitle = $_POST['smsTitle'];
    $smsTarget = $_POST['smsTarget'];
    $smsContent = $_POST['smsContent'];

    if ($stmt->execute()) {
        echo 1;
    } else {
        $stmt->error;
    }
}

if (isset($_POST['fetchSchdules'])) {
    $office_id = $_SESSION['welix_loged_in']['office_id'];
    $sql = "SELECT * FROM scheduled_sms INNER JOIN sms_template ON scheduled_sms.temp_id = sms_template.temp_id WHERE sms_template.office_id = '$office_id' order by scheduled_id desc";

    $query = mysqli_query($conn, $sql);

    if (!$query) {
        echo mysqli_error($conn);
    } else {
        $scheDu = array();
        foreach ($query as $schItem) {
            array_push($scheDu, $schItem);
        }
        echo json_encode($scheDu);
    }
}

if (isset($_POST['tempSelected'])) {
    $stmt = $conn->prepare("INSERT INTO scheduled_sms (temp_id, date, time, scheduled_type, scheduled_status) VALUES (?,?,?,?,?)");
    $stmt->bind_param("sssss", $temp_id, $sendDate, $sendTime, $scheduled_type, $scheduled_status);


    $temp_id = $_POST['temp_id'];
    $sendDate = $_POST['sendDate'];
    $sendTime = $_POST['sendTime'];
    $scheduled_type = $_POST['scheduled_type'];
    $scheduled_status = 'active';

    if ($stmt->execute()) {
        echo 1;
    } else {
        echo $stmt->error;
    }
}

if (isset($_POST['deleteSch'])) {
    $stmt = $conn->prepare("DELETE FROM scheduled_sms WHERE scheduled_id =?");
    $stmt->bind_param("s", $scheduled_id);

    $scheduled_id = $_POST['scheduled_id'];

    if ($stmt->execute()) {
        echo 1;
    } else {
        echo $stmt->error;
    }
}

if (isset($_POST['fetchInvoInfo'])) {
    $stmt = $conn->prepare("SELECT * FROM invoices WHERE invoice_id = ? AND office_id =? and delete_status = ?");
    $stmt->bind_param("sss", $invoice_id, $office_id, $del_stat);

    $invoice_id = $_POST['invoice_id'];
    $office_id = $_SESSION['welix_loged_in']['office_id'];
    $del_stat = 'false';

    if ($stmt->execute()) {
        // Fetch the count
        $result = $stmt->get_result();

        // Check if the count is greater than 0
        if ($result->num_rows > 0) {
            $invoList = array();

            foreach ($result as $invoItem) {
                array_push($invoList, $invoItem);
            }

            echo json_encode($invoList);
        } else {
            echo [];
        }
    } else {
        echo $stmt->error;
    }
}
if (isset($_POST['fetcInvoItems'])) {
    $stmt = $conn->prepare("SELECT * FROM sold_tems INNER JOIN items on sold_tems.item_id = items.item_id JOIN categories ON items.cat_id = categories.cat_id WHERE sold_tems.invoice_no = ? and categories.office_id =?");
    $stmt->bind_param("ss", $invoice_id, $office_id);

    $invoice_id = $_POST['invoice_id'];
    $office_id = $_SESSION['welix_loged_in']['office_id'];

    if ($stmt->execute()) {
        // Fetch the count
        $result = $stmt->get_result();

        // Check if the count is greater than 0
        if ($result->num_rows > 0) {
            $invoList = array();

            foreach ($result as $invoItem) {
                array_push($invoList, $invoItem);
            }

            echo json_encode($invoList);
        } else {
            echo 0;
        }
    } else {
        echo $stmt->error;
    }
}

if (isset($_POST['fetchPaiAmount'])) {
    $stmt = $conn->prepare("SELECT * FROM payments where invoice_no =?");
    $stmt->bind_param("s", $invoice_no);

    $invoice_no = $_POST['invoice_no'];

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $items = array();

            foreach ($result as $aa) {
                array_push($items, $aa);
            }

            echo json_encode($items);
        } else {
            echo 0;
        }
    } else {
        echo $stmt->error;
    }
}

if (isset($_POST['loginUser'])) {
    $stmt = $conn->prepare("SELECT * FROM invento_users where user_phone = ? and user_password	=?");
    $stmt->bind_param("ss", $username, $pro_password);

    $username = $_POST['username'];
    $password = $_POST['password'];

    $pro_password = md5($password);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            foreach ($result as $userInfo) {
                $user_name = $userInfo['user_name'];
                $user_phone = $userInfo['user_phone'];
                $office_id = $userInfo['office_id'];
                $user_id = $userInfo['user_id'];
                $user_role = $userInfo['user_role'];

                $_SESSION['welix_loged_in'] = array(
                    "username" => $user_name,
                    "userphone" => $user_phone,
                    "user_id" => $user_id,
                    "office_id" => $office_id,
                    "user_role" => $user_role
                );

                $_SESSION['season'] = "today";
                $_SESSION['expSeasion'] = "today";
            }

            echo 1;
        } else {
            echo 2;
        }
    } else {
        echo $stmt->error;
    }
}

if (isset($_POST['setSeason'])) {
    $season = $_POST['season'];

    $_SESSION['season'] = $season;

    echo 1;
}

if (isset($_POST['setExpSeason'])) {
    $aaa = $_POST['aaa'];

    $_SESSION['expSeasion'] = $aaa;

    echo 1;
}

if (isset($_POST['insetExpenses'])) {
    $expenseName = $_POST['expenseName'];
    $expenseAmount = $_POST['expenseAmount'];
    $expenseDate = $_POST['expenseDate'];
    $office_id = $_SESSION['welix_loged_in']['office_id'];


    // Example usage
    $table = "expenses";
    $data = array(
        "office_id" => $office_id,
        "ex_name" => $expenseName,
        "ex_amount" => $expenseAmount,
        "ex_date" => $expenseDate
    );

    db($table, $data);
}
if (isset($_POST['insetStore'])) {
    $expenseName = $_POST['expenseName'];
    $expenseAmount = $_POST['expenseAmount'];
    $expenseDate = $_POST['expenseDate'];
    $office_id = $_SESSION['welix_loged_in']['office_id'];


    // Example usage
    $table = "store";
    $data = array(
        "office_id" => $office_id,
        "item_name" => $expenseName,
        "item_cost" => $expenseAmount,
        "date_purchased" => $expenseDate
    );

    db($table, $data);
}
if (isset($_POST['insetOrder'])) {
    $expenseName = $_POST['expenseName'];
    $expenseAmount = $_POST['expenseAmount'];
    $expenseDate = $_POST['expenseDate'];
    $office_id = $_SESSION['welix_loged_in']['office_id'];


    // Example usage
    $table = "ordered";
    $data = array(
        "office_id" => $office_id,
        "item_name" => $expenseName,
        "item_cost" => $expenseAmount,
        "date_ordered" => $expenseDate
    );

    db($table, $data);
}
if (isset($_POST['editExpenses'])) {
    $expenseName = $_POST['expenseName'];
    $expenseAmount = $_POST['expenseAmount'];
    $expenseDate = $_POST['expenseDate'];
    $ex_id = $_POST['ex_id'];
    $office_id = $_SESSION['welix_loged_in']['office_id'];


    $sql = "UPDATE expenses SET ex_name = '$expenseName', ex_amount ='$expenseAmount', ex_date = '$expenseDate' where ex_id = '$ex_id' and office_id = '$office_id'";

    $query = mysqli_query($conn, $sql);

    if (!$query) {
        echo mysqli_error($conn);
    } else {
        echo 1;
    }
}
if (isset($_POST['editStoreItem'])) {
    $expenseName = $_POST['expenseName'];
    $expenseAmount = $_POST['expenseAmount'];
    $expenseDate = $_POST['expenseDate'];
    $ex_id = $_POST['ex_id'];
    $office_id = $_SESSION['welix_loged_in']['office_id'];


    $sql = "UPDATE store SET item_name = '$expenseName', item_cost ='$expenseAmount', date_purchased = '$expenseDate' where item_id = '$ex_id' and office_id = '$office_id'";

    $query = mysqli_query($conn, $sql);

    if (!$query) {
        echo mysqli_error($conn);
    } else {
        echo 1;
    }
}
if (isset($_POST['editOrderedItem'])) {
    $expenseName = $_POST['expenseName'];
    $expenseAmount = $_POST['expenseAmount'];
    $expenseDate = $_POST['expenseDate'];
    $ex_id = $_POST['ex_id'];
    $office_id = $_SESSION['welix_loged_in']['office_id'];


    $sql = "UPDATE ordered SET item_name = '$expenseName', item_cost ='$expenseAmount', date_ordered = '$expenseDate' where order_id = '$ex_id' and office_id = '$office_id'";

    $query = mysqli_query($conn, $sql);

    if (!$query) {
        echo mysqli_error($conn);
    } else {
        echo 1;
    }
}

function updateInvoPayment($invo_id, $paid_amount)
{
    include("connection.php");
    $paid_amount = (int)$paid_amount;
    $office_id = $_SESSION['welix_loged_in']['office_id'];
    $sql = "UPDATE invoices set amount_paid =(amount_paid + $paid_amount) where invoice_no = '$invo_id' AND office_id = '$office_id'";

    $query = mysqli_query($conn, $sql);

    if (!$query) {
        echo mysqli_error($conn);
    } else {
        $cSql = "SELECT * FROM invoices where invoice_no ='$invo_id' and office_id = '$office_id' and delete_status = 'false'";

        $cquery = mysqli_query($conn, $cSql);

        if (!$cquery) {
            echo mysqli_error($conn);
        } else {
            if (mysqli_num_rows($cquery) > 0) {
                $cresult = mysqli_fetch_array($cquery);

                $amount_due = $cresult['amount_due'];
                $amount_paid = $cresult['amount_paid'];

                // checking the status
                if (((int)$amount_due - (int)$amount_paid) <= 0) {
                    $usql = "UPDATE invoices SET payment_status = 'full_paid' WHERE invoice_id = '$invo_id' and office_id = '$office_id'";

                    $uquery = mysqli_query($conn, $usql);

                    if (!$uquery) {
                        echo mysqli_error($conn);
                    } else {
                        return 1;
                    }
                } else {
                    return 1;
                }
            } else {
                echo $invo_id;
            }
        }
    }
}

if (isset($_POST['addPayToCust'])) {
    $invo_id = $_POST['invo_no'];
    $paid_amount = $_POST['paid_amount'];
    $custPayMethod = $_POST['custPayMethod'];
    $office_id = $_SESSION['welix_loged_in']['office_id'];

    if (updateInvoPayment($invo_id, $paid_amount) == 1) {
        $sql = "INSERT INTO payments (pay_id,invoice_no, office_id, paid_amount, pay_method)  VALUES(
            '','$invo_id', $office_id, '$paid_amount','$custPayMethod'
        )";

        $query = mysqli_query($conn, $sql);
        if (!$query) {
            echo mysqli_error($conn);
        } else {
            $sqlx = "SELECT invoices.amount_due, SUM(payments.paid_amount) as total_paid FROM invoices JOIN payments ON invoices.invoice_no = payments.invoice_no WHERE invoices.invoice_no = '$invo_id' and invoices.office_id = '$office_id' and invoices.delete_status = 'false'";

            $queryx = mysqli_query($conn, $sqlx);

            if (!$queryx) {
                echo mysqli_error($conn);
            } else {
                if (mysqli_num_rows($queryx) > 0) {
                    $result = mysqli_fetch_assoc($queryx);

                    if (((int)$result['total_paid']) >= (int)$result['amount_due']) {
                        $sqly = "UPDATE invoices SET payment_status = 'full paid' where invoice_no = '$invo_id' and office_id = '$office_id'";

                        $queryy = mysqli_query($conn, $sqly);

                        if (!$queryy) {
                            echo mysqli_error($conn);
                        } else {
                            echo 1;
                        }
                    } else {
                        echo 1;
                    }
                }
            }
        }
    } else {
        echo "Error!";
    }
}

if (isset($_POST['addNewUser'])) {
    $stmt = $conn->prepare("INSERT INTO invento_users (office_id, user_name, user_email, user_phone, user_password,user_role, user_status) VALUES(?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssss", $office_id, $fName, $uEmail, $phone, $pro_password, $user_role, $user_status);

    $office_id = $_SESSION['welix_loged_in']['office_id'];
    $phone = $_POST['phone'];
    $fName = $_POST['fName'];
    $uEmail = $_POST['uEmail'];
    $uSPass = $_POST['uSPass'];
    $user_role = $_POST['user_role'];
    $user_status = "Active";
    $pro_password = md5($uSPass);

    if ($stmt->execute()) {
        echo 1;
    } else {
        echo $stmt->error;
    }
}

if (isset($_POST['updateUserInfo'])) {
    $office_id = $_SESSION['welix_loged_in']['office_id'];
    $user_id = $_SESSION['welix_loged_in']['user_id'];

    $sPass = $_POST['sPass'];
    if ($sPass == "") {
        $stmt = $conn->prepare("UPDATE  invento_users SET user_name = ?, user_email=?, user_phone =? WHERE user_id =? and office_id=?");
        $stmt->bind_param("sssss", $fullNAme, $loginEmail, $loginPhone, $user_id, $office_id);
    } else {
        $pro_password = md5($sPass);
        $stmt = $conn->prepare("UPDATE  invento_users SET user_name = ?, user_email=?, user_phone =?, user_password =? WHERE user_id =? and office_id=?");
        $stmt->bind_param("ssssss", $fullNAme, $loginEmail, $loginPhone, $pro_password, $user_id, $office_id);
    }

    $fullNAme = $_POST['fullNAme'];
    $loginEmail = $_POST['loginEmail'];
    $loginPhone = $_POST['loginPhone'];

    if ($stmt->execute()) {
        $_SESSION['welix_loged_in']['username'] = $fullNAme;
        echo 1;
    } else {
        echo $stmt->error;
    }
}
if (isset($_POST['updateUserInfodd'])) {
    $office_id = $_SESSION['welix_loged_in']['office_id'];
    $user_id = $_POST['user_id'];

    $sPass = $_POST['sPass'];
    if ($sPass == "") {
        $stmt = $conn->prepare("UPDATE  invento_users SET user_name = ?, user_email=?, user_phone =? WHERE user_id =? and office_id=?");
        $stmt->bind_param("sssss", $fullNAme, $loginEmail, $loginPhone, $user_id, $office_id);
    } else {
        $pro_password = md5($sPass);
        $stmt = $conn->prepare("UPDATE  invento_users SET user_name = ?, user_email=?, user_phone =?, user_password =? WHERE user_id =? and office_id=?");
        $stmt->bind_param("ssssss", $fullNAme, $loginEmail, $loginPhone, $pro_password, $user_id, $office_id);
    }

    $fullNAme = $_POST['fullNAme'];
    $loginEmail = $_POST['loginEmail'];
    $loginPhone = $_POST['loginPhone'];

    if ($stmt->execute()) {
        echo 1;
    } else {
        echo $stmt->error;
    }
}


if (isset($_POST['fetchTop'])) {
    if ($_SESSION['season'] == 'today') {
        $sql = "SELECT items.item_name, SUM(sold_tems.item_count) AS frequency
        FROM sold_tems
        JOIN items ON sold_tems.item_id = items.item_id WHERE YEAR(sold_tems.date_sold) = YEAR(CURDATE()) AND MONTH(sold_tems.date_sold) = MONTH(CURDATE()) AND DAY(sold_tems.date_sold) = DAY(CURDATE())
        GROUP BY sold_tems.item_id
        ORDER BY frequency DESC LIMIT 10";
    } elseif ($_SESSION['season'] == 'weak') {
        $sql = "SELECT items.item_name, SUM(sold_tems.item_count) AS frequency
        FROM sold_tems
        JOIN items ON sold_tems.item_id = items.item_id WHERE YEAR(sold_tems.date_sold) = YEAR(CURDATE()) AND WEEK(sold_tems.date_sold) = WEEK(CURDATE())
        GROUP BY sold_tems.item_id
        ORDER BY frequency DESC LIMIT 10";
    } elseif ($_SESSION['season'] == 'month') {
        $sql = "SELECT items.item_name, SUM(sold_tems.item_count) AS frequency
        FROM sold_tems
        JOIN items ON sold_tems.item_id = items.item_id WHERE YEAR(sold_tems.date_sold) = YEAR(CURDATE()) AND MONTH(sold_tems.date_sold) = MONTH(CURDATE())
        GROUP BY sold_tems.item_id
        ORDER BY frequency DESC LIMIT 10";
    } elseif ($_SESSION['season'] == 'year') {
        $sql = "SELECT items.item_name, SUM(sold_tems.item_count) AS frequency
    FROM sold_tems
    JOIN items ON sold_tems.item_id = items.item_id WHERE YEAR(sold_tems.date_sold) = YEAR(CURDATE())
    GROUP BY sold_tems.item_id
    ORDER BY frequency DESC LIMIT 10";
    }elseif($_SESSION['season'] == 'customized'){
        $start_date = $_SESSION['start_date'];
        $end_date = $_SESSION['end_date'];

        $sql = "SELECT items.item_name, SUM(sold_tems.item_count) AS frequency
        FROM sold_tems
        JOIN items ON sold_tems.item_id = items.item_id WHERE DATE(sold_tems.date_sold) between '$start_date' and '$end_date'
        GROUP BY sold_tems.item_id
        ORDER BY frequency DESC LIMIT 10";
    }elseif($_SESSION['season'] == 'byYear'){
        $year = $_SESSION['year'];
        $sql = "SELECT items.item_name, SUM(sold_tems.item_count) AS frequency
        FROM sold_tems
        JOIN items ON sold_tems.item_id = items.item_id WHERE YEAR(sold_tems.date_sold) = '$year'
        GROUP BY sold_tems.item_id
        ORDER BY frequency DESC LIMIT 10";
    }



    $query = mysqli_query($conn, $sql);

    if (!$query) {
        echo mysqli_error($conn);
    } else {
        if (mysqli_num_rows($query) > 0) {
            $data = array();

            while ($row = mysqli_fetch_assoc($query)) {
                $data[] = $row;
            }

            echo json_encode($data);
        }
    }
}
if (isset($_POST['fetchTopReve'])) {
    if ($_SESSION['season'] == 'today') {
        $sql = "SELECT items.item_name, SUM(sold_tems.total_cost) AS frequency
        FROM sold_tems
        JOIN items ON sold_tems.item_id = items.item_id WHERE YEAR(sold_tems.date_sold) = YEAR(CURDATE()) AND MONTH(sold_tems.date_sold) = MONTH(CURDATE()) AND DAY(sold_tems.date_sold) = DAY(CURDATE())
        GROUP BY sold_tems.item_id
        ORDER BY frequency DESC LIMIT 10";
    } elseif ($_SESSION['season'] == 'weak') {
        $sql = "SELECT items.item_name, SUM(sold_tems.total_cost) AS frequency
        FROM sold_tems
        JOIN items ON sold_tems.item_id = items.item_id WHERE YEAR(sold_tems.date_sold) = YEAR(CURDATE()) AND WEEK(sold_tems.date_sold) = WEEK(CURDATE())
        GROUP BY sold_tems.item_id
        ORDER BY frequency DESC LIMIT 10";
    } elseif ($_SESSION['season'] == 'month') {
        $sql = "SELECT items.item_name, SUM(sold_tems.total_cost) AS frequency
        FROM sold_tems
        JOIN items ON sold_tems.item_id = items.item_id WHERE YEAR(sold_tems.date_sold) = YEAR(CURDATE()) AND MONTH(sold_tems.date_sold) = MONTH(CURDATE())
        GROUP BY sold_tems.item_id
        ORDER BY frequency DESC LIMIT 10";
    } elseif ($_SESSION['season'] == 'year') {
        $sql = "SELECT items.item_name, SUM(sold_tems.total_cost) AS frequency
    FROM sold_tems
    JOIN items ON sold_tems.item_id = items.item_id WHERE YEAR(sold_tems.date_sold) = YEAR(CURDATE())
    GROUP BY sold_tems.item_id
    ORDER BY frequency DESC LIMIT 10";
    } elseif ($_SESSION['season'] == "customized") {
        $start_date = $_SESSION['start_date'];
        $end_date = $_SESSION['end_date'];

        $sql = "SELECT items.item_name, SUM(sold_tems.total_cost) AS frequency
        FROM sold_tems
        JOIN items ON sold_tems.item_id = items.item_id WHERE DATE(sold_tems.date_sold) BETWEEN '$start_date' AND '$end_date'
        GROUP BY sold_tems.item_id
        ORDER BY frequency DESC LIMIT 10";    
    }elseif($_SESSION['season'] == "byYear"){
        $year = $_SESSION['year'];

        $sql = "SELECT items.item_name, SUM(sold_tems.total_cost) AS frequency
        FROM sold_tems
        JOIN items ON sold_tems.item_id = items.item_id WHERE YEAR(sold_tems.date_sold) = '$year'
        GROUP BY sold_tems.item_id
        ORDER BY frequency DESC LIMIT 10";  
    }



    $query = mysqli_query($conn, $sql);

    if (!$query) {
        echo mysqli_error($conn);
    } else {
        if (mysqli_num_rows($query) > 0) {

            $data = array();

            while ($row = mysqli_fetch_assoc($query)) {
                $data[] = $row;
            }

            echo json_encode($data);
        }
    }
}

if (isset($_POST['chackCode'])) {
    $stmt = $conn->prepare("SELECT pass_reset_code FROM invento_users where pass_reset_token =? and pass_reset_code = ?");
    $stmt->bind_param("ss", $tk, $codeGiven);

    $codeGiven = $_POST['codeGiven'];
    $tk = $_POST['tk'];

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo 1;
        } else {
            echo "incorrect token";
        }
    } else {
        echo $stmt->error;
    }
}

if (isset($_POST['deleteUser'])) {
    $stmt = $conn->prepare("DELETE FROM invento_users WHERE user_id = ?");
    $stmt->bind_param("s", $hiddenId);

    $hiddenId = $_POST['hiddenId'];

    if ($stmt->execute()) {
        echo 1;
    } else {
        echo $stmt->error;
    }
}
if (isset($_POST['makeAdmin'])) {
    $stmt = $conn->prepare("UPDATE invento_users SET user_role = '1' WHERE user_id = ?");
    $stmt->bind_param("s", $hiddenId);

    $hiddenId = $_POST['hiddenId'];

    if ($stmt->execute()) {
        echo 1;
    } else {
        echo $stmt->error;
    }
}
if (isset($_POST['unmakeAdmin'])) {
    $stmt = $conn->prepare("UPDATE invento_users SET user_role = '2' WHERE user_id = ?");
    $stmt->bind_param("s", $hiddenId);

    $hiddenId = $_POST['hiddenId'];

    if ($stmt->execute()) {
        echo 1;
    } else {
        echo $stmt->error;
    }
}
if (isset($_POST['deleteItem'])) {
    $stmt = $conn->prepare("UPDATE items SET delete_status = 'yes' WHERE item_id = ?");
    $stmt->bind_param("s", $item_id);

    $item_id = $_POST['item_id'];

    if ($stmt->execute()) {
        echo 1;
    } else {
        echo $stmt->error;
    }
}

if (isset($_POST['deleteCat'])) {
    $stmt = $conn->prepare("UPDATE categories SET delete_status = 'yes' WHERE cat_id  = ?");
    $stmt->bind_param("s", $cat_id);

    $cat_id  = $_POST['cat_id'];

    if ($stmt->execute()) {
        $stmt = $conn->prepare("UPDATE items SET delete_status = 'yes' WHERE cat_id = ?");
        $stmt->bind_param("s", $cat_id);

        if ($stmt->execute()) {
            echo 1;
        } else {
            echo $stmt->error;
        }
    } else {
        echo $stmt->error;
    }
}

if (isset($_POST['getCust'])) {
    $_SESSION['season'] = 'customized';
    $_SESSION['start_date'] = $_POST['start_date'];
    $_SESSION['end_date'] = $_POST['end_date'];

    echo 1;
}
if (isset($_POST['byYear'])) {
    $_SESSION['season'] = 'byYear';
    $_SESSION['year'] = $_POST['year'];
   

    echo 1;
}

if(isset($_POST['deleteEX'])){
    $ex_id = $_POST['ex_id'];

    $sql = "UPDATE expenses set delete_status = 'yes' where ex_id = '$ex_id'";

    $query = mysqli_query($conn, $sql);

    if(!$query){
        echo mysqli_error($conn);
    }else{
        echo 1;
    }
}
if(isset($_POST['deleteStoreItem'])){
    $ex_id = $_POST['ex_id'];

    $sql = "UPDATE store set delete_status = 'yes' where item_id = '$ex_id'";

    $query = mysqli_query($conn, $sql);

    if(!$query){
        echo mysqli_error($conn);
    }else{
        echo 1;
    }
}
if(isset($_POST['deleteOrderedItem'])){
    $ex_id = $_POST['ex_id'];

    $sql = "UPDATE ordered set delete_status = 'yes' where order_id = '$ex_id'";

    $query = mysqli_query($conn, $sql);

    if(!$query){
        echo mysqli_error($conn);
    }else{
        echo 1;
    }
}
if(isset($_POST['deleteInvo'])){
    $ex_id = $_POST['invoice_id'];

    $sql = "UPDATE invoices set delete_status = 'true' where invoice_id  = '$ex_id'";

    $query = mysqli_query($conn, $sql);

    if(!$query){
        echo mysqli_error($conn);
    }else{
        echo 1;
    }
}
if(isset($_POST['deleteCust'])){
    $ex_id = $_POST['cust_phone'];

    $sql = "UPDATE customers set delete_status = 'yes' where cust_phone  = '$ex_id'";

    $query = mysqli_query($conn, $sql);

    if(!$query){
        echo mysqli_error($conn);
    }else{
        echo 1;
    }
}

if(isset($_POST['saveBrand'])){
    $brand = $_POST['brand'];
    $cat_id = $_POST['cat_id'];
    $reorder = $_POST['reorder'];

    $data = array(
        'cat_id' => $cat_id,
        'brand_name' => $brand,
        're_order' => $reorder
    );

    db('brands', $data);
}

if(isset($_POST['deleteBrand'])){
    $brand_id = mysqli_escape_string($conn, $_POST['brand_id']);

    $sql = "UPDATE brands b SET b.delete_status = 'yes' WHERE b.brand_id = '$brand_id'";

    $query = mysqli_query($conn, $sql);
    if(!$query){
        echo mysqli_error($conn);
    }else{
        $sql2 = "UPDATE items SET delete_status = 'yes' WHERE brand_id = '$brand_id'";

        $query2 = mysqli_query($conn, $sql2);

        if(!$query2){
            echo mysqli_error($conn);
        }else{
            echo 1;
        }
    }


}

if(isset($_POST['itemSaveOne'])){
    $cat_id = $_POST['cat_id'];
    $brand = $_POST['brand'];
    $itemName = $_POST['itemName'];
    $itemDes = $_POST['itemDes'];
    $subItemOf = $_POST['subItemOf'];
    $reorderPoint = $_POST['reorderPoint'];


    $data= array(
        'cat_id' => $cat_id,
        'brand_id' => $brand,
        'item_name' => $itemName,
        'item_des' => $itemDes,
        'has_sub' => 'yes',
        'sub_item_of' => $subItemOf,
        'reorder_point' => $reorderPoint
    );

    db('items',$data);

}
if(isset($_POST['itemSaveTwo'])){
    $cat_id = $_POST['cat_id'];
    $brand = $_POST['brand'];
    $itemName = $_POST['itemName'];
    $itemDes = $_POST['itemDes'];
    $subItemOf = $_POST['subItemOf'];
    $reorderPoint = $_POST['reorderPoint'];
    $itemUnit = $_POST['itemUnit'];
    $itemQuantity = $_POST['itemQuantity'];
    $itemCost = $_POST['itemCost'];
    $itemPrice = $_POST['itemPrice'];


    $data= array(
        'cat_id' => $cat_id,
        'brand_id' => $brand,
        'item_name' => $itemName,
        'item_des' => $itemDes,
        'has_sub' => 'no',
        'sub_item_of' => $subItemOf,
        'reorder_point' => $reorderPoint,
        'item_unit' => $itemUnit,
        'item_cost'=> $itemCost,
        'item_price'=> $itemPrice,
        'item_quantity'=> $itemQuantity
    );

    db('items',$data);

}
if(isset($_POST['saveItemsEdits'])){


    $stmt = $conn ->prepare("UPDATE items set item_name = ?, sub_item_of = ?, item_des = ?, has_sub=?,reorder_point=?, item_unit=?, item_cost =?, item_price = ?, item_quantity =? where item_id = ?");
    $stmt -> bind_param("ssssssssss", $itemNameEdit, $subItemOfEdit, $itemDesEdit, $hasSubsEdit, $reorderPointEdit, $itemUnitEdit, $itemCostEdit, $itemPriceEdit,$itemQuantityEdit, $item_id);

    $itemNameEdit = $_POST['itemNameEdit'];
    $subItemOfEdit = $_POST['subItemOfEdit'];
    $itemDesEdit = $_POST['itemDesEdit'];
    $itemCostEdit = $_POST['itemCostEdit'];
    $itemPriceEdit = $_POST['itemPriceEdit'];
    $itemQuantityEdit = $_POST['itemQuantityEdit'];
    $itemUnitEdit = $_POST['itemUnitEdit'];
    $reorderPointEdit = $_POST['reorderPointEdit'];
    $item_id = $_POST['itemIdToEdit'];
    $hasSubsEdit = $_POST['hasSubsEdit'];

    if($stmt -> execute()){
        echo 1;
    }else{
        echo $stmt -> error;
    }




}

if(isset($_POST['deleteCatItem'])){
    $item_id = mysqli_escape_string($conn, $_POST['item_id']);

    $sql = "UPDATE items set delete_status = 'yes' where item_id = '$item_id' or sub_item_of = '$item_id'";

    $query = mysqli_query($conn, $sql);

    if(!$query){
        echo mysqli_error($conn);
    }else{
        echo 1;
    }
}

if(isset($_POST['saveBrandEdit'])){

    $stmt = $conn -> prepare("UPDATE brands set brand_name = ?, re_order =? where brand_id =?");
    $stmt -> bind_param("sss", $brand_name, $re_order, $brand_id);

    $brand_name = $_POST['brand_name'];
    $brand_id = $_POST['brand_id'];
    $re_order = $_POST['re_order'];

    if($stmt-> execute()){
        echo 1;
    }else{
        echo $stmt -> error;
    }
    
    
}

if(isset($_POST['smsAllCusts'])){
    $message = mysqli_escape_string($conn, $_POST['message']);
    $office_id = $_SESSION['welix_loged_in']['office_id'];

    $sql = "SELECT * FROM customers where office_id ='$office_id' and delete_status = 'no'";

    $query = mysqli_query($conn, $sql);

    if(!$query){
        echo mysqli_error($conn);
    }else{
        echo 1;
        if(mysqli_num_rows($query)>0){
            foreach($query as $cust){
                $name = $cust['cust_name'];
                $phone = $cust['cust_phone'];
                $message = str_replace('_name_', $name, $message);


                // The send sms API Comes Here
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://messaging-service.co.tz/api/sms/v1/text/single',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => '{"from":"Nouri Cafe", "to":"'.$phone.'",  "text": "'.$message.'", "reference": "test"}',
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Basic S2hhZGlqYTpOb3VyaTJvMjJA',
                        'Content-Type: application/json',
                        'Accept: application/json'
                    ),
                ));
        
             $response = curl_exec($curl);
        
                curl_close($curl);
                

            }
        }
    }
}else{
mysqli_close($conn);

}