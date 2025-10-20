<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include DB connection
include '../../includes/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $db->prepare("INSERT INTO tbl_principal (firstname, middlename, lastname, username, password)
                            VALUES (?, ?, ?, ?, ?)");
    
    if ($stmt === false) {
        die("Prepare failed: " . $db->error);
    }

    $stmt->bind_param("sssss",  $firstname, $middlename, $lastname, $username, $password);

    if ($stmt->execute()) {
        echo "<script>alert('Alumni added successfully!'); window.location.href='add-alumni.php';</script>";
    } else {
        echo "Error executing statement: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
