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
  <div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
      <div class="row">
        <div class="col-lg-12 mb-4 order-0">
          <div class="card">
            <div class="d-flex align-items-end row">
              <div class="col-sm-7">
                <div class="card-body">
                  <h5 class="card-title text-primary upper">Сайн байн уу! <?= $_SESSION['user_name'] ?>🎉</h5>
                  <?php
                  $sql_school_name = "";
                  $sql_detial = "";
                  $sql_student_too = "SELECT COUNT(id) FROM students WHERE tuluv=0";
                  $sql_basgh_too = "SELECT COUNT(id) FROM teachers WHERE tuluv=0";

                  if ($user_role == "admin") {
                    _selectRowNoParam(
                      "SELECT COUNT(id) FROM najiltans WHERE tuluv=0",
                      $najiltans_too
                    );
                    _selectRowNoParam(
                      "SELECT COUNT(id) FROM schools WHERE tuluv=0",
                      $school_too
                    );
                  }
                  if ($user_role != "admin") {
                    $sql_school_name = "SELECT school_name FROM schools WHERE id = '$school_id'";

                    _selectRowNoParam(
                      $sql_school_name,
                      $school_name
                    );
                  }

                  if ($user_role == "teacher") {
                    $sql_detial = "SELECT concat(angi, buleg) FROM angis WHERE tuluv = 0 and teacher_id = '$user_id' and school_id = '$school_id'";

                    _selectNoParam(
                      $st,
                      $co,
                      $sql_detial,
                      $angi_name
                    );

                    $sql_student_too = "SELECT COUNT(students.id) FROM students INNER JOIN angis ON students.angi_id = angis.id WHERE students.tuluv=0 and angis.teacher_id='$user_id'";
                  } elseif ($user_role == "najiltan") {
                    $sql_student_too = "SELECT COUNT(students.id) FROM students WHERE students.tuluv=0 and students.school_id='$school_id'";
                    $sql_basgh_too = "SELECT COUNT(id) FROM teachers WHERE tuluv=0 and school_id='$school_id'";
                  }

                  if ($user_role != "teacher") {
                    _selectRowNoParam(
                      $sql_basgh_too,
                      $basgh_too
                    );
                  }
                  _selectRowNoParam(
                    $sql_student_too,
                    $student_too
                  );

                  ?>
                  <p class="mb-4">
                    <strong>Хичээлийн жил: <?= $h_jil ?></strong><br>
                    <?php
                    if (isset($school_name)) {
                      echo "Сургууль: " .  $school_name . "<br>";
                    } else {
                      echo "Хэрэглэгчийн төрөл:  <br>";
                    }
                    if (isset($co) > 0) {
                      while (_fetch($st))
                        echo "Даасан анги: " .  $angi_name . "<br>";
                    }
                    ?>
                  </p>

                  <a href="/account" class="btn btn-sm btn-outline-primary">Хувийн мэдээлэл</a>
                </div>
              </div>
              <div class="col-sm-5 text-center text-sm-left">
                <div class="card-body pb-0 px-0 px-md-4">
                  <img src="/assets/img/illustrations/man-with-laptop-light.png" height="140" alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png" data-app-light-img="illustrations/man-with-laptop-light.png" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row row g-4 mb-4">
        <!-- Order Statistics -->
        <?php if ($user_role == "admin") :
        ?>
          <div class="col-sm-6 col-xl-3">
            <div class="card">
              <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                  <div class="content-left">
                    <span>Нийт</span>
                    <div class="d-flex align-items-end mt-2">
                      <h1 class="mb-0 me-2"><?= $school_too ?></h1>
                    </div>
                    <small>сургуулийн бүртгэл</small>
                  </div>
                  <span class="badge bg-label-danger rounded p-2">
                    <i class="bx bxs-school bx-lg"></i>
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-xl-3">
            <div class="card">
              <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                  <div class="content-left">
                    <span>Нийт</span>
                    <div class="d-flex align-items-end mt-2">
                      <h1 class="mb-0 me-2"><?= $student_too ?></h1>
                    </div>
                    <small>сурагчийн бүртгэл</small>
                  </div>
                  <span class="badge bg-label-primary rounded p-2">
                    <i class="bx bxs-graduation bx-lg"></i>
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-xl-3">
            <div class="card">
              <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                  <div class="content-left">
                    <span>Нийт</span>
                    <div class="d-flex align-items-end mt-2">
                      <h1 class="mb-0 me-2"><?= $basgh_too ?></h1>
                    </div>
                    <small>Багшийн бүртгэл</small>
                  </div>
                  <span class="badge bg-label-warning rounded p-2">
                    <i class="bx bxs-group bx-lg"></i>
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-xl-3">
            <div class="card">
              <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                  <div class="content-left">
                    <span>Нийт</span>
                    <div class="d-flex align-items-end mt-2">
                      <h1 class="mb-0 me-2"><?= $najiltans_too ?></h1>
                    </div>
                    <small>Нийгмийн ажилтан</small>
                  </div>
                  <span class="badge bg-label-success rounded p-2">
                    <i class="bx bxs-user-voice bx-lg"></i>
                  </span>
                </div>
              </div>
            </div>
          </div>
        <?php endif ?>
        <?php if ($user_role == "najiltan") :
        ?>
          <div class="col-sm-6 col-xl-6">
            <div class="card">
              <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                  <div class="content-left">
                    <span>Нийт</span>
                    <div class="d-flex align-items-end mt-2">
                      <h1 class="mb-0 me-2"><?= $student_too ?></h1>
                    </div>
                    <small>сурагчийн бүртгэл</small>
                  </div>
                  <span class="badge bg-label-primary rounded p-2">
                    <i class="bx bxs-graduation bx-lg"></i>
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-xl-6">
            <div class="card">
              <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                  <div class="content-left">
                    <span>Нийт</span>
                    <div class="d-flex align-items-end mt-2">
                      <h1 class="mb-0 me-2"><?= $basgh_too ?></h1>
                    </div>
                    <small>Багшийн бүртгэл</small>
                  </div>
                  <span class="badge bg-label-warning rounded p-2">
                    <i class="bx bxs-group bx-lg"></i>
                  </span>
                </div>
              </div>
            </div>
          </div>
        <?php endif ?>
      </div>
      <!--/ Order Statistics -->

      <div class="row">
        <div class="col-md-6 col-lg-6 col-xl-6 order-0 mb-4">
          <div class="card">
            <div class="card-body">
              <div id="chart1"></div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-6 col-xl-6 order-0 mb-4">
          <div class="card">
            <div class="card-body">
              <div id="chart2">
              </div>
            </div>
          </div>
        </div>
        <?php if ($user_role != "teacher") {?>
        <div class="col-md-12 col-lg-12 col-xl-12">
          <div class="card">
            <div class="card-body">
              <div id="chart3">
              </div>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
      <!-- / Content -->
      <?php if ($user_role == "admin") {

        _selectRowNoParam(
          "SELECT COUNT(id) FROM students WHERE tuluv=0 and gender = 'Эрэгтэй'",
          $men_too
        );
        _selectRowNoParam(
          "SELECT COUNT(students.id) FROM students INNER JOIN angis ON students.angi_id = angis.id WHERE students.tuluv=0 and angis.angi < 6",
          $baga_angi
        );
        _selectRowNoParam(
          "SELECT COUNT(students.id) FROM students INNER JOIN angis ON students.angi_id = angis.id WHERE students.tuluv=0 and angis.angi > 5",
          $ahlah
        );
        _selectRowNoParam(
          "SELECT COUNT(DISTINCT sudalgaas.student_id) FROM `sudalgaas` INNER JOIN students ON sudalgaas.student_id = students.id WHERE jil = '$h_jil' and students.tuluv=0",
          $sudalgaa_ok
        );
      }
      
      elseif ($user_role == "teacher") {
        _selectRowNoParam(
          "SELECT COUNT(students.id) FROM students INNER JOIN angis ON students.angi_id = angis.id WHERE students.tuluv=0 and gender = 'Эрэгтэй' and angis.teacher_id='$user_id'",
          $men_too
        );
        _selectRowNoParam(
          "SELECT COUNT(DISTINCT sudalgaas.student_id) FROM `sudalgaas` INNER JOIN students ON sudalgaas.student_id = students.id INNER JOIN angis ON students.angi_id = angis.id WHERE jil = '$h_jil' and students.tuluv=0 and angis.teacher_id='$user_id'",
          $sudalgaa_ok
        );
        $baga_angi = 0;
      }
      
      elseif ($user_role == "najiltan") {
        _selectRowNoParam(
          "SELECT COUNT(students.id) FROM students WHERE students.tuluv=0 and gender = 'Эрэгтэй' and students.school_id='$school_id'",
          $men_too
        );
        _selectRowNoParam(
          "SELECT COUNT(DISTINCT sudalgaas.student_id) FROM `sudalgaas` INNER JOIN students ON sudalgaas.student_id = students.id WHERE jil = '$h_jil' and students.tuluv=0 and students.school_id='$school_id'",
          $sudalgaa_ok
        );

        _selectRowNoParam(
          "SELECT COUNT(students.id) FROM students INNER JOIN angis ON students.angi_id = angis.id WHERE students.tuluv=0 and angis.angi < 6 and students.school_id='$school_id'",
          $baga_angi
        );
        _selectRowNoParam(
          "SELECT COUNT(students.id) FROM students INNER JOIN angis ON students.angi_id = angis.id WHERE students.tuluv=0 and angis.angi > 5 and students.school_id='$school_id'",
          $ahlah
        );
      }
      ?>
      <!-- Footer -->
      <?php require "footer.php"; ?>
      <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
      <script>
        if ("<?= $user_role ?>" == "admin" || "<?= $user_role ?>" == "najiltan") {

          BagaDund();
        }
        chartLoad();

        function chartLoad() {
          var options = {
            series: [<?= $sudalgaa_ok ?>, <?= $student_too - $sudalgaa_ok ?>],
            labels: ['Судалгаанд хамрагдсан', 'Судалгаанд хамрагдаагүй'],
            chart: {
              type: 'donut',
            },
            responsive: [{
              breakpoint: 480,
              options: {
                chart: {
                  width: 200
                },
                legend: {
                  position: 'bottom'
                }
              }
            }],
            title: {
              text: "Сурагчид",
              align: 'center',
              style: {
                fontSize: '14px',
                fontWeight: 'bold',
                color: '#263238'
              },
            }
          };

          var options1 = {
            series: [<?= $men_too ?>, <?= $student_too - $men_too ?>, <?= $student_too ?>],
            labels: ['Эрэгтэй-<?= $men_too ?>', 'Эмэгтэй-<?= $student_too - $men_too ?>', 'Нийт-<?= $student_too ?>'],
            chart: {
              type: 'polarArea',
            },
            stroke: {
              colors: ['#fff']
            },
            fill: {
              opacity: 0.8
            },
            responsive: [{
              breakpoint: 480,
              options: {
                chart: {
                  width: 200
                },
                legend: {
                  position: 'bottom'
                }
              }
            }],
            title: {
              text: "Сурагчдын хүйсийн харьцаа",
              align: 'center',
              style: {
                fontSize: '14px',
                fontWeight: 'bold',
                color: '#263238'
              },
            }
          };

          var chart2 = new ApexCharts(document.querySelector("#chart2"), options);
          chart2.render();

          var chart1 = new ApexCharts(document.querySelector("#chart1"), options1);
          chart1.render();
        }

        function BagaDund() {
          var options3 = {
            series: [{
              name: 'Бага ангиийн сурагч',
              data: [<?= $baga_angi ?>]
            }, {
              name: 'Ахлах дунд ангийн сурагч',
              data: [<?= $student_too - $baga_angi ?>]
            }, ],
            chart: {
              type: 'bar',
              height: 350,
              stacked: true,
              stackType: '100%'
            },
            plotOptions: {
              bar: {
                horizontal: true,
              },
            },
            stroke: {
              width: 1,
              colors: ['#fff']
            },
            title: {
              text: 'Сурагчид'
            },
            xaxis: {
              categories: ["<?= $h_jil ?>"],
            },
            tooltip: {
              y: {
                formatter: function(val) {
                  return val
                }
              }
            },
            fill: {
              opacity: 1

            },
            legend: {
              position: 'top',
              horizontalAlign: 'left',
              offsetX: 40
            }
          };

          var chart3 = new ApexCharts(document.querySelector("#chart3"), options3);
          chart3.render();
        }
      </script>
      <?php require "end.php"; ?>