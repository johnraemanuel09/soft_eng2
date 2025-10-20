<?php
require '../../includes/conn.php';
session_start();

$teacher_id = $_GET['teacher_id'];

mysqli_query($db, "DELETE FROM tbl_teacher  WHERE teacher_id = '$teacher_id' ") or die(mysqli_error($db));
$_SESSION['successDel'] = true;
header("location: teacher-lists.php");