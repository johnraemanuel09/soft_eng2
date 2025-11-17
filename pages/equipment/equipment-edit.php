<?php
include '../../includes/session.php';
include '../../includes/head.php';

if (!isset($_GET['eq_id'])) {
    header("Location: equipment-lists.php");
    exit;
}

$eq_id = intval($_GET['eq_id']);
$msg = '';

// Handle form submission
if (isset($_POST['update_equipment'])) {
    $eq_name = mysqli_real_escape_string($db, $_POST['eq_name']);
    $serial_number = mysqli_real_escape_string($db, $_POST['serial_number']);
    $date_of_order = mysqli_real_escape_string($db, $_POST['date_of_order']);

    // Image upload
    if (isset($_FILES['img']) && $_FILES['img']['size'] > 0) {
        $imgData = addslashes(file_get_contents($_FILES['img']['tmp_name']));
        $sql = "
            UPDATE tbl_equipment 
            SET 
                `Equipment Name`='$eq_name', 
                `Serial_Number`='$serial_number', 
                `Date_of_Order`='$date_of_order',
                img='$imgData'
            WHERE eq_id=$eq_id
        ";
    } else {
        $sql = "
            UPDATE tbl_equipment 
            SET 
                `Equipment Name`='$eq_name', 
                `Serial_Number`='$serial_number', 
                `Date_of_Order`='$date_of_order',
                img='$imgData'
            WHERE eq_id=$eq_id
        ";
    }

    if (mysqli_query($db, $sql)) {
        $msg = "Equipment updated successfully!";
    } else {
        $msg = "Error updating equipment: " . mysqli_error($db);
    }
}

// Fetch equipment info
$query = "SELECT * FROM tbl_equipment WHERE eq_id = $eq_id";
$result = mysqli_query($db, $query);
$equipment = mysqli_fetch_assoc($result);
?>

<title>Edit Equipment</title>
<body class="g-sidenav-show bg-gray-200">

<?php include "../../includes/sidebar.php"?>
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
<?php include "../../includes/navbar.php"?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card px-4 pb-4">
                <h5 class="pt-4">Edit Equipment</h5>

                <?php if($msg != ''): ?>
                    <div class="alert alert-success"><?php echo $msg; ?></div>
                <?php endif; ?>

                <form method="POST" enctype="multipart/form-data">

                    <div class="mb-3">
                        <label>Equipment ID</label>
                        <input type="text" class="form-control" value="<?php echo $equipment['eq_id']; ?>" disabled>
                    </div>

                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="eq_name" class="form-control" 
                               value="<?php echo $equipment['Equipment Name']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label>Serial Number</label>
                        <input type="text" name="serial_number" class="form-control" 
                               value="<?php echo $equipment['Serial Number']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label>Date of Order</label>
                        <input type="date" name="date_of_order" class="form-control" 
                               value="<?php echo $equipment['Date of Order']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label>Upload New Image (optional)</label>
                        <input type="file" name="img" class="form-control">
                    </div>

                    <button type="submit" name="update_equipment" class="btn bg-gradient-info">
                        Update Equipment
                    </button>

                    <a href="equipment-lists.php" class="btn bg-gradient-secondary">
                        Back to List
                    </a>

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
