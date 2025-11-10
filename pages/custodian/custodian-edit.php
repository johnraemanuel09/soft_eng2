<?php
include '../../includes/session.php';
include '../../includes/head.php';


if (!isset($_GET['custodian_id'])) {
    header("Location: custodian-lists.php");
    exit;
}

$custodian_id = intval($_GET['custodian_id']);
$msg = '';

// Handle form submission
if (isset($_POST['update_custodian'])) {
    $firstname = mysqli_real_escape_string($db, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($db, $_POST['lastname']);
    $username = mysqli_real_escape_string($db, $_POST['username']);

    // Handle image upload
    $imgData = null;
    if (isset($_FILES['img']) && $_FILES['img']['size'] > 0) {
        $imgData = addslashes(file_get_contents($_FILES['img']['tmp_name']));
        $sql = "UPDATE tbl_custodian
                SET firstname='$firstname', lastname='$lastname', username='$username', img='$imgData' 
                WHERE custodian_id=$custodian_id";
    } else {
        $sql = "UPDATE tbl_custodian 
                SET firstname='$firstname', lastname='$lastname', username='$username' 
                WHERE custodian_id=$custodian_id";
    }

    if (mysqli_query($db, $sql)) {
        $msg = "Custodian updated successfully!";
    } else {
        $msg = "Error updating custodian: " . mysqli_error($db);
    }
}

// Fetch custodian info
$query = "SELECT * FROM tbl_custodian WHERE custodian_id = $custodian_id";
$result = mysqli_query($db, $query);
$custodian = mysqli_fetch_assoc($result);
?>

<title>Edit Custodian</title>
<body class="g-sidenav-show bg-gray-200">

<?php include "../../includes/sidebar.php"?>
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
<?php include "../../includes/navbar.php"?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card px-4 pb-4">
                <h5 class="pt-4">Edit Custodian</h5>

                <?php if($msg != ''): ?>
                    <div class="alert alert-success"><?php echo $msg; ?></div>
                <?php endif; ?>

                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label>First Name</label>
                        <input type="text" name="firstname" class="form-control" value="<?php echo $custodian['firstname']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Last Name</label>
                        <input type="text" name="lastname" class="form-control" value="<?php echo $custodian['lastname']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" value="<?php echo $custodian['username']; ?>" required>
                    </div>
                
                    <button type="submit" name="update_custodian" class="btn bg-gradient-info">Update Custodian</button>
                    <a href="custodian-lists.php" class="btn bg-gradient-secondary">Back to List</a>
                </form>

            </div>
        </div>
    </div>
</div>

<?php include "../../includes/footer.php"?>
</main>
<?php include "../../includes/fixed-plugin.php"?>
<?php include "../../includes/script.php"?>
</body>
