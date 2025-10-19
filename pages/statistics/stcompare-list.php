<?php require ROOT . "/pages/start.php"; ?>
<link rel="stylesheet" type="text/css" href="/assets/css/dataTable.css">
<style>
    .dt-buttons {
        text-align: end;
        margin-bottom: 15px
    }
</style>
<?php

require ROOT . "/pages/header.php";
$sql = "";
$name = "";
$name1 = "";
$name = $_GET['name'];
$name1 = $_GET['name1'];
$id = $_GET['id'];
$id1 = $_GET['ids'];
$jil = $_GET['jil'];
$school_id = $_SESSION['school_id'];

$table = "sudalgaas";

if($jil != $h_jil){
    $table = $table . substr($jil, 0, 4);
}


if($user_role == "najiltan"){
    $sql = " and students.school_id = '$school_id' ";
}
else if($user_role == "teacher"){
    _selectNoParam(
        $st,
        $co,
        "SELECT id FROM angis WHERE teacher_id = '$user_id' and school_id = '$school_id'",
         $angi_id
    );
    
    if (isset($co) > 0) {
        $atoo = 1;
        while (_fetch($st)){
            if($atoo == 1) $sql = $sql . " and (";
            $sql = $sql . " students.angi_id = '$angi_id' ";
            if($atoo < $co){
                $sql = $sql . " or ";
            }
            if($atoo == $co){
                $sql = $sql . ")";
            }
            $a++;
        }
    }
}
_selectNoParam(
        $stmt,
        $count,
        "SELECT students.fname, students.lname, $table.angi, students.gender, schools.school_name, concat(angis.angi, angis.buleg) FROM `$table` 
        INNER JOIN students ON $table.student_id = students.id
         INNER JOIN schools ON students.school_id = schools.id 
         INNER JOIN angis on students.angi_id = angis.id 
         WHERE $table.shalguur_id='$id' AND $table.value=1 $sql AND student_id IN 
            (SELECT DISTINCT student_id FROM `$table` INNER JOIN students ON $table.student_id = students.id WHERE $table.shalguur_id='$id1' AND $table.value=1 $sql)",
        $fname,
        $lname,
        $angi,
        $gander,
        $school_name,
        $buleg
    );
$columnNumber = 7;
?>
<div class="layout-page">
    <!-- Navbar -->
    <?php require ROOT . "/pages/navbar.php";
    ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Bootstrap Table -->
        <div class="card" style="padding: 20px;">
            <div class="row gy-3">
                <!-- Default Modal -->
                <div class="col-lg-12 col-sm-12">
                    <h5>Шалгуур-1: <?= $name1 ?> (<?= $count ?>)</h5>
                </div>
                <div class="col-lg-12 col-sm-12">
                    <h5>Шалгуур-2: <?= $name ?> (<?= $count ?>)</h5>
                </div>
                <div class="col-lg-6 col-sm-12" style="text-align: end">
            </div>
            <div class="table-responsive text-nowrap">
                <table class="display" id="datalist">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Эцэг/эх-ийн нэр</th>
                            <th>Нэр</th>
                            <th>Хүйс</th>
                            <th>Анги</th>
                            <th>Бүлэг</th>
                            <th>Байгууллага</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php if ($count > 0) : ?>
                            <?php $too = 0;
                            while (_fetch($stmt)) : $too++ ?>
                                <tr>
                                    <td><?= $too ?></td>
                                    <td id="f1-<?= $id ?>"><?= $fname ?></td>
                                    <td id="f2-<?= $id ?>"><?= $lname ?></td>
                                    <td id="f3-<?= $id ?>"><?= $gander ?></td>
                                    <td id="f4-<?= $id ?>"><?= $angi ?></td>
                                    <td id="f4-<?= $id ?>"><?= $buleg ?></td>
                                    <td id="f5-<?= $id ?>"><?= $school_name ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php require ROOT . "/pages/footer.php"; ?>
        <?php require ROOT . "/pages/dataTablefooter.php"; ?>
        <script type="text/javascript">

        </script>
        <?php require ROOT . "/pages/end.php"; ?>