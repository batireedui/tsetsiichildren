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
if ($user_role == "najiltan") {
    $sql = " and students.school_id = $school_id";
} elseif ($user_role == "teacher") {
    $sql = " and students.school_id = $school_id and angis.teacher_id = $user_id";
}
_selectNoParam(
    $stmt,
    $count,
    "SELECT students.id, fname, lname, students.phone, gender, schools.school_name, schools.id, angis.angi, angis.buleg, angis.id, rd FROM students INNER JOIN schools ON students.school_id = schools.id INNER JOIN angis ON students.angi_id = angis.id WHERE students.tuluv=0 " . $sql,
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
                    <?php //echo "SELECT students.id, fname, lname, students.phone, gender, schools.school_name, schools.id, angis.angi, angis.buleg, angis.id, rd FROM students INNER JOIN schools ON students.school_id = schools.id INNER JOIN angis ON students.angi_id = angis.id WHERE students.tuluv=0 " . $sql; 
                    ?>
                    <h4 class="fw-bold py-3 mb-4">Сурагчдын бүртгэл (<?= $count ?>)</h4>
                </div>
                <div class="col-lg-6 col-sm-12" style="text-align: end">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNew">
                        Сурагч бүртгэх
                    </button>
                </div>
            </div>
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
                            <th>Сургууль</th>
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
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" onclick="edit(<?= $id ?>)"><i class="bx bx-edit-alt me-1"></i> Засварлах</a>
                                                <a class="dropdown-item" onclick="deletesc(<?= $id ?>)"><i class="bx bx-trash me-1"></i> Устгах</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" id="addNew" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Сурагч бүртгэх</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/record/action" id="addForm" method="POST">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">РД</label>
                                    <input type="text" class="form-control" id="rd" name="rd" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Эцэг/эх-ийн нэр</label>
                                    <input type="text" class="form-control" id="ovog" name="ovog" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Сурагчийн нэр</label>
                                    <input type="text" class="form-control" id="ner" name="ner" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Хүйс</label>
                                    <select class="form-control" id="gender" name="gender">
                                        <option>Эмэгтэй</option>
                                        <option>Эрэгтэй</option>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">Утас</label>
                                    <input type="text" class="form-control" id="utas" name="utas" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Үндсэн хаяг</label>
                                    <input type="text" class="form-control" id="hayg" name="hayg" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Одоо амьдарч буй хаяг</label>
                                    <input type="text" class="form-control" id="ohayg" name="ohayg" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">ХӨУБ, клубд явдаг эсэх </label>
                                    <select class="form-control" id="club" name="club">

                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label">Суралцах хугацаандаа хэнтэй хамт амьдардаг</label>
                                    <select class="form-control" id="hentei" name="hentei">
                                        <option></option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Дугуйлан, секцэнд хамрагддаг эсэх</label>
                                    <select class="form-control" id="dsects" name="dsects">

                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Сургуулийн нэр</label>
                                    <select class="form-control" id="school" name="school" onchange="onSchool('add')">
                                        <?php foreach ($school_list as $sch) : ?>
                                            <option value="<?= $sch[0] ?>"><?= $sch[1] ?> (<?= $sch[2] ?>)</option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Анги</label>
                                    <select class="form-control" id="class" name="class">

                                    </select>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Хаах
                        </button>
                        <input type="submit" class="btn btn-primary" value="Хадгалах" name="studentadd" />
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="editmodal" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Сургуулийн бүртгэх</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/record/action" id="addForm" method="POST">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">РД</label>
                                    <input type="text" class="form-control" id="erd" name="erd" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Эцэг/эх-ийн нэр</label>
                                    <input type="text" class="form-control" id="eovog" name="eovog" required>
                                    <input type="text" style="display: none" id="edit_id" name="edit_id" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Сурагчийн нэр</label>
                                    <input type="text" class="form-control" id="ener" name="ener" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Хүйс</label>
                                    <select class="form-control" id="egender" name="egender">
                                        <option>Эмэгтэй</option>
                                        <option>Эрэгтэй</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">Утас</label>
                                    <input type="text" class="form-control" id="eutas" name="eutas" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Үндсэн хаяг</label>
                                    <input type="text" class="form-control" id="ehayg" name="hayg" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Одоо амьдарч буй хаяг</label>
                                    <input type="text" class="form-control" id="eohayg" name="ohayg" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">ХӨУБ, клубд явдаг эсэх </label>
                                    <select class="form-control" id="eclub" name="club">

                                    </select>
                                </div>
                            </div>
                            <div class="row">
                            <div class="col-md-4">
                                    <label class="form-label">Суралцах хугацаандаа хэнтэй хамт амьдардаг</label>
                                    <select class="form-control" id="hentei" name="hentei">
                                        <option></option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Дугуйлан, секцэнд хамрагддаг эсэх</label>
                                    <select class="form-control" id="dsects" name="dsects">

                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Сургуулийн нэр</label>
                                    <select class="form-control" id="eschool" name="eschool" onchange="onSchool('edit')">
                                        <?php foreach ($school_list as $sch) : ?>
                                            <option value="<?= $sch[0] ?>"><?= $sch[1] ?> (<?= $sch[2] ?>)</option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                
                                <div class="col-md-2">
                                    <label class="form-label">Анги</label>
                                    <select class="form-control" id="eclass" name="eclass">

                                    </select>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Хаах
                        </button>
                        <input type="submit" class="btn btn-primary" value="Хадгалах" name="studentedit" />
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
                            <h4 id=dschoolinfo>Сурагчийн бүртгэл устгах уу?</h4>
                            <input type="text" style="display: none" id="s_id" name="s_id" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Болих
                        </button>
                        <input type="submit" class="btn btn-danger" value="Устгах" name="studentdelete" />
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <?php require ROOT . "/pages/footer.php"; ?>
        <?php require ROOT . "/pages/dataTablefooter.php"; ?>
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
                        type: "angilist",
                        id: id,
                    }),
                    success: function(data) {
                        $("#class").html(data);
                        $("#eclass").html(data);
                    }
                });
            };

            function edit(id) {
                $("#eovog").val($('#f1-' + id).text());
                $("#ener").val($('#f2-' + id).text());
                $("#erd").val($('#f8-' + id).text());
                $("#egender").val($('#f4-' + id).text());
                $("#eutas").val($('#f3-' + id).text());
                $("#eschool").val($('#f5-' + id).data('sid'));
                $("#eclass").val($('#f6-' + id).data('aid'));
                $("#edit_id").val(id);
                $.ajax({
                    type: 'POST',
                    url: '/ajax/angisublist',
                    data: jQuery.param({
                        type: "angilist",
                        id: $('#f5-' + id).data('sid'),

                    }),
                    success: function(data) {
                        $("#eclass").html(data);
                        $("#eclass").val($('#f6-' + id).data('aid'));
                    }
                });
                $('#editmodal').modal('show');
            };

            function deletesc(id) {
                let school_name = $('#f1-' + id).text() + " " + $('#f2-' + id).text();
                $('#deletemodal').modal('show');
                $("#dschoolinfo").html('"' + school_name + '" сурагчийн бүртгэл устгах уу?');
                $("#s_id").val(id);
            }
        </script>
        <?php require ROOT . "/pages/end.php"; ?>