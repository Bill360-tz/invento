<?php

function formatDate($dateTimeStr) {
    // Create a DateTime object from the input string
    $dateTime = new DateTime($dateTimeStr);

    // Format the DateTime object as 'd-m-Y'
    return $dateTime->format('d-m-Y');
}


function db($tableName, $data) {
    include("connection.php");
    // Prepare the SQL query
    $columns = implode(", ", array_keys($data));
    $placeholders = implode(", ", array_fill(0, count($data), "?"));
    $sql = "INSERT INTO $tableName ($columns) VALUES ($placeholders)";

    // Create a prepared statement
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo "Error: " . $conn->error;
        $conn->close();
        return;
    }

    // Bind parameters and execute the statement
    $types = str_repeat("s", count($data)); // Assuming all values are strings
    $stmt->bind_param($types, ...array_values($data));

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}

function office_id(){
    return $_SESSION['welix_loged_in']['office_id'];
}
function ensurePositive($number) {
    if ($number < 0) {
        return -$number; // Convert negative number to its positive counterpart
    }
    return $number; // Number is already positive or zero, so return it as is
}

function delete($table, $column, $condition){
    include("connection.php");

    $stmt = $conn -> prepare("DELETE FROM `$table` WHERE `$column` = ?");
    $stmt-> bind_param('s',$condition);

    if($stmt-> execute()){
        echo "success";
    }else{
        echo $stmt-> error;
    }
}


?>