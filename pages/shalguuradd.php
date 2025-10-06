<?php require "start.php"; ?>
<?php
require "header.php";
_selectNoParam(
    $stmt,
    $count,
    "SELECT id, name FROM shalguurbuleg",
    $id,
    $name
);
?>
<div class="layout-page">
    <!-- Navbar -->
    <?php require "navbar.php";
    ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Bootstrap Table -->
        <div class="card" style="padding: 20px;">
            <form action="/record/action" method="POST">
                <div class="mb-3">
                    <label class="form-label">Бүлэг</label>
                    <select class="form-select" name="buleg">
                        <?php
                        while (_fetch($stmt)) {
                            echo "<option value='$id'>$name</option>";
                        };
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Шалгуур үзүүлэлтийн нэр</label>
                    <input type="text" class="form-control" name="shner" />
                </div>
                <div class="mb-3 row">
                    <div class="col-md-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="tuluv">
                            <label class="form-check-label"> Төлөв </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="hariult" id="typeone" value="0" onchange="yesno(this)" checked />
                            <label class="form-check-label">
                                Тийм/Үгүй
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="hariult" id="typemulti" value="1" onchange="yesno(this)" />
                            <label class="form-check-label" for="defaultRadio1">
                                Олон сонголт
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3" id="expandDiv">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="expand">
                            <label class="form-check-label"> Задаргаа хийх эсэх </label>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <input type="submit" class="btn btn-primary" value="Хадгалах" name="shalguuradd" />
                </div>
            </form>
        </div>
        <?php require "footer.php"; ?>
        <?php require "dataTablefooter.php"; ?>
        <script type="text/javascript">
            function yesno(t) {
                console.log(t.id);
                if (t.checked === true && t.id === "typeone") {
                    $('#expandDiv').css("display", "");
                } else {
                    $('#expandDiv').css("display", "none");
                }
            }
            /*function bulegSelect(t) {
                $.ajax({
                    type: 'POST',
                    url: '/ajax/angisublist',
                    data: jQuery.param({
                        type: "bulegList",
                        id: t.value,
                    }),
                    success: function(data) {
                        $("#shalguurs").html(data);
                    }
                });
            };*/
        </script>
        <?php require "end.php"; ?>