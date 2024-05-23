<?php
session_start();
// Ensure that the request method is POST
function insertInvoice($invoice_no, $cust_phone, $total_price, $discount, $amout_due, $amount_paid, $payment_status)
{
    include("connection.php");
    $stmt = $conn->prepare("INSERT INTO invoices (office_id, invoice_no, user_id,cust_phone, total_price, discount, amount_due, amount_paid,payment_status,outstanding) VALUES (?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("ssssssssss", $office_id, $invoice_no, $user_id, $cust_phone, $total_price, $discount, $amout_due, $amount_paid,$payment_status, $outstanding);

    $office_id = $_SESSION['welix_loged_in']['office_id'];
    $user_id = $_SESSION['welix_loged_in']['user_id'];
    if($payment_status == 'not_full_paid'){
        $outstanding = "true";
    }else{
        $outstanding = "flase";
    }
    // Execute the statement
    if ($stmt->execute()) {
        // echo 1;
    } else {
        echo "Error inserting data on invoices: " . $stmt->error;
    }

    // Close the statement and the connection
    $stmt->close();
    $conn->close();
}

function insertPayment($invoice_no, $paid_amount, $pay_method)
{
    include("connection.php");
    $stmt = $conn->prepare("INSERT INTO payments (invoice_no,office_id, paid_amount, pay_method) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss", $invoice_no,$office_id, $paid_amount, $pay_method );

    $office_id = $_SESSION['welix_loged_in']['office_id'];
    // Execute the statement
    if ($stmt->execute()) {
        // echo 1;
    } else {
        echo "Error inserting data on payments: " . $stmt->error;
    }

    // Close the statement and the connection
    $stmt->close();
    $conn->close();
}
function updateItems($item_id, $item_count)
{
    include("connection.php");
    $stmt = $conn->prepare("UPDATE items set item_quantity = item_quantity - ? WHERE item_id = ?");
    $stmt->bind_param("ss", $item_count, $item_id );

    // Execute the statement
    if ($stmt->execute()) {
        // echo 1;
    } else {
        echo "Error inserting data on items: " . $stmt->error;
    }

    // Close the statement and the connection
    $stmt->close();
    $conn->close();
}
function insertSoldItems($invoice_no, $item_id, $item_count, $item_cost)
{
    include("connection.php");

    $sql = "SELECT item_price FROM items WHERE item_id = '$item_id'";

    $query = mysqli_query($conn, $sql);

    if(!$query){
        echo mysqli_error($conn);
    }else{
        if(mysqli_num_rows($query)>0){
            $result = mysqli_fetch_assoc($query);

            $total_price = $result['item_price'];
        }else{
            return;
        }
    }

    $stmt = $conn->prepare("INSERT INTO sold_tems (invoice_no, item_id, item_cost,item_price,item_count, total_cost) VALUES (?,?,?,?,?,?)");
    $stmt->bind_param("ssssss", $invoice_no, $item_id, $item_cost,$total_price,$item_count,$total_cost);

    $total_cost = (int)$item_count * (int)$total_price;
    // Execute the statement
    if ($stmt->execute()) {
        // echo 1;
    } else {
        echo "Error inserting data on sold_tems: " . $stmt->error;
    }

    // Close the statement and the connection
    $stmt->close();
    $conn->close();
}
function insertCustomer($cust_phone,$cust_name){
    include("connection.php");
    
    $stmt = $conn->prepare("INSERT IGNORE INTO customers (cust_phone, office_id, cust_name) VALUES (?,?,?)");
    $stmt->bind_param("sss", $cust_phone, $office_id, $cust_name );

    $office_id = $_SESSION['welix_loged_in']['office_id'];
    // Execute the statement
    if ($stmt->execute()) {
        // echo 1;
    } else {
        echo "Error inserting data on payments: " . $stmt->error;
    }

    // Close the statement and the connection
    $stmt->close();
    $conn->close();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw POST data
    $rawData = file_get_contents('php://input');

    // Decode the JSON data into a PHP array
    $jsonData = json_decode($rawData, true);

    if ($jsonData !== null) {

        // fetch product price
        

        // procesing the recieved data
        foreach ($jsonData as $data) {
            if ($data['target'] == 'invoice') {
                insertInvoice($data['invoice_no'], $data['cust_phone'], $data['total_price'], $data['discount'], $data['amout_due'], $data['amount_paid'], $data['payment_status']);
            } elseif ($data['target'] == 'payment') {
                insertPayment($data['invoice_no'], $data['paid_amount'], $data['pay_method']);
            } elseif ($data['target'] == 'items') {
                updateItems($data['item_id'], $data['item_count']);
            } elseif ($data['target'] == 'sold_items') {
                insertSoldItems($data['invoice_no'], $data['item_id'], $data['item_count'], $data['item_cost']);
            }elseif ($data['target'] == 'customers') {
                insertCustomer($data['cust_phone'], $data['cust_name']);
            }


        }
        echo 1;
    } else {
        // Return an error response if the JSON data could not be decoded
        http_response_code(400); // Bad Request
        $response = array('status' => 'error', 'message' => 'Invalid JSON data received.');
        echo json_encode($response);
    }
} else {
    // Return an error response if the request method is not POST
    http_response_code(405); // Method Not Allowed
    $response = array('status' => 'error', 'message' => 'Only POST requests are allowed.');
    echo json_encode($response);
}
