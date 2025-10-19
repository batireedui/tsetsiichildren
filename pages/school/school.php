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

_select(
    $stmt,
    $count,
    "SELECT schools.id, school_name, `sum`, director, schools.phone, (SELECT COUNT(id) FROM students WHERE students.school_id = schools.id AND tuluv = 0) FROM schools WHERE schools.tuluv=?",
    "i",
    ['0'],
    $id,
    $school_name,
    $sum,
    $director,
    $phone,
    $stoo
);
$columnNumber = 6;
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
                    <h4 class="fw-bold py-3 mb-4">Байгууллагын бүртгэл (<?= $count ?>)</h4>
                </div>
                <div class="col-lg-6 col-sm-12" style="text-align: end">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNew">
                        Байгууллага бүртгэх
                    </button>
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="display" id="datalist">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Байгууллагын нэр</th>
                            <th>Сум</th>
                            <th>Захирал</th>
                            <th>Утас</th>
                            <th>Сурагчдын тоо</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php if ($count > 0) : ?>
                            <?php $too = 0;
                            while (_fetch($stmt)) : $too++ ?>
                                <tr>
                                    <td><?= $too ?></td>
                                    <td id="f1-<?= $id ?>"><?= $school_name ?></td>
                                    <td id="f2-<?= $id ?>"><?= $sum ?></td>
                                    <td id="f3-<?= $id ?>"><?= $director ?></td>
                                    <td id="f4-<?= $id ?>"><?= $phone ?></td>
                                    <td><?= $stoo ?></td>
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
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Сурагч бүртгэх</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/record/action" id="addForm" method="POST">
                            <div class="row">
                                <div class="col mb-3">
                                    <label class="form-label">Байгууллагын нэр</label>
                                    <input type="text" class="form-control" id="school_name" name="school_name" required>
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col mb-0">
                                    <label class="form-label">Баг</label>
                                    <select class="form-control" id="sum" name="sum">
                                        <?php foreach ($sumd as $nsum) : ?>
                                            <option><?= $nsum ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="col mb-0">
                                    <label class="form-label">Захирал</label>
                                    <input type="text" class="form-control" id="director" name="director" required>
                                </div>
                                <div class="col mb-0">
                                    <label class="form-label">Утас</label>
                                    <input type="text" class="form-control" id="phone" name="phone" required>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Хаах
                        </button>
                        <input type="submit" class="btn btn-primary" value="Хадгалах" name="schooladd" />
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="editmodal" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Байгууллагын бүртгэх</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/record/action" id="editForm" method="POST">
                            <div class="row">
                                <div class="col mb-3">
                                    <label class="form-label">Байгууллагын нэр</label>
                                    <input type="text" class="form-control" id="eschool_name" name="eschool_name" required>
                                    <input type="text" style="display: none" id="eschool_id" name="eschool_id" required>
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col mb-0">
                                    <label class="form-label">Сум</label>
                                    <select class="form-control" id="esum" name="esum">
                                        <?php foreach ($sumd as $nsum) : ?>
                                            <option><?= $nsum ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="col mb-0">
                                    <label class="form-label">Захирал</label>
                                    <input type="text" class="form-control" id="edirector" name="edirector" required>
                                </div>
                                <div class="col mb-0">
                                    <label class="form-label">Утас</label>
                                    <input type="text" class="form-control" id="ephone" name="ephone" required>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Хаах
                        </button>
                        <input type="submit" class="btn btn-primary" value="Хадгалах" name="schooledit" />
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="deletemodal" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Сурагч устгах</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/record/action" method="POST">
                            <h4 id=dschoolinfo>Сурагчийн бүртгэл устгах уу?</h4>
                            <input type="text" style="display: none" id="dschool_id" name="dschool_id" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Болих
                        </button>
                        <input type="submit" class="btn btn-danger" value="Устгах" name="schooldelete" />
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <?php require ROOT . "/pages/footer.php"; ?>
        <?php require ROOT . "/pages/dataTablefooter.php"; ?>
        <script type="text/javascript">
            function edit(id) {
                let school_name = $('#f1-' + id).text();
                let sum = $('#f2-' + id).text();
                let director = $('#f3-' + id).text();
                let phone = $('#f4-' + id).text();
                $('#editmodal').modal('show');
                $("#eschool_name").val(school_name);
                $("#esum").val(sum);
                $("#edirector").val(director);
                $("#ephone").val(phone);
                $("#eschool_id").val(id);
            };

            function deletesc(id) {
                let school_name = $('#f1-' + id).text();
                $('#deletemodal').modal('show');
                $("#dschoolinfo").html('"' + school_name + '" cургуулийн бүртгэл устгах уу?');
                $("#dschool_id").val(id);
            }
        </script>
        <?php require ROOT . "/pages/end.php"; ?>