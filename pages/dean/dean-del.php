<?php
require '../../includes/conn.php';
session_start();

$dean_id = $_GET['dean_id'];

mysqli_query($db, "DELETE FROM tbl_dean  WHERE dean_id = '$dean_id' ") or die(mysqli_error($db));
$_SESSION['successDel'] = true;
header("location: dean-lists.php");