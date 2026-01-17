<?php
include '../../includes/session.php';
include '../../includes/connection.php';

if (isset($_POST['teacher_id'])) {

    $id = mysqli_real_escape_string($db, $_POST['teacher_id']);
    $firstname = mysqli_real_escape_string($db, $_POST['firstname']);
    $lastname  = mysqli_real_escape_string($db, $_POST['lastname']);
    $username  = mysqli_real_escape_string($db, $_POST['username']);

    $update = mysqli_query($db, "
        UPDATE tbl_teacher 
        SET firstname='$firstname', lastname='$lastname', username='$username' 
        WHERE teacher_id='$id'
    ");

    if ($update) {
        echo 'success';
    } else {
        echo 'error: ' . mysqli_error($db);
    }
} else {
    echo 'no data';
}
?>
