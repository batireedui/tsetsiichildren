<?php require ROOT . "/pages/start.php"; ?>

<?php
require ROOT . "/pages/header.php";

if ($user_role == "teacher") {
    $sql_detial = "SELECT id, concat(angi, ' - ', buleg) FROM angis WHERE teacher_id = '$user_id' and school_id = '$school_id'";

    _selectNoParam(
        $st,
        $co,
        $sql_detial,
        $angi_id,
        $angi_name
    );
}
    _selectNoParam(
        $stj,
        $coj,
        "select id, name from jil order by name desc",
        $j_id,
        $j_name
    );
?>

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
                    <h4 class="fw-bold py-3 mb-4">Сургууль</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-sm-12">
                    <select class="select2 form-control " data-allow-clear="true" id="jil">
                        <?php while (_fetch($stj)) {?>
                        <option value="<?=$j_name?>"><?=$j_name?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <select id="selectShalg" class="select2 form-control " data-allow-clear="true">
                        <?php
                        if ($user_role == "teacher") {
                            while (_fetch($st)) {
                                echo "<option value='$angi_id'>$angi_name</option>";
                            }
                        }
                        if ($user_role == "admin" || $user_role == "najiltan") {
                            echo "<option value='0'>Ахлах дунд, бага ангиар</option><option value='-1'>Сургуулиар</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-lg-1 col-sm-12">
                    <button class="btn btn-outline-primary" onclick="clickShalg()">Харах</button>
                </div>
                <div class="col-lg-2 col-sm-12">
                    <button class="btn btn-outline-secondary" onclick="printjs()">Хэвлэх</button>
                </div>
            </div>
            <div id="val" class="demo-inline-spacing" style="text-align: center;"></div>

        </div>
        <?php require ROOT . "/pages/footer.php"; ?>
        <script>
            function printjs(s = "<?=$systemName?>") {
                let selectjil = document.getElementById("jil");
                let jil = selectjil.options[selectjil.selectedIndex].text;
                
                let selectType = document.getElementById("selectShalg");
                let selectTypeText = selectType.options[selectType.selectedIndex].text;
                let title = s + ", " + jil + " оны хичээлийн жил - " + selectTypeText;
                $('#val').printElement({
                  printTitle: title,
                });
            }
            function clickShalg() {
                let id = document.getElementById("selectShalg").value;
                $("#val").html('<button class="btn btn-primary" type="button" disabled><span class="spinner-border me-1" role="status" aria-hidden="true"></span></button>');
                if (parseInt(id) > 0) {
                    $.ajax({
                        type: 'POST',
                        url: 'stnegtgel-ss-teacher',
                        data: jQuery.param({
                            type: "valget",
                            id: id,
                            jil: document.getElementById("jil").value
                        }),
                        success: function(data) {
                            $("#val").html(data);
                            console.log(data);
                        }
                    });
                } else {
                    $.ajax({
                        type: 'POST',
                        url: 'stnegtgel-ss-admin',
                        data: jQuery.param({
                            type: "valget",
                            id: id,
                            jil: document.getElementById("jil").value
                        }),
                        success: function(data) {
                            $("#val").html(data);
                            console.log(data);
                        }
                    });
                }
            }
        </script>
        <?php require ROOT . "/pages/end.php"; ?>