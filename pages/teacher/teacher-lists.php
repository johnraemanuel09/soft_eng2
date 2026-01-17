<?php
include '../../includes/session.php';
include '../../includes/head.php';
?>

<!DOCTYPE html>
<html lang="en">
<title>Teacher Lists</title>

<body class="g-sidenav-show bg-gray-200">

<!-- sidebar -->
<?php include "../../includes/sidebar.php"?>
<!-- End sidebar -->

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
  <!-- Navbar -->
  <?php include "../../includes/navbar.php"?>
  <!-- End Navbar -->

  <div class="container-fluid py-4">

    <!-- Success/Error Alerts from session -->
    <?php
    if (isset($_SESSION['success'])) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">'
            . $_SESSION['success'] .
            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        unset($_SESSION['success']);
    }

    if (isset($_SESSION['error'])) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'
            . $_SESSION['error'] .
            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        unset($_SESSION['error']);
    }
    ?>

    <!-- AJAX message container -->
    <div id="ajaxMessage" style="position: fixed; top: 20px; right: 20px; z-index: 9999;"></div>

    <div class="row mt-4">
      <div class="col-12">
        <div class="card px-4 pb-4">

          <h5 class="mb-0 pt-4">Teachers</h5>

          <!-- Search bar with clickable magnifying glass -->
          <div class="row mb-3">
              <div class="col-12 d-flex justify-content-center">
                  <div class="input-group w-50 w-md-75 w-sm-100">
                      <input type="text" id="teacherSearch" class="form-control" placeholder="Search teachers...">
                      <button class="btn btn-outline-secondary" type="button" id="searchBtn">
                          <i class="material-icons">search</i>
                      </button>
                  </div>
              </div>
          </div>

          <!-- Table initially hidden -->
          <div class="table-responsive" id="teacherTableContainer" style="display:none;">
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
                $listteacher = mysqli_query($db, "SELECT *, CONCAT(tbl_teacher.firstname, ' ', tbl_teacher.lastname) AS fullname FROM tbl_teacher");
                while ($row = mysqli_fetch_array($listteacher)) {
                    $id = $row['teacher_id'];
                ?>
                <tr>
                  <td>
                    <?php
                    if (empty($row['img'])) {
                        echo '<img class="border-radius-lg shadow-sm zoom" style="height:80px; width:80px;" src="../../assets/img/image.png"/>';
                    } else {
                        echo '<img class="border-radius-lg shadow-sm zoom" style="height:80px; width:80px;" src="data:image/jpeg;base64,' . base64_encode($row['img']) . '" />';
                    }
                    ?>
                  </td>
                  <td class="text-sm font-weight-normal"><?php echo $row['fullname']; ?></td>
                  <td class="text-sm font-weight-normal"><?php echo $row['username']; ?></td>

                  <?php if ($_SESSION['role'] == "Super Administrator" || $_SESSION['role'] == "Admin") { ?>
                  <td class="text-sm font-weight-normal">
                    <!-- Edit Button -->
                    <a class="btn btn-link text-info text-gradient px-3 mb-0" href="javascript:;" data-bs-toggle="modal" data-bs-target="#editTeacher<?php echo $id; ?>">
                      <i class="material-icons text-sm me-2">edit</i>Edit
                    </a>
                    <!-- Delete Button -->
                    <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;" data-bs-toggle="modal" data-bs-target="#deleteTeacher<?php echo $id; ?>">
                      <i class="material-icons text-sm me-2">delete</i>Delete
                    </a>
                  </td>
                  <?php } ?>
                </tr>

                <!-- Delete Modal -->
                <div class="modal fade" id="deleteTeacher<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                          <p>Are you sure you want to delete <br><i><b><?php echo $row['firstname']; ?></b></i>?</p>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                        <a href="teacher-del.php?teacher_id=<?php echo $id; ?>"><button type="button" class="btn bg-gradient-danger">Delete</button></a>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Edit Modal -->
                <div class="modal fade" id="editTeacher<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="editTeacherLabel<?php echo $id; ?>" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="editTeacherLabel<?php echo $id; ?>">Edit Teacher</h5>
                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <form id="editTeacherForm<?php echo $id; ?>" method="POST">
                        <div class="modal-body">
                          <input type="hidden" name="teacher_id" value="<?php echo $id; ?>">
                          <div class="mb-3">
                            <label for="firstname<?php echo $id; ?>" class="form-label">First Name</label>
                            <input type="text" class="form-control" name="firstname" id="firstname<?php echo $id; ?>" value="<?php echo $row['firstname']; ?>" required>
                          </div>
                          <div class="mb-3">
                            <label for="lastname<?php echo $id; ?>" class="form-label">Last Name</label>
                            <input type="text" class="form-control" name="lastname" id="lastname<?php echo $id; ?>" value="<?php echo $row['lastname']; ?>" required>
                          </div>
                          <div class="mb-3">
                            <label for="username<?php echo $id; ?>" class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" id="username<?php echo $id; ?>" value="<?php echo $row['username']; ?>" required>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                          <button type="submit" class="btn bg-gradient-info">Save Changes</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                <?php } // end while ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <?php include "../../includes/footer.php"?>
</main>

<?php include "../../includes/fixed-plugin.php"?>
<?php include "../../includes/script.php"?>

<!-- jQuery for AJAX & Live Search -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {

    // Initially hide table
    $('#teacherTableContainer').hide();

    // Press Enter in search bar
    $('#teacherSearch').on('keypress', function(e) {
        if(e.which == 13){ // Enter key
            $('#teacherTableContainer').show();
        }
    });

    // Click magnifying glass button
    $('#searchBtn').on('click', function() {
        $('#teacherTableContainer').show();
    });

    // Live search
    $('#teacherSearch').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('#datatable-search tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    // AJAX edit forms
    <?php mysqli_data_seek($listteacher, 0); ?>
    <?php while ($row = mysqli_fetch_array($listteacher)) { $id = $row['teacher_id']; ?>
    $('#editTeacherForm<?php echo $id; ?>').submit(function(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'teacher-edit.php',
            data: $(this).serialize(),
            success: function(response){
                $('#editTeacher<?php echo $id; ?>').modal('hide');

                // Inline dashboard message
                $('#ajaxMessage').html(
                    '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                    'Teacher updated successfully!' +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                    '</div>'
                );

                setTimeout(function(){
                    $('.alert').alert('close');
                    location.reload();
                }, 2000);
            },
            error: function(){
                $('#ajaxMessage').html(
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                    'Error updating teacher!' +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                    '</div>'
                );
            }
        });
    });
    <?php } ?>

});
</script>

<!-- CSS for search bar -->
<style>
#teacherSearch {
    border-radius: 8px 0 0 8px;
    background-color: #ffe5e5; /* light red background */
    height: 45px;
    font-size: 1rem;
}

#searchBtn {
    border-radius: 0 8px 8px 0;
}
</style>

</body>
</html>
