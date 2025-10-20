<?php
require '../../includes/conn.php';
session_start();

$student_id = $_GET['student_id'];

mysqli_query($db, "DELETE FROM tbl_student  WHERE student_id = '$student_id' ") or die(mysqli_error($db));
$_SESSION['successDel'] = true;
header("location: student-lists.php");