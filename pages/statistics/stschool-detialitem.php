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
$jil = $_SESSION['jil'];
$get_id = $_GET["id"];
if ($user_role == "najiltan") {
    $sql = " and students.school_id = $school_id";
} elseif ($user_role == "teacher") {
    $sql = " and students.school_id = $school_id and angis.teacher_id = $user_id";
}

_selectNoParam(
    $stmt,
    $count,
    "SELECT students.id, fname, lname, students.phone, gender, schools.school_name, schools.id, angis.angi, angis.buleg, angis.id, rd FROM students INNER JOIN schools ON students.school_id = schools.id INNER JOIN angis ON students.angi_id = angis.id WHERE students.angi_id = '$get_id' and students.tuluv=0 " . $sql,
    $id,
    $fname,
    $lname,
    $phone,
    $gender,
    $school_name,
    $school_id,
    $angi,
    $buleg,
    $angi_id,
    $rd
);
$columnNumber = 9;
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
                <div class="col-lg-6 col-sm-12">
                    <div class="col-sm-6:eq(0)"></div>
                    <h4 class="fw-bold py-3 mb-4">Судалгаа бүртгэх - Сурагчид (<?= $count ?>)</h4>
                </div>
            </div>
            <div></div>
            <div class="table-responsive text-nowrap">
                <table class="display" id="datalist">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Эцэг/эх-ийн нэр</th>
                            <th>Нэр</th>
                            <th>РД</th>
                            <th>Утас</th>
                            <th>Хүйс</th>
                            <th>Байгууллага</th>
                            <th>Анги</th>
                            <th>Бүлэг</th>
                            <th></th>
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
                                    <td id="f8-<?= $id ?>"><?= $rd ?></td>
                                    <td id="f3-<?= $id ?>"><?= $phone ?></td>
                                    <td id="f4-<?= $id ?>"><?= $gender ?></td>
                                    <td id="f5-<?= $id ?>" data-sid="<?= $school_id ?>"><?= $school_name ?></td>
                                    <td id="f6-<?= $id ?>" data-aid="<?= $angi_id ?>"><?= $angi ?></td>
                                    <td id="f7-<?= $id ?>"><?= $buleg ?></td>
                                    <td>
                                        <?php
                                        $count_sid = 0;
                                        _selectRowNoParam(
                                            "SELECT DISTINCT(student_id) FROM `sudalgaas` WHERE student_id = '$id' and jil = '$jil'",
                                            $count_sid
                                        );
                                        if ($count_sid > 0) {
                                            echo "<a href='/sudalgaa/insertsudalgaa?id=$id&angi=$angi&type=1'>
                                                    <div class='btn btn-warning'>Засах</div>
                                                </a>";
                                        }
                                        else {
                                            echo "<a href='/sudalgaa/insertsudalgaa?id=$id&angi=$angi&type=0'>
                                                    <div class='btn btn-primary'>Судалгаа бөглөх</div>
                                                </a>";
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php require ROOT . "/pages/footer.php"; ?>
        <?php require ROOT . "/pages/dataTablefooter.php"; ?>
        <?php require ROOT . "/pages/end.php"; ?>