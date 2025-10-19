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
$sql = "WHERE teachers.tuluv=0";
if($user_role == "najiltan"){
    $sql .= " and school_id = $school_id";
}
_selectNoParam(
    $stmt,
    $count,
    "SELECT teachers.id, fname, lname, gender, email, teachers.phone, rd, schools.school_name, schools.sum, schools.id, teachers.tuluv, jil, mergejil FROM `teachers` INNER JOIN schools ON teachers.school_id = schools.id $sql",
    $id,
    $fname,
    $lname,
    $gender,
    $email,
    $phone,
    $rd,
    $school_name,
    $school_sum,
    $school_id,
    $btuluv, $jil, $mergejil
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
                    <h4 class="fw-bold py-3 mb-4">Багшийн бүртгэл (<?= $count ?>)</h4>
                </div>
                <div class="col-lg-6 col-sm-12" style="text-align: end">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNewRd">
                        Багш бүртгэх
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
                            <th>Багшийн нэр</th>
                            <th>Хүйс</th>
                            <th>Email</th>
                            <th>Утас</th>
                            <th>РД</th>
                            <th>Байгууллага</th>
                            <th>Төлөв</th>
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
                                    <td id="f8-<?= $id ?>"><?php echo $btuluv=="0" ? "Идэвхтэй" : "Идэвхгүй" ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" onclick="edit(<?= $id ?>, '<?= $jil ?>', '<?= $mergejil ?>')"><i class="bx bx-edit-alt me-1"></i> Засварлах</a>
                                                <a class="dropdown-item" onclick="deletesc(<?= $id ?>)"><i class="bx bx-trash me-1"></i> Хасах</a>
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
                        <h5 class="modal-title" id="modalCenterTitle">Багшийн бүртгэх</h5>
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
                                    <label class="form-label">Мэргэжил:</label>
                                    <input type="text" class="form-control" id="mergejil" name="mergejil" required>
                                </div>

                                <div class="col mb-3">
                                    <label class="form-label">Ажилласан жил:</label>
                                    <input type="text" class="form-control" id="jil" name="jil" required>
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
                        <input type="submit" class="btn btn-primary" value="Хадгалах" name="teacheradd" />
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="editmodal" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Багшийн мэдээлэл засварлах</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/record/action" method="POST">
                            <div class="row">
                                <div class="col mb-3">
                                    <label class="form-label">Овог нэр:</label>
                                    <input type="text" class="form-control" id="efname" name="efname" required>
                                    <input type="text" style="display: none" id="eteacher_id" name="eteacher_id" required>
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
                                    <label class="form-label">Мэргэжил:</label>
                                    <input type="text" class="form-control" id="emergejil" name="emergejil" required>
                                </div>

                                <div class="col mb-3">
                                    <label class="form-label">Ажилласан жил:</label>
                                    <input type="text" class="form-control" id="ejil" name="ejil" required>
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
                        <input type="submit" class="btn btn-primary" value="Хадгалах" name="teacheredit" />
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="deletemodal" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Багшийн бүртгэл хасах</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/record/action" method="POST">
                            <h4 id=dschoolinfo>Багшийн бүртгэл хасах уу?</h4>
                            <input type="text" style="display: none" id="teacher_id" name="teacher_id" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Болих
                        </button>
                        <input type="submit" class="btn btn-danger" value="хасах" name="teacherdelete" />
                    </div>
                    </form>
                </div>
            </div>
        </div>
         <div class="modal fade" id="addNewRd" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Багш бүртгэх</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">РД</label>
                                    <div class="row">
                                        <div class="col-md-2" style="padding-right: 0.1rem">
                                            <select class="form-control" id="crd1">
                                                <option value="А">А</option>
                                                <option value="Б">Б</option>
                                                <option value="В">В</option>
                                                <option value="Г">Г</option>
                                                <option value="Д">Д</option>
                                                <option value="Е">Е</option>
                                                <option value="Ё">Ё</option>
                                                <option value="Ж">Ж</option>
                                                <option value="З">З</option>
                                                <option value="И">И</option>
                                                <option value="Й">Й</option>
                                                <option value="К">К</option>
                                                <option value="Л">Л</option>
                                                <option value="М">М</option>
                                                <option value="Н">Н</option>
                                                <option value="О">О</option>
                                                <option value="Ө">Ө</option>
                                                <option value="П">П</option>
                                                <option value="Р">Р</option>
                                                <option value="С">С</option>
                                                <option value="Т">Т</option>
                                                <option value="У">У</option>
                                                <option value="Ү">Ү</option>
                                                <option value="Ф">Ф</option>
                                                <option value="Х">Х</option>
                                                <option value="Ц">Ц</option>
                                                <option value="Ч">Ч</option>
                                                <option value="Ш">Ш</option>
                                                <option value="Щ">Щ</option>
                                                <option value="Ъ">Ъ</option>
                                                <option value="Ы">Ы</option>
                                                <option value="Ь">Ь</option>
                                                <option value="Э">Э</option>
                                                <option value="Ю">Ю</option>
                                                <option value="Я">Я</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2" style="padding: 0rem 0.1rem">
                                            <select class="form-control" id="crd2">
                                                <option value="А">А</option>
                                                <option value="Б">Б</option>
                                                <option value="В">В</option>
                                                <option value="Г">Г</option>
                                                <option value="Д">Д</option>
                                                <option value="Е">Е</option>
                                                <option value="Ё">Ё</option>
                                                <option value="Ж">Ж</option>
                                                <option value="З">З</option>
                                                <option value="И">И</option>
                                                <option value="Й">Й</option>
                                                <option value="К">К</option>
                                                <option value="Л">Л</option>
                                                <option value="М">М</option>
                                                <option value="Н">Н</option>
                                                <option value="О">О</option>
                                                <option value="Ө">Ө</option>
                                                <option value="П">П</option>
                                                <option value="Р">Р</option>
                                                <option value="С">С</option>
                                                <option value="Т">Т</option>
                                                <option value="У">У</option>
                                                <option value="Ү">Ү</option>
                                                <option value="Ф">Ф</option>
                                                <option value="Х">Х</option>
                                                <option value="Ц">Ц</option>
                                                <option value="Ч">Ч</option>
                                                <option value="Ш">Ш</option>
                                                <option value="Щ">Щ</option>
                                                <option value="Ъ">Ъ</option>
                                                <option value="Ы">Ы</option>
                                                <option value="Ь">Ь</option>
                                                <option value="Э">Э</option>
                                                <option value="Ю">Ю</option>
                                                <option value="Я">Я</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4" style="padding: 0rem 0.1rem">
                                            <input type="text" class="form-control" id="crd" name="rd" oninput="this.value=this.value.replace(/[^0-9]/g,'');" maxlength="8" placeholder="РД-ын тоог оруул" required/>
                                        </div>
                                        <div class="col-md-4" style="padding: 0rem 0.1rem">
                                            <div class="btn btn-primary" onclick="rdCheck()">Хайх</div>
                                        </div>
                                    </div>
                                   <label class="form-label" style="color: red; margin-top: 20px" id="info"></label>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <?php require ROOT . "/pages/footer.php"; ?>
        <?php require ROOT . "/pages/dataTablefooter.php"; ?>
        
        <script type="text/javascript">
            function rdCheck(){
                if($('#crd').val().length === 8){
                let rd = $('#crd1').val()+$('#crd2').val()+$('#crd').val();
                console.log(rd);
                 $.ajax({
                    type: 'POST',
                    url: '/ajax/checkrd',
                    data: jQuery.param({
                        type: "checkrdBagsh",
                        rd: rd,
                    }),
                    success: function(data) {
                        console.log(data);
                        if(data=="no"){
                            document.getElementById("fname").disabled = false;
                            document.getElementById("lname").readOnly = false;
                            document.getElementById("school").readOnly = false;
                            document.getElementById("gender").readOnly = false;
                            document.getElementById("email").readOnly = false;
                            document.getElementById("gender").readOnly = false;
                            document.getElementById("phone").readOnly = false;
                            document.getElementById("jil").readOnly = false;
                            document.getElementById("mergejil").readOnly = false;
                            document.getElementById("rd").readOnly = true;
                            document.getElementById("rd").value = rd;
                            $('#addNewRd').modal('hide');
                            $('#addNew').modal('show');
                            
                        }
                        else{
                            const obj = JSON.parse(data);
                            if(obj.tuluv == 0)
                            {
                                $('#info').html(obj.fname + " "+ obj.lname + " нь " + obj.school_name + " сургуульд бүртгэлтэй байна. Тус сургуулиас хасалт хийлгэнэ үү.")
                            }
                            else{
                                console.log(obj.tuluv);
                                $("#efname").val(obj.fname);
                                $("#elname").val(obj.lname);
                                $("#erd").val(obj.rd);
                                $("#egender").val(obj.gender);
                                $("#eemail").val(obj.email);
                                $("#ephone").val(obj.phone);
                                $("#emergejil").val(obj.mergejil);
                                $("#ejil").val(obj.jil);
                                $("#eteacher_id").val(obj.id);
                                document.getElementById("erd").readOnly = true;
                                $('#addNewRd').modal('hide');
                                $('#editmodal').modal('show');
                            }
                        }
                    }
                });
                }
                else{
                    $('#info').html("РД-ын тоог зөв оруулна уу!");
                }
                
            }
            function edit(id, j, m) {
                $('#editmodal').modal('show');
                $("#eteacher_id").val(id);
                $("#efname").val($('#f1-' + id).text());
                $("#elname").val($('#f2-' + id).text());
                $("#egender").val($('#f3-' + id).text());
                $("#eemail").val($('#f4-' + id).text());
                $("#ephone").val($('#f5-' + id).text());
                $("#emergejil").val(m);
                $("#ejil").val(j);
                $("#erd").val($('#f6-' + id).text());
                $("#eschool").val($('#f7-' + id).data('sid'));
            };

            function deletesc(id) {
                let t_name = $('#f1-' + id).text() + " " + $('#f2-' + id).text();
                $('#deletemodal').modal('show');
                $("#dschoolinfo").html('"' + t_name + '" бүртгэл хасах уу?');
                $("#teacher_id").val(id);
            }
        </script>
        <?php require ROOT . "/pages/end.php"; ?>