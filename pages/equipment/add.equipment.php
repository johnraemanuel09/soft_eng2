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
<?php

include '../../includes/session.php';
include '../../includes/head.php';
include '../../includes/conn.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $serial_no = $_POST['serial_no'];
    $date_of_order_received = $_POST['date_of_order_received'];
    $type_id = $_POST['type_of_equipment']; // assuming the form sends this as type ID

    // ✅ Correct number of columns and values (4)
    $stmt = $db->prepare("INSERT INTO tbl_equipment 
        (Name, `Serial_No.`, Date_of_Order_Received, type_id)
        VALUES (?, ?, ?, ?)");

    if ($stmt === false) {
        die("Prepare failed: " . $db->error);
    }

    // ✅ Binding: string, int, date(string), int
    $stmt->bind_param("sisi", $name, $serial_no, $date_of_order_received, $type_id);

    if ($stmt->execute()) {
        $_SESSION['equipmentAdded'] = true;
        echo "<script>window.location.href='add.equipment.php';</script>";
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
      <div id="add-equipment">
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
                  <li class="active">Equipment Information</li>
                  <li>Location</li>
                </ul>
              </div>
              <div class="right-side">
                <form method="POST" action="">
                  <div class="main active">
                    <img class="resize" src="../../assets/img/sfac.png">
                    <div class="text">
                      <h2>Add Equipment</h2>
                      <p>Enter the information of equipment to proceed.</p>
                    </div>
                    <div class="input-text">
                      <!-- <div class="input-div">
                        <input type="text" required require name="stud_no">
                        <span>Student Number</span>
                      </div> -->
                      <div class="input-div">
                        <input type="text" required require name="name">
                        <span>Name</span>
                      </div>
                      <div class="input-div">
                        <input type="text" required name="serial_no">
                        <span>Serial No.</span>
                      </div>
                      <div class="input-div">
                        <input type="text" required name="date_of_order_received">
                        <span>Date of Received</span>
                      </div>
                    </div>
                    <div class="buttons">
                      <button class="next_button">Next Step</button>
                    </div>
                  </div>
                  <div class="main">
                    <img class="resize" src="../../assets/img/sfac.png">
                    <div class="text">
                      <h2>Information of Equipment</h2>
                      <p></p>
                    </div>
                    <div class="input-text">
                      <div class="input-div">
                        <input type="text" required require name="type_of_equipment">
                        <span>Type of Equipment</span>
                      </div>
                    </div>
                    <div class="input-text">
                      <div class="input-div">
                        <input type="text" required require name="location">
                        <span>Which laboratory is this located in?</span>
                      </div>
                    </div>
                    <div class="input-text">
                      <div class="input-div">
                        <input type="text" required require name="manufacturer">
                        <span>Manufacturer</span>
                      </div>
                    </div>
                    <div class="input-text">
                      <div class="input-div">
                        <input type="text" required require name="modelnumber">
                        <span>Model Number</span>
                      </div>
                    </div>
                    <div class="input-text">
                      <div class="input-div">
                        <input type="text" required require name="equipment_condition">
                        <span>Equipment Condition</span>
                      </div>
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
  if (!empty($_SESSION['equipmentAdded'])) { ?>
Swal.fire("Equipment", "Added Successfully ", "success");
<?php
  unset($_SESSION['equipmentAdded']);
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