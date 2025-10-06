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

$bulegs = array();

while (_fetch($stmt)) {
    array_push($bulegs, [$id, $name]);
};
$jil = $_SESSION['jil'];
$sh_too = 0;
?>
<div class="layout-page">
    <!-- Navbar -->
    <?php require "navbar.php";
    ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Bootstrap Table -->
        <div class="card" style="padding: 20px;">
            <?php if (!empty($_SESSION['action'])) : ?>
                <div class="alert alert-primary alert-dismissible" role="alert">
                    <?php echo $_SESSION['action'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>
            <?php unset($_SESSION['action']);
            endif; ?>
            <div class="row gy-3">
                <!-- Default Modal -->
                <div class="col-lg-6 col-sm-12">
                    <div class="col-sm-6:eq(0)"></div>
                    <h4 class="fw-bold py-3 mb-4" id="too">Шалгуур үзүүлэлтийн бүртгэл (<?= $count ?>)</h4>
                </div>
                <div class="col-lg-6 col-sm-12" style="text-align: end">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNewa">
                        Бүлэг бүртгэх
                    </button>
                    <a href="/shalguuradd"><button type="button" class="btn btn-primary">
                            Шалгуур үзүүлэлт бүртгэх
                        </button>
                    </a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Шалгуур үзүүлэлт</th>
                            <th>Хариултын төрөл</th>
                            <th>Задаргаатай</th>
                            <th>Бага ангид</th>
                            <th>Ахлах ангид</th>
                            <th>Төлөв</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php if ($count > 0) : ?>
                            <?php
                            foreach ($bulegs as $buleg) {
                                _select(
                                    $sstmt,
                                    $scount,
                                    "SELECT id, name, ded, turul, hariulttype, tuluv FROM shalguurs WHERE buleg_id=?",
                                    "i",
                                    [$buleg[0]],
                                    $sid,
                                    $sname,
                                    $sded,
                                    $sturul,
                                    $hariulttype,
                                    $stuluv
                                );
                            ?>
                                <tr>
                                    <td colspan="7" id="b1-<?= $buleg[0] ?>"><b><?= $buleg[1] ?></b></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" onclick="editbuleg(<?= $buleg[0] ?>)"><i class="bx bx-edit-alt me-1"></i> Засварлах</a>
                                                <a class="dropdown-item" onclick="deletebuleg(<?= $buleg[0] ?>)"><i class="bx bx-trash me-1"></i> Устгах</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                $too = 0;
                                while (_fetch($sstmt)) :
                                    $too++;
                                    $hval = "Нэг";
                                    if ($hariulttype == '1') $hval = "Олон";
                                ?>
                                    <tr>
                                        <td><?= $too ?></td>
                                        <td id="f1-<?= $sid ?>" data-sid="<?= $id ?>"><?= $sname ?></td>
                                        <td id="f2-<?= $sid ?>" data-tid="<?= $id ?>"><?php echo $sturul == 0 ? "<div class='btn btn-xs rounded-pill me-2 btn-outline-info'>Тийм/Үгүй</div>" : "<div class='btn btn-xs rounded-pill me-2 btn-outline-warning'>Олон сонголт</div>" ?></td>
                                        <td id="f3-<?= $sid ?>"><?php echo $sded == 0 ? "<div class='btn btn-xs rounded-pill me-2 btn-outline-primary'>Задаргаагүй</div>" : "<div class='btn btn-xs rounded-pill me-2 btn-outline-secondary'>Тийм ($hval)</div>" ?></td>
                                        <?php
                                        _selectNoParam(
                                            $astmt,
                                            $acount,
                                            "SELECT id FROM activeshes WHERE shalguur_id = $sid and turul = '0'",
                                            $aid
                                        );
                                        ?>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" onclick="shalguurSet(this, <?= $sid ?>, 0)" <?php echo $acount > 0 ? 'checked' : '' ?>>
                                            </div>
                                        </td>
                                        <?php
                                        _selectNoParam(
                                            $astmt,
                                            $acount,
                                            "SELECT id FROM activeshes WHERE shalguur_id = $sid and turul = '1'",
                                            $aid
                                        );
                                        ?>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" onclick="shalguurSet(this, <?= $sid ?>, 1)" <?php echo $acount > 0 ? 'checked' : '' ?>>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" onclick="changeTuluv(this, <?= $sid ?>)" <?php echo $stuluv > 0 ? 'checked' : '' ?>>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a href="/shalguuredit?id=<?= $sid ?>" class="dropdown-item"><i class="bx bx-edit-alt me-1"></i> Засварлах</a>
                                                    <a class="dropdown-item" onclick="deleteShalguur(<?= $sid ?>)"><i class="bx bx-trash me-1"></i> Устгах</a>
                                                </div>
                                            </div>
                                        </td>

                                    </tr>
                            <?php endwhile;
                                $sh_too += $too;
                            } ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" id="addNewa" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Шалгуур үзүүлэлт бүртгэх</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/record/action" method="POST">
                            <div class="row">
                                <div class="col mb-3">
                                    <label class="form-label">Бүлгийн нэр</label>
                                    <input type="text" class="form-control" id="angilal" name="angilal" required>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Хаах
                        </button>
                        <input type="submit" class="btn btn-primary" value="Хадгалах" name="shangilaladd" />
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="editmodal" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Шалгуур үзүүлэлтийн бүлэг засах</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/record/action" method="POST">
                            <div class="row">
                                <div class="col mb-3">
                                    <label class="form-label">Бүлгийн нэр</label>
                                    <input type="text" class="form-control" id="eangilal" name="eangilal" required>
                                    <input type="text" style="display: none;" id="eid" name="eid" readonly required>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Хаах
                        </button>
                        <input type="submit" class="btn btn-primary" value="Хадгалах" name="shangilaledit" />
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="deletemodal" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Шалгуур үзүүлэлт устгах</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/record/action" method="POST">
                            <h4 id=dschoolinfo>Шалгуур үзүүлэлтийн бүртгэл устгах уу?</h4>
                            <input type="text" style="display: none" id="dangi_id" name="dangi_id" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Болих
                        </button>
                        <input type="submit" class="btn btn-danger" value="Устгах" name="shalguurdelete" />
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="deleteAngilal" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Шалгуур үзүүлэлт устгах</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/record/action" method="POST">
                            <h4 id=dbuleginfo>Шалгуур үзүүлэлтийн бүртгэл устгах уу?</h4>
                            <input type="text" style="display: none" id="dbuleg_id" name="dbuleg_id" readonly required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Болих
                        </button>
                        <input type="submit" class="btn btn-danger" value="Устгах" name="bulegdelete" />
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <?php require "footer.php"; ?>
        <?php require "dataTablefooter.php"; ?>
        <script type="text/javascript">
            function changeTuluv(ch, id) {
                $.ajax({
                    type: 'POST',
                    url: '/ajax/activeset',
                    data: jQuery.param({
                        type: "changeTuluv",
                        shalguurid: id,
                        tuluv: ch.checked,
                    }),
                    success: function(data) {
                        console.log(data);
                    }
                });
            };

            function shalguurSet(ch, id, t) {
                if (ch.checked === true) {
                    $.ajax({
                        type: 'POST',
                        url: '/ajax/activeset',
                        data: jQuery.param({
                            type: "activeAdd",
                            shalguurid: id,
                            turul: t,
                        }),
                        success: function(data) {
                            console.log(data);
                        }
                    });
                } else {
                    $.ajax({
                        type: 'POST',
                        url: '/ajax/activeset',
                        data: jQuery.param({
                            type: "activeRemove",
                            shalguurid: id,
                            turul: t,
                        }),
                        success: function(data) {
                            console.log(data);
                        }
                    });
                }
            };
            sh_too();

            function sh_too() {
                $("#too").html("Шалгуур үзүүлэлтийн бүртгэл (" + <?= $sh_too ?> + ")");
            };

            function editbuleg(id) {
                $("#eangilal").val($('#b1-' + id).text());
                $("#eid").val(id);
                $('#editmodal').modal('show');
            };

            function deletebuleg(id) {
                $("#dbuleg_id").val(id);
                $("#dbuleginfo").html($('#b1-' + id).text() + ' бүлэг устгах уу?');
                $('#deleteAngilal').modal('show');
            };

            function deleteShalguur(id) {
                let school_name = $('#f1-' + id).text();
                $('#deletemodal').modal('show');
                $("#dschoolinfo").html('"' + school_name + '" шалгуур үзүүлэлт устгах уу?');
                $("#dangi_id").val(id);
            }
        </script>
        <?php require "end.php"; ?>