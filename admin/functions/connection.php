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

// Initialize MySQLi
$conn = mysqli_init();
if (!$conn) {
    die('MySQLi initialization failed');
}

// Set up SSL for the connection
if (!mysqli_ssl_set($conn, NULL, NULL, "../assets/Microsoft RSA Root Certificate Authority 2017.crt", NULL, NULL)) {
    die('MySQLi SSL setup failed: ' . mysqli_error($conn));
}

// Attempt to connect to the database
if (!mysqli_real_connect($conn, "william.mysql.database.azure.com", "williamUser", "Writer@becket#360", "invento_db", 3306, NULL, MYSQLI_CLIENT_SSL)) {
    die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
}

// Connection successful
echo 'Success... ' . mysqli_get_host_info($conn) . "\n";

// You can now use $conn for your queries

// Close the connection when done
mysqli_close($conn);
?>

