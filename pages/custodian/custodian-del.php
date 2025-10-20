<?php
require '../../includes/conn.php';
session_start();

$custodian_id = $_GET['custodian_id'];

mysqli_query($db, "DELETE FROM tbl_custodian  WHERE custodian_id = '$custodian_id' ") or die(mysqli_error($db));
$_SESSION['successDel'] = true;
header("location: custodian-lists.php");