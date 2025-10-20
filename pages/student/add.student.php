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
include '../../includes/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!'); window.history.back();</script>";
        exit;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert into DB
    $stmt = $db->prepare("INSERT INTO tbl_student (firstname, middlename, lastname, username, password)
                            VALUES (?, ?, ?, ?, ?)");
    
    if ($stmt === false) {
        die("Prepare failed: " . $db->error);
    }

    $stmt->bind_param("sssss", $firstname, $middlename, $lastname, $username, $hashed_password);

    if ($stmt->execute()) {
        $_SESSION['studentAdded'] = true;
echo "<script>window.location.href='add.student.php';</script>";
exit;

    } else {
        echo "Error executing statement: " . $stmt->error;
    }

    $stmt->close();
    $db->close();
}
?>



<body class="g-sidenav-show  bg-gray-200">

  <!-- sidebar -->
  <?php include "../../includes/sidebar.php" ?>
  <!-- End sidebar -->

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <?php include "../../includes/navbar.php" ?>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div id="add-student">
      </div>
      <div id="alum_notMatchPass">
      </div>

      <div class="row">
        <div class="containerr">
          <div class="card">
            <div class="form">
              <div class="left-side">
                <div class="left-heading">
                  <img class="img-left" src="../../assets/img/sfac.png">
                </div>
                <div class="steps-content">
                  <h3 class="step"><b>Step</b> <span class="step-number">1</span></h3>

                </div>
                <ul class="ul_progress">
                  <li class="active">Personal Information</li>
                  <li>Account</li>
                </ul>
              </div>
              <div class="right-side">
                <form method="POST" action="">
                  <div class="main active">
                    <img class="resize" src="../../assets/img/sfac.png">
                    <div class="text">
                      <h2>Add Student</h2>
                      <p>Enter your personal information to proceed.</p>
                    </div>
                    <div class="input-text">
                      <!-- <div class="input-div">
                        <input type="text" required require name="stud_no">
                        <span>Student Number</span>
                      </div> -->
                      <div class="input-div">
                        <input type="text" required require name="firstname">
                        <span>First Name</span>
                      </div>
                      <div class="input-div">
                        <input type="text" required name="middlename">
                        <span>Middle Name</span>
                      </div>
                      <div class="input-div">
                        <input type="text" required name="lastname">
                        <span>Last Name</span>
                      </div>
                    </div>
                    <div class="buttons">
                      <button class="next_button">Next Step</button>
                    </div>
                  </div>
                  <div class="main">
                    <img class="resize" src="../../assets/img/sfac.png">
                    <div class="text">
                      <h2>Account</h2>
                      <p></p>
                    </div>
                    <div class="input-text">
                      <div class="input-div">
                        <input type="text" required require name="username">
                        <span>Username</span>
                      </div>
                    </div>
                    <div class="input-group input-group-outline mb-3">
                      <label class="form-label" for="pwd"></label>
                      <input type="password" class="form-control" name="password" placeholder="Password">
                    </div>
                    <div class="input-group input-group-outline mb-3">
                      <label class="form-label" for="pwd"></label>
                      <input type="password" class="form-control" name="confirm_password"
                        placeholder="Confirm Password">
                    </div>

                    <div class="buttons button_space">
                      <button class="back_button">Back</button>
                      <button class="submit_button" type="submit">Submit</button>
                    </div>
                  </div>

                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
      <?php include "../../includes/footer.php" ?>
    </div>
  </main>
  <?php include "../../includes/fixed-plugin.php" ?>
  <!--   Core JS Files   -->
  <?php include "../../includes/script.php" ?>
</body>
<script>
<?php
  if (!empty($_SESSION['studentAdded'])) { ?>
Swal.fire("Student", "Added Successfully", "success");
<?php
  unset($_SESSION['studentAdded']);
  }?>
<?php
  if (!empty($_SESSION['notMatch'])) {
    ?>
Swal.fire("Error", "Password does not Match ", "error")
<?php
  unset($_SESSION['notMatch']);
  } ?>
</script>

</html>