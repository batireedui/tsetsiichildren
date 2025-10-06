<?php require "start.php"; ?>
<link rel="stylesheet" type="text/css" href="/assets/css/dataTable.css">
<link rel="stylesheet" href="/assets/vendor/libs/select2/select2.css " />
<style>
    .dt-buttons {
        text-align: end;
        margin-bottom: 15px
    }
</style>
<?php
require "header.php";
$sql = "";
if ($user_role == "najiltan") {
    $sql = " and schools.id = $school_id";
} elseif ($user_role == "teacher") {
    $sql = " and schools.id = $school_id and angis.teacher_id = $user_id";
}
_selectNoParam(
    $stmt,
    $count,
    "SELECT angis.id, angi, buleg, angis.school_id, school_name, (SELECT CONCAT(teachers.fname, ' ', teachers.lname) FROM teachers WHERE id = angis.teacher_id),  angis.teacher_id FROM angis INNER JOIN schools ON angis.school_id = schools.id WHERE angis.tuluv=0 " . $sql,
    $id,
    $angi,
    $buleg,
    $school_id,
    $school_name,
    $teacher_name,
    $teacher_id
);

$columnNumber = 5;

?>
<div class="layout-page">
    <!-- Navbar -->
    <?php require "navbar.php";
    ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Bootstrap Table -->
        <div class="card" style="padding: 20px;">
            <div class="row gy-3">
                <!-- Default Modal -->
                <div class="col-lg-6 col-sm-12">
                    <div class="col-sm-6:eq(0)"></div>
                    <h4 class="fw-bold py-3 mb-4">Ангийн бүртгэл (<?= $count ?>)</h4>
                </div>
                <div class="col-lg-6 col-sm-12" style="text-align: end">
                    <?php if ($user_role != "teacher") { ?>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNew">
                            Анги бүртгэх
                        </button>
                    <?php } ?>
                </div>
                <?php if (isset($_SESSION['messages'])) : ?>
                    <div class="alert alert-primary alert-dismissible" role="alert">
                        <?php foreach ($_SESSION['messages'] as $v) {
                            echo "$v";
                        } ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php unset($_SESSION['messages']);
                endif ?>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="display" id="datalist">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Сургууль</th>
                            <th>Ангийн багш</th>
                            <th>Анги</th>
                            <th>Бүлэг</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php if ($count > 0) : ?>
                            <?php $too = 0;
                            while (_fetch($stmt)) : $too++ ?>
                                <tr id="row-<?= $id ?>">
                                    <td><?= $too ?></td>
                                    <td id="f1-<?= $id ?>" data-sid="<?= $school_id ?>"><?= $school_name ?></td>
                                    <td id="f2-<?= $id ?>" data-tid="<?= $teacher_id ?>"><?= $teacher_name ?></td>
                                    <td id="f3-<?= $id ?>"><?= $angi ?></td>
                                    <td id="f4-<?= $id ?>"><?= $buleg ?></td>
                                    <td>
                                        <?php if ($user_role != "teacher") : ?>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>

                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" role="button" onclick="edit(<?= $id ?>)"><i class="bx bx-edit-alt me-1"></i> Засварлах</a>
                                                    <a class="dropdown-item" role="button" onclick="deletesc(<?= $id ?>)"><i class="bx bx-trash me-1"></i> Устгах</a>
                                                    <a class="dropdown-item" role="button" onclick="graduation(<?= $id ?>)"><i class='bx bxs-graduation me-1'></i>Төгсөлтөөр бүртгэх</a>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" id="addNew" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Анги бүртгэх</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/record/action" id="addForm" method="POST">
                            <div class="row">
                                <div class="col mb-3">
                                    <label class="form-label">Сургууль</label>
                                    <select class="select2 form-select form-select-lg" data-allow-clear="true" id="school" name="school" onchange="onSchool('add')" required>
                                        <option value="">Сургууль сонгоно уу</option>
                                        <?php foreach ($school_list as $nschool) : ?>
                                            <option value="<?= $nschool[0] ?>"><?= $nschool[1] ?> (<?= $nschool[2] ?>)</option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <label class="form-label">Ангийн багш</label>
                                    <select class="form-control" id="teacher" name="teacher">

                                    </select>
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="form-label">Анги</label>
                                    <select class="form-control" id="class" name="class">
                                        <?php for ($i = 1; $i <= 12; $i++) : ?>
                                            <option><?= $i ?></option>
                                        <?php endfor ?>
                                    </select>
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="form-label">Бүлэг</label>
                                    <input type="text" class="form-control" id="buleg" name="buleg" required>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Хаах
                        </button>
                        <input type="submit" class="btn btn-primary" value="Хадгалах" name="angiadd" />
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="editmodal" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Ангийн засварлах</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/record/action" method="POST">
                            <div class="row">
                                <div class="col mb-3">
                                    <label class="form-label">Сургууль</label>
                                    <select class="form-control" id="eschool" name="eschool" onchange="onSchool('edit')" required>
                                        <option value="">Сургууль сонгоно уу</option>
                                        <?php foreach ($school_list as $nschool) : ?>
                                            <option value="<?= $nschool[0] ?>"><?= $nschool[1] ?> (<?= $nschool[2] ?>)</option>
                                        <?php endforeach ?>
                                    </select>
                                    <input type="text" style="display: none" id="eangi_id" name="eangi_id" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <label class="form-label">Ангийн багш</label>
                                    <select class="select2 form-select form-select-lg" data-allow-clear="true" class="form-control" id="eteacher" name="eteacher">

                                    </select>
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="form-label">Анги</label>
                                    <input type="text" class="form-control" id="eclass" name="eclass" required>
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="form-label">Бүлэг</label>
                                    <input type="text" class="form-control" id="ebuleg" name="ebuleg" required>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Хаах
                        </button>
                        <input type="submit" class="btn btn-primary" value="Хадгалах" name="angiedit" />
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="deletemodal" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Анги устгах</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/record/action" method="POST">
                            <h4 id=dschoolinfo>Ангийн бүртгэл устгах уу?</h4>
                            <input type="text" style="display: none" id="dangi_id" name="dangi_id" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Болих
                        </button>
                        <input type="submit" class="btn btn-danger" value="Устгах" name="angidelete" />
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="gmodal" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Анги устгах</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h4 id=gschoolinfo>Ангийн бүртгэл төгсөлтөөр бүртгэх үү? Тус ангийн бүх сурагч төгсөгчөөр бүртгэгдэр болно.</h4>
                        <input type="text" style="display: none" id="gangi_id" name="dangi_id" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Болих
                        </button>
                        <input type="submit" class="btn btn-danger" value="Тийм" onclick="grade()" />
                    </div>
                </div>
            </div>
        </div>
        <?php require "footer.php"; ?>
        <?php require "dataTablefooter.php"; ?>
        <script type="text/javascript">
            function onSchool(t) {
                let id = $("#school").val();
                if (t === "edit") {
                    id = $("#eschool").val();
                }
                $.ajax({
                    type: 'POST',
                    url: '/ajax/angisublist',
                    data: jQuery.param({
                        type: "teacherlist",
                        id: id,
                    }),
                    success: function(data) {
                        $("#teacher").html(data);
                        $("#eteacher").html(data);
                    }
                });
            };

            function edit(id) {
                console.log($('#f1-' + id).data('sid'));
                $("#eschool").val($('#f1-' + id).data('sid')).trigger('change');
                $("#eclass").val($('#f3-' + id).text());
                $("#ebuleg").val($('#f4-' + id).text());
                $("#eangi_id").val(id);
                $.ajax({
                    type: 'POST',
                    url: '/ajax/angisublist',
                    data: jQuery.param({
                        type: "teacherlist",
                        id: $('#f1-' + id).data('sid'),
                    }),
                    success: function(data) {
                        $("#eteacher").html(data);
                        $("#eteacher").val($('#f2-' + id).data('tid')).trigger('change');
                    }
                });
                $('#editmodal').modal('show');
            };

            function deletesc(id) {
                let school_name = $('#f1-' + id).text() + " сургуулийн " + $('#f3-' + id).text() + $('#f4-' + id).text();
                $('#deletemodal').modal('show');
                $("#dschoolinfo").html('"' + school_name + '" анги устгах уу?');
                $("#dangi_id").val(id);
            }

            function graduation(id) {
                let school_name = $('#f1-' + id).text() + " сургуулийн " + $('#f3-' + id).text() + $('#f4-' + id).text();
                $('#gmodal').modal('show');
                $("#gschoolinfo").html('"' + school_name + '" ангийг төгсөлтөөр бүртгэх үү? Тус ангийн бүх сурагч төгсөгчөөр бүртгэгдэх болно!');
                $("#gangi_id").val(id);
            }

            function grade() {
                $.ajax({
                    type: 'POST',
                    url: '/ajax/graduation',
                    data: jQuery.param({
                        id: $("#gangi_id").val(),
                    }),
                    success: function(data) {
                        $('#gmodal').modal('toggle');
                        $('#row-' + $("#gangi_id").val()).remove();
                    }
                });
            }
        </script>
        <script src="/assets/vendor/libs/select2/select2.js"></script>
        <script>
            $(document).ready(function() {
                //change selectboxes to selectize mode to be searchable
                $(".select2").select2();
                $('#school').select2({
                    dropdownParent: $('#addNew')
                });
                $('#teacher').select2({
                    dropdownParent: $('#addNew')
                });
                $('#eschool').select2({
                    dropdownParent: $('#editmodal')
                });
                $('#eteacher').select2({
                    dropdownParent: $('#editmodal')
                });
            });
        </script>
        <?php require "end.php"; ?>