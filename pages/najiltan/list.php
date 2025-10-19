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
if($user_role == "najiltan"){
    $sql = " and school_id = $school_id";
}
_select(
    $stmt,
    $count,
    "SELECT najiltans.id, fname, lname, gender, email, najiltans.phone, rd, schools.school_name, schools.sum, schools.id FROM `najiltans` INNER JOIN schools ON najiltans.school_id = schools.id WHERE najiltans.tuluv=? $sql",
    "i",
    ['0'],
    $id,
    $fname,
    $lname,
    $gender,
    $email,
    $phone,
    $rd,
    $school_name,
    $school_sum,
    $school_id
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
                    <h4 class="fw-bold py-3 mb-4">Нийгмийн ажилтны бүртгэл (<?= $count ?>)</h4>
                </div>
                <div class="col-lg-6 col-sm-12" style="text-align: end">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNew">
                        Нийгмийн ажилтан бүртгэх
                    </button>
                </div>
                <div class="col-lg-6 col-sm-12">
                <?php if (isset($_SESSION['messages'])) : ?>
                    <div class="alert alert-primary alert-dismissible" role="alert">
                        <?php foreach ($_SESSION['messages'] as $v) {
                            echo "$v";
                        } ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php unset($_SESSION['messages']); endif ?>
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="display" id="datalist">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Эцэг/эх-ийн нэр</th>
                            <th>Нэр</th>
                            <th>Хүйс</th>
                            <th>Email</th>
                            <th>Утас</th>
                            <th>РД</th>
                            <th>Байгууллага</th>
                            <th>Баг</th>
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
                                    <td id="f3-<?= $id ?>"><?= $gender ?></td>
                                    <td id="f4-<?= $id ?>"><?= $email ?></td>
                                    <td id="f5-<?= $id ?>"><?= $phone ?></td>
                                    <td id="f6-<?= $id ?>"><?= $rd ?></td>
                                    <td id="f7-<?= $id ?>" data-sid="<?= $school_id ?>"><?= $school_name ?></td>
                                    <td id="f8-<?= $id ?>"><?= $school_sum ?></td>
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
                        <h5 class="modal-title" id="modalCenterTitle">Нийгмийн ажилтан бүртгэх</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/record/action" method="POST">
                            <div class="row">
                                <div class="col mb-3">
                                    <label class="form-label">Овог нэр:</label>
                                    <input type="text" class="form-control" id="fname" name="fname" required>
                                </div>
                                <div class="col mb-3">
                                    <label class="form-label">Өөрийн нэр:</label>
                                    <input type="text" class="form-control" id="lname" name="lname" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label class="form-label">Байгууллага:</label>
                                    <select class="form-control" id="school" name="school">
                                        <?php foreach ($school_list as $sch) : ?>
                                            <option value="<?= $sch[0] ?>"><?= $sch[1] ?> (<?= $sch[2] ?>)</option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="col mb-3">
                                    <label class="form-label">E-mail:</label>
                                    <input type="text" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label class="form-label">Хүйс:</label>
                                    <select class="form-control" id="gender" name="gender">
                                        <option>Эмэгтэй</option>
                                        <option>Эрэгтэй</option>
                                    </select>
                                </div>
                                <div class="col mb-3">
                                    <label class="form-label">Утас:</label>
                                    <input type="text" class="form-control" id="phone" name="phone" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label class="form-label">РД:</label>
                                    <input type="text" class="form-control" id="rd" name="rd" required>
                                </div>

                                <div class="col mb-3">
                                    <label class="form-label">Нууц үг:</label>
                                    <input type="text" class="form-control" id="pass" name="pass" required>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Хаах
                        </button>
                        <input type="submit" class="btn btn-primary" value="Хадгалах" name="najiltanadd" />
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="editmodal" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Нийгмийн ажилтны мэдээлэл засварлах</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/record/action" method="POST">
                            <div class="row">
                                <div class="col mb-3">
                                    <label class="form-label">Овог нэр:</label>
                                    <input type="text" class="form-control" id="efname" name="efname" required>
                                    <input type="text" style="display: none" id="enajiltan_id" name="enajiltan_id" required>
                                </div>
                                <div class="col mb-3">
                                    <label class="form-label">Өөрийн нэр:</label>
                                    <input type="text" class="form-control" id="elname" name="elname" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label class="form-label">Байгууллага:</label>
                                    <select class="form-control" id="eschool" name="eschool">
                                        <?php foreach ($school_list as $sch) : ?>
                                            <option value="<?= $sch[0] ?>"><?= $sch[1] ?> (<?= $sch[2] ?>)</option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="col mb-3">
                                    <label class="form-label">E-mail:</label>
                                    <input type="text" class="form-control" id="eemail" name="eemail" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label class="form-label">Хүйс:</label>
                                    <select class="form-control" id="egender" name="egender">
                                        <option>Эмэгтэй</option>
                                        <option>Эрэгтэй</option>
                                    </select>
                                </div>

                                <div class="col mb-3">
                                    <label class="form-label">Утас:</label>
                                    <input type="text" class="form-control" id="ephone" name="ephone" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label class="form-label">РД:</label>
                                    <input type="text" class="form-control" id="erd" name="erd" required>
                                </div>

                                <div class="col mb-3">
                                    <label class="form-label">Нууц үг:</label>
                                    <input type="text" class="form-control" id="epass" name="epass" required>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Хаах
                        </button>
                        <input type="submit" class="btn btn-primary" value="Хадгалах" name="najiltanedit" />
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="deletemodal" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Нийгмийн ажилтны бүртгэл устгах</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/record/action" method="POST">
                            <h4 id=dschoolinfo>Багшийн бүртгэл устгах уу?</h4>
                            <input type="text" style="display: none" id="najiltan_id" name="najiltan_id" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Болих
                        </button>
                        <input type="submit" class="btn btn-danger" value="Устгах" name="najiltandelete" />
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <?php require ROOT . "/pages/footer.php"; ?>
        <?php require ROOT . "/pages/dataTablefooter.php"; ?>
        <script type="text/javascript">
            function edit(id) {
                $('#editmodal').modal('show');
                $("#enajiltan_id").val(id);
                $("#efname").val($('#f1-' + id).text());
                $("#elname").val($('#f2-' + id).text());
                $("#egender").val($('#f3-' + id).text());
                $("#eemail").val($('#f4-' + id).text());
                $("#ephone").val($('#f5-' + id).text());
                $("#erd").val($('#f6-' + id).text());
                $("#eschool").val($('#f7-' + id).data('sid'));
            };

            function deletesc(id) {
                let t_name = $('#f1-' + id).text() + " " + $('#f2-' + id).text();
                $('#deletemodal').modal('show');
                $("#dschoolinfo").html('"' + t_name + '" бүртгэл устгах уу?');
                $("#najiltan_id").val(id);
            }
        </script>
        <?php require ROOT . "/pages/end.php"; ?>