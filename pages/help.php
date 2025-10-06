<?php require("start.php");
require("header.php");
?>
<!-- / Menu -->
<style>
  .ic {
    font-size: 48px;
  }
</style>
<!-- Layout container -->
<div class="layout-page">
  <!-- Navbar -->
  <?php require("navbar.php");
  ?>
  <!-- / Navbar -->

  <!-- Content wrapper -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card" style="padding: 20px;">
            <div class="row gy-3">
                <!-- Default Modal -->
                <div class="col-lg-6 col-sm-12">
                    <div class="col-sm-6:eq(0)"></div>
                    <h4 class="fw-bold py-3 mb-4">Тусламж</h4>
                </div>
            </div>
            <div class="accordion" id="accordionExample">
              <div class="card accordion-item active">
                <h2 class="accordion-header" id="headingOne">
                  <button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#accordionOne" aria-expanded="true" aria-controls="accordionOne" role="tabpanel">
                    Сурагчийн бүртгэл нэмэх, хасах
                  </button>
                </h2>
            
                <div id="accordionOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                   <iframe width="420" height="315" src="https://www.youtube.com/watch?v=Q5glE-jO1ts" frameborder="0" allowfullscreen></iframe>
                  </div>
                </div>
              </div>
            </div>

      <?php require "footer.php"; ?>
 
      <?php require "end.php"; ?>