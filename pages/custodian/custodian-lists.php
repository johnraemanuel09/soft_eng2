<!--
=========================================================
* Material Dashboard 2 - v3.0.4
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard
* Copyright 2022 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<?php
include '../../includes/session.php';
// End Session
include '../../includes/head.php';
?>

<title>
  Custodian Lists
</title>

<body class="g-sidenav-show  bg-gray-200">

  <!-- sidebar -->
  <?php include "../../includes/sidebar.php"?>
  <!-- End sidebar -->

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <?php include "../../includes/navbar.php"?>
    <!-- End Navbar -->
    <div class="container-fluid py-4">

      <div class="row mt-4">
        <div class="col-12">
          <div class="card px-4 pb-4">

            <h5 class="mb-0 pt-4">Custodian List</h5>

       <style>
  /* Input focus turns black */
  .form-control:focus {
    border-color: black !important;
    box-shadow: 0 0 0 0.2rem rgba(0,0,0,0.25) !important;
  }

  /* Make button match input height */
  .btn-search {
    height: 100%;
    min-width: 100px;
    background-color: #ff0000ff; /* Bootstrap primary blue */
    border-color: #ff0000ff;
    transition: none; /* Disable hover animation */
  }

  /* Remove hover color change */
  .btn-search:hover,
  .btn-search:focus,
  .btn-search:active {
    background-color: #fb0000ff !important;
    border-color: #fe0015ff !important;
    box-shadow: none !important;
  }
</style>

<div class="d-flex justify-content-center align-items-center mt-3 mb-3">
  <form method="GET" action="" class="d-flex" style="max-width: 500px; width: 100%;">
    <input 
      type="text" 
      name="search" 
      class="form-control me-2" 
      placeholder="Search custodian..." 
      value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>"
    >
    <button type="submit" class="btn btn-primary btn-search">Search</button>
  </form>
</div>

            <div class="table-responsive">
              <table class="table table-flush" id="datatable-search">
                
                <thead class="thead-light">
                  <tr>
                    <th>Image</th>
                    <th>Fullname</th>
                    <th>Username</th>
                    <th>Action</th>
                  </tr>
                </thead>
             <tbody>
<?php
// Get search input safely
$listcustodian = []; // initialize empty array

if (isset($_GET['search'])) {
    $search = trim($_GET['search']); // remove extra spaces
    $search_safe = mysqli_real_escape_string($db, $search);

    // Base query
    $query = "SELECT *, CONCAT(tbl_custodian.firstname, ' ', tbl_custodian.lastname) AS fullname FROM tbl_custodian";

    // If user typed something, filter by it
    if (!empty($search_safe)) {
        $query .= " WHERE firstname LIKE '%$search_safe%' 
                    OR lastname LIKE '%$search_safe%' 
                    OR username LIKE '%$search_safe%' 
                    OR CONCAT(firstname, ' ', lastname) LIKE '%$search_safe%'";
    }

    $listcustodian = mysqli_query($db, $query);
}

// Display results only if search was clicked

if (!empty($listcustodian) && mysqli_num_rows($listcustodian) > 0) {
    while ($row = mysqli_fetch_array($listcustodian)) {
        $id = $row['custodian_id'];
?>
  <tr>
    <td>
      <?php if (empty($row['img'])) {
        echo '<img class="border-radius-lg shadow-sm zoom" style="height:80px; width:80px;" src="../../assets/img/image.png"/>';
      } else {
        echo '<img class="border-radius-lg shadow-sm zoom" style="height:80px; width:80px;" src="data:image/jpeg;base64,' . base64_encode($row['img']) . '"/>';
      } ?>
    </td>
    <td class="text-sm font-weight-normal"><?php echo $row['fullname']; ?></td>
    <td class="text-sm font-weight-normal"><?php echo $row['username']; ?></td>

    <?php if ($_SESSION['role'] == "Super Administrator" || $_SESSION['role'] == "Admin") { ?>
    <td class="text-sm font-weight-normal">
        <!-- Edit Button -->
        <a class="btn btn-link text-info text-gradient px-3 mb-1"
           href="custodian-edit.php?custodian_id=<?php echo $id; ?>">
           <i class="material-icons text-sm me-2">edit</i>Edit
        </a>
        <br>
        <!-- Delete Button -->
        <a class="btn btn-link text-danger text-gradient px-3 mb-0"
           href="javascript:;" 
           data-bs-toggle="modal" 
           data-bs-target="#deleteCustodian<?php echo $id; ?>">
           <i class="material-icons text-sm me-2">delete</i>Delete
        </a>
    </td>
<?php } ?>

  </tr>

  <!-- Delete Modal -->
  <div class="modal fade" id="deleteCustodian<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="py-3 text-center">
            <i class="fas fa-trash-alt text-9xl"></i>
            <h4 class="text-gradient text-danger mt-4">Delete Account!</h4>
            <p>Are you sure you want to delete
              <br><i><b><?php echo $row['firstname']; ?></b></i>?
            </p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
          <a href="custodian-del.php?custodian_id=<?php echo $id; ?>">
            <button type="button" class="btn bg-gradient-danger">Delete</button>
          </a>
        </div>
      </div>
    </div>
  </div>
<?php
    } // end while
} // end if search clicked
?>
</tbody>



              </table>
            </div>
          </div>
        </div>

      </div>
      <?php include "../../includes/footer.php"?>
  </main>
  <?php include "../../includes/fixed-plugin.php"?>
  <!--   Core JS Files   -->
  <?php include "../../includes/script.php"?>
</body>

</html>