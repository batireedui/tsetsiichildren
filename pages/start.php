<?php
if (!isset($_SESSION['user_id'])) {
  redirect("ch");
} else {
  $user_role = $_SESSION['user_role'];
  $school_id = $_SESSION['school_id'];
  $user_id = $_SESSION['user_id'];
  $h_jil = $_SESSION['jil'];
}
$sumd = array();
$school_list = array();
_selectNoParam(
  $sstmt,
  $scount,
  "SELECT id, name FROM sumd",
  $sum_id,
  $sum_name
);
while (_fetch($sstmt)) {
  array_push($sumd, $sum_name);
}
$at = "";
$sql = "";
if ($user_role == "najiltan") {
  $sql = " INNER JOIN najiltans ON schools.id = najiltans.school_id WHERE najiltans.id = $user_id";
  $at = "Нийгмийн ажилтан";
} elseif ($user_role == "teacher") {
  $sql = " INNER JOIN teachers ON schools.id = teachers.school_id WHERE teachers.id = $user_id";
  $at = "Багш";
}
_selectNoParam(
  $sstmt,
  $scount,
  "SELECT schools.id, schools.school_name, schools.sum FROM `schools`" . $sql,
  $s_id,
  $s_name,
  $s_sum
);
while (_fetch($sstmt)) {
  array_push($school_list, [$s_id, $s_name, $s_sum]);
}
?>
<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="/assets/" data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title><?= $pageTitle ?> </title>
  <link rel="icon" type="image/x-icon" href="<?= $favi ?>" />
  <meta name="description" content='Цогтцэций сум Боловсрол, шинжлэх ухааны газар, Нэгдсэн судалгаа' />

  <!-- Favicon -->

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

  <!-- Icons. Uncomment required icon fonts -->
  <link rel="stylesheet" href="/assets/vendor/fonts/boxicons.css" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="/assets/vendor/css/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="/assets/css/demo.css" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

  <link rel="stylesheet" href="/assets/vendor/libs/apex-charts/apex-charts.css" />

  <!-- Page CSS -->

  <!-- Helpers -->
  <script src="/assets/vendor/js/helpers.js"></script>

  <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
  <script src="/assets/js/config.js"></script>
  <style>
    .upper {
      text-transform: uppercase;
    }
  </style>