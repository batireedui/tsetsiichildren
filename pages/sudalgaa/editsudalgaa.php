<?php require ROOT . "/pages/start.php"; ?>
<style>
    .itemtest {
        BACKGROUND-COLOR: #f9f9f9;
        padding: 15px;
        border-radius: 15px;
        margin: 10px;
        border: solid 1px;
    }

    .itemded {
        padding: 10px;
        background: rgb(235, 231, 255);
        border-radius: 10px;
    }
</style>
<?php
require ROOT . "/pages/header.php";

$student_id = $_GET["id"];
$jil = $_SESSION['jil'];

$sql = "";
if ($user_role == "najiltan") {
    $sql = " and students.school_id = $school_id";
} elseif ($user_role == "teacher") {
    $sql = " and students.school_id = $school_id and angis.teacher_id = $user_id";
}
_selectNoParam(
    $stmt,
    $count,
    "SELECT students.id FROM students INNER JOIN angis ON students.angi_id = angis.id WHERE students.tuluv=0 " . $sql,
    $id
);
$students = array();

while (_fetch($stmt)) {
    array_push($students, $id);
}
$check = "";
$check = array_search($student_id, $students);

?>

<div class="layout-page">
    <!-- Navbar -->
    <?php require ROOT . "/pages/navbar.php";
    ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <?php if ($check > -1) :

            _selectNoParam(
                $e_stmt,
                $e_count,
                "SELECT value, shalguur_id, shalguurded_id FROM `sudalgaas` WHERE student_id = '$id' and jil = '$jil'",
                $e_value,
                $e_shalguur_id,
                $e_shalguurded_id
            );
            $e_sudalgaa = array();
            if ($e_count > 0) {
                while (_fetch($e_stmt)) {
                    array_push($e_sudalgaa, [$e_value, $e_shalguur_id, $e_shalguurded_id]);
                }
            }
            _selectNoParam(
                $stmt,
                $count,
                "SELECT id, name FROM shalguurbuleg WHERE shalguurbuleg.tuluv = 1 ORDER BY shalguurbuleg.id",
                $buleg_id,
                $buleg_name
            );

        ?>
            <div class="card" style="padding: 20px;">
                <div class="row gy-3">
                    <!-- Default Modal -->
                    <div class="col-lg-6 col-sm-12">
                        <div class="col-sm-6:eq(0)"></div>
                        <h4 class="fw-bold py-3 mb-4">Сургууль <?= $check ?></h4>
                    </div>
                </div>
                <div class="row gy-3">
                    <form action="/sudalgaa/actionsudalgaa" method="POST">
                        <input type="text" value="<?= $student_id ?>" name="student_id" style="display: none;" readonly />
                        <div><?= print_r($e_sudalgaa) ?></div>
                        <?php while (_fetch($stmt)) :
                            $dugaar = 1;
                            _selectNoParam(
                                $qstmt,
                                $qcount,
                                "SELECT shalguurs.id, shalguurs.name, shalguurs.ded, shalguurs.hariulttype, shalguurs.turul FROM `shalguurs` WHERE buleg_id = '$buleg_id' AND shalguurs.tuluv = 1 ORDER BY  shalguurs.id;",
                                $shalguur_id,
                                $shalguur_name,
                                $shalguur_ded,
                                $hariulttype,
                                $shalguurs_turul
                            ); ?>
                            <div>
                                <h3><?= $buleg_name ?></h3>
                                <?php while (_fetch($qstmt)) {
                                    echo "<div class='itemtest'><div style='font-weight: bold;'>$dugaar). $shalguur_name</div>";
                                    if ($shalguurs_turul == '0') {
                                        if ($shalguur_ded == '1') {
                                            echo "<div class='form-check'>
                                                    <input class='form-check-input' type='radio' name='hariult$shalguur_id' value='1***' onclick=\"HideShow($shalguur_id, 1)\" required>
                                                    <label class='form-check-label'>Тийм</label>
                                                </div>";
                                            _selectNoParam(
                                                $dstmt,
                                                $dcount,
                                                "SELECT id, name, turul FROM `shalguurdeds` WHERE shalguur_id = '$shalguur_id' AND tuluv = 1",
                                                $ded_id,
                                                $ded_name,
                                                $ded_turul
                                            );
                                            echo "<div class='itemded' style='display: none' id='deddiv$shalguur_id'><strong>Доорх сонголтоос сонголт хийнэ</strong>";
                                            if ($hariulttype == '0') {
                                                while (_fetch($dstmt)) {
                                                    echo "<div class='form-check'>
                                                        <input data-dedradio='dedradio$shalguur_id' class='form-check-input' type='radio' name='hariult$shalguur_id-1' value='$ded_id'>
                                                        <label class='form-check-label'>$ded_name</label>
                                                    </div>";
                                                }
                                            } else if ($hariulttype == '1') {
                                                while (_fetch($dstmt)) {
                                                    echo "<div class='form-check'>
                                                        <input data-dedradio='dedradio$shalguur_id' class='form-check-input' type='checkbox' onclick=checkHandle(\"dedmulti$shalguur_id-[]\") name='dedmulti$shalguur_id-[]' value='$ded_id'>
                                                        <label class='form-check-label'>$ded_name</label>
                                                    </div>";
                                                }
                                            }
                                            echo "</div>";
                                        } else {
                                            echo "<div class='form-check'>
                                            <input class='form-check-input' type='radio' name='hariult$shalguur_id' value='1' onclick=\"HideShow($shalguur_id, 1)\" required>
                                            <label class='form-check-label'>Тийм</label>
                                        </div>";
                                        }
                                        echo "<div class='form-check'>
                                                <input class='form-check-input' type='radio' name='hariult$shalguur_id' value='0' onclick=\"HideShow($shalguur_id, 0)\">
                                                <label class='form-check-label'>Үгүй</label>
                                              </div>";
                                    } else if ($shalguurs_turul == '1') {
                                        $qtype = "radio";
                                        if ($hariulttype == '1') $qtype = "checkbox";
                                        _selectNoParam(
                                            $dstmt,
                                            $dcount,
                                            "SELECT id, name, turul FROM `shalguurdeds` WHERE shalguur_id = '$shalguur_id' AND tuluv = 1",
                                            $ded_id,
                                            $ded_name,
                                            $ded_turul
                                        );
                                        echo "<div style='padding: 10px'><div class='checkbox-group required'>";
                                        while (_fetch($dstmt)) {
                                            echo "<div class='form-check'>
                                            <input class='form-check-input' type='$qtype' name='olon$shalguur_id-[]' onclick=checkHandle(\"olon$shalguur_id-[]\") value='$ded_id' required";
                                            echo "><label class='form-check-label'>$ded_name</label>
                                        </div>";
                                        }
                                        echo "</div></div>";
                                    }
                                    $dugaar++;
                                    echo "</div>";
                                } ?>
                            </div>
                        <?php endwhile; ?>
                        <div><input class="btn btn-primary" type="submit" value="ХАДГАЛАХ" style="width: 100%;" name="sudalgaa_add" /></div>
                    </form>
                </div>
            </div>
        <?php endif; ?>
        <?php require ROOT . "/pages/footer.php"; ?>
        <?php require ROOT . "/pages/dataTablefooter.php"; ?>
        <script type="text/javascript">

            function checkHandle(v) {
                let matches = document.querySelectorAll("[name='" + v + "']");
                let checkBool = false;
                for (let i = 0; i < matches.length; i++) {
                    if (matches[i].checked === true) {
                        checkBool = true;
                        break;
                    }
                }
                if (checkBool === false) {
                    for (let i = 0; i < matches.length; i++) {
                        matches[i].setAttribute('required', '')
                    }
                } else {
                    for (let i = 0; i < matches.length; i++) {
                        matches[i].removeAttribute('required')
                    }
                }
            };

            function HideShow(v, t) {
                let matches = document.querySelectorAll("[data-dedradio='dedradio" + v + "']");

                if (t) {
                    $('#deddiv' + v).css("display", "");
                    if (matches.length > 0)
                        matches[0].setAttribute('required', '');
                } else {
                    for (let i = 0; i < matches.length; i++) {
                        matches[i].checked = false;
                    }
                    $('#deddiv' + v).css("display", "none");
                    if (matches.length > 0)
                        matches[0].removeAttribute('required')
                }
            }
        </script>
        <?php require ROOT . "/pages/end.php"; ?>