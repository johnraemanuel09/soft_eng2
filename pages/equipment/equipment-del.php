<?php
require '../../includes/conn.php';
session_start();

$eq_id = $_GET['eq_id'];

mysqli_query($db, "DELETE FROM tbl_equipment  WHERE eq_id = '$eq_id' ") or die(mysqli_error($db));
$_SESSION['successDel'] = true;
header("location: equipment-lists.php");