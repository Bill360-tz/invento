<?php
// $servername = "localhost";
// $username = "root";
// $password = "";
// $database = "invento_db";
// // Create a connection
// $conn = new mysqli($servername, $username, $password, $database);

// // Check the connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

$con = mysqli_init();
mysqli_ssl_set($con,NULL,NULL, "{path to CA cert}", NULL, NULL);
mysqli_real_connect($conn, "william.mysql.database.azure.com", "williamUser", "{Writer@becket#360}", "{invento_db}", 3306, MYSQLI_CLIENT_SSL);

?>
