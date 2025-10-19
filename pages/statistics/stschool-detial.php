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
$get_id = $_GET["id"];
_selectNoParam(
    $stmt,
    $count,
    "SELECT angis.id, angis.angi, angis.buleg, COUNT(students.id) FROM students 
    INNER JOIN angis ON students.angi_id = angis.id 
    WHERE students.school_id = '$get_id' and students.tuluv = '0' GROUP BY angis.id",
    $angi_id,
    $angi_name,
    $angi_buleg,
    $st_too
);
$schools = array();
/*
while (_fetch($stmt)) {
    array_push($schools, [$angi_id, $angi_name, $st_too]);
}
*/?>
<div class="layout-page">
    <!-- Navbar -->
    <?php require ROOT . "/pages/navbar.php";
    ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card" style="padding: 20px;">
            <div class="row gy-3">
                <!-- Default Modal -->
                <div class="col-lg-6 col-sm-12">
                    <div class="col-sm-6:eq(0)"></div>
                    <h4 class="fw-bold py-3 mb-4">Байгууллага</h4>
                </div>
            </div>
            <div id="barChart"></div>
            <div class="table-responsive text-nowrap">
                <table class="display" id="datalist">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Ангийн нэр</th>
                            <th>Анги</th>
                            <th>Бүлэг</th>
                            <th>Судалгаанд хамрагдсан</th>
                            <th>Нийт</th>
                            <th>Хувь</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php $too = 0;
                        while (_fetch($stmt)) : $too++;
                            _selectRowNoParam(
                                "SELECT COUNT(DISTINCT sudalgaas.student_id) FROM sudalgaas INNER JOIN students ON sudalgaas.student_id = students.id WHERE jil = '$h_jil' and students.angi_id = '$angi_id'",
                                $i_too
                            );
                        ?>
                            <tr>
                                <td><?= $too ?></td>
                                <td><a href="/statistics/stschool-detialitem?id=<?= $angi_id ?>"><?= $angi_name.$angi_buleg ?></a></td>
                                <td><?= $angi_name ?></td>
                                <td><?= $angi_buleg ?></td>
                                <td><?= $i_too ?></td>
                                <td><?= $st_too  ?></td>
                                <td><?= round(($i_too/$st_too) * 100, 2) ?>%</td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php require ROOT . "/pages/footer.php"; ?>
        <?php require ROOT . "/pages/dataTablefooter.php"; ?>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

        <?php require ROOT . "/pages/end.php"; ?>