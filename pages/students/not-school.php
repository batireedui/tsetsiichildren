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
                    <h4 class="fw-bold py-3 mb-4">Ангигүй сурагчдын бүртгэл</h4>
                </div>
                <?php if (isset($_SESSION['messages'])) : ?>
                <div class="col-lg-6 col-sm-12">
                    <div class="alert alert-primary alert-dismissible" role="alert">
                        <?php foreach ($_SESSION['messages'] as $v) {
                            echo "$v";
                        } ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
                <?php unset($_SESSION['messages']); endif ?>
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
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <tr>
                            <th>#</th>
                            <th>Эцэг/эх-ийн нэр</th>
                            <th>Нэр</th>
                            <th>РД</th>
                            <th>Утас</th>
                            <th>Хүйс</th>
                            <th></th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" id="shiljmodal" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Сурагч шилжүүлэх</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/record/action" method="POST">
                            <h4 id=shschoolinfo>Сурагчийн шилжсэнээр бүртгэх</h4>
                            <input type="text" style="display: none" id="sh_id" name="sh_id" required>
                            <input type="text" style="display: none" id="angi_sh" name="angi_sh" required>
                            <input type="text" style="display: none" id="sh_sid" name="sh_sid" required>
                            <label>Тайлбар</label>
                            <textarea rows="3"  class="form-control" name="tailbar" cols="50" placeholder="Улаанбаатар шилжсэн"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Болих
                        </button>
                        <input type="submit" class="btn btn-danger" value="Шилжилт хийх" name="studentshilj" />
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="editmodal" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Сурагчийн мэдээлэл засах</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/record/action" id="addForm" method="POST">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">РД</label>
                                    <input type="text" class="form-control" id="erd" name="erd" readonly required>
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
                            <br>
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">Утас</label>
                                    <input type="text" class="form-control" id="eutas" name="eutas" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Үндсэн хаяг</label>
                                    <input type="text" class="form-control" id="ehayg" name="ehayg" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Одоо амьдарч буй хаяг</label>
                                    <input type="text" class="form-control" id="eohayg" name="eohayg" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">ХӨУБ, клубд явдаг эсэх </label>
                                    <select class="form-control" id="eclub" name="eclub">
                                        <option>Үгүй</option>
                                        <option>Тийм</option>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label">Суралцах хугацаандаа хэнтэй хамт амьдардаг</label>
                                    <select class="form-control" id="ehentei" name="ehentei">
                                        <option>Аав, ээжтэйгээ гэртээ амьдардаг</option>
                                        <option>Суралцах хугацаандаа насанд хүрсэн асран хамгаалагчгүй амьдардаг (ах эгч, дүү нартайгаа)</option>
                                        <option>Айлд суудаг (Өвөө, эмээгийндээ суудаг)</option>
                                        <option>Айлд суудаг (Хамаатан садангийндаа суудаг)</option>
                                        <option>Айлд суудаг (Аав ээжийнхээ найзынд суудаг)</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Дугуйлан, секцэнд хамрагддаг эсэх</label>
                                    <select class="form-control" id="edsects" name="edsects">
                                        <option>Үгүй</option>
                                        <option>Тийм</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Байгууллагын нэр</label>
                                    <select class="form-control" id="eschool" name="eschool" onchange="onSchool('edit')">
                                        <option>Байгууллага сонгоно уу</option>
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
        
        <?php require ROOT . "/pages/footer.php"; ?>
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
        <script type="text/javascript">
        
            $(document).ready(function() {
                let table = $('#datalist').DataTable({
                    displayLength: 50,
                    lengthMenu: [50, 100, 150, 200, 500, 1000],
                    processing: true,
                    serverSide: true,
                    ajax: 'ss-not-school',
                    columns: [{
                            data: 'student_id'
                        },
                        {
                            data: 'fname'
                        },
                        {
                            data: 'lname'
                        },
                        {
                            data: 'rd'
                        },
                        {
                            data: 'phone'
                        },
                        {
                            data: 'gender'
                        },
                        {
                            data: null,
                            "bSortable": false,
                            "mRender": function(data) {
                                //return '<div class="dropdown"><button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button><div class="dropdown-menu"><a class="dropdown-item" onclick="edit(' + data.student_id + ', ' + data.school_id + ', ' + data.angi_id + ')"><i class="bx bx-edit-alt me-1"></i> Засварлах</a><a class="dropdown-item" onclick="deletesc(' + data.student_id + ')"><i class="bx bx-trash me-1"></i> Устгах</a><a class="dropdown-item" onclick="shilj(' + data.student_id + ', ' + data.school_id + ')"><i class="bx bx-note me-1"></i> Шилжилт</a></div></div>';
                                return '<div class="dropdown"><button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button><div class="dropdown-menu"><a class="dropdown-item" onclick="edit(' + data.student_id + ', 0, 0)"><i class="bx bx-edit-alt me-1"></i> Засварлах</a></div></div>';
                            }
                        }
                    ],
                    sDom: "B<'row'><'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-4'i>><'row'<'#colvis'>p>",
                    buttons: [{
                            extend: 'copy',
                            className: 'btn btn-outline-primary',
                            text: '<span><i class="bx bx-copy me-2"></i>Copy</span>'
                        },
                        {
                            extend: 'excel',
                            className: 'btn btn-outline-primary',
                            text: '<span><i class="bx bx-file me-2"></i>Excel</span>'
                        },
                        {
                            extend: 'pdf',
                            className: 'btn btn-outline-primary',
                            text: '<span><i class="bx bxs-file-pdf me-2"></i>Pdf</span>'
                        },
                        {
                            extend: 'print',
                            className: 'btn btn-outline-primary',
                            text: '<span><i class="bx bx-printer me-2"></i>Хэвлэх</span>',
                            exportOptions: {
                                columns: [<?php
                                            for ($i = 0; $i <= $columnNumber - 1; $i++) {
                                                echo $i;
                                                echo $i == $columnNumber - 1 ? "" : ", ";
                                            }
                                            ?>]
                            }
                        },
                    ],
                    columnDefs: [{
                        "targets": 0,
                        "searchable": false
                    }],
                    oLanguage: {
                        "sLengthMenu": "Дэлгэцэнд _MENU_ бичлэгээр",
                        "sSearch": "Хайлт хийх:",
                        "oPaginate": {
                            "sNext": "Дараах",
                            "sPrevious": "Өмнөх"
                        },
                        "sInfo": "Нийт _TOTAL_ бүртгэл (_START_ / _END_)",
                        "sInfoFiltered": " - хайлт хийсэн _MAX_ -н бүртгэл"
                    },

                });
                let coln = table.columns().header().length;

                $('div.dataTables_filter input').addClass('form-control');
                $('div.dataTables_length select').addClass('form-control');

            });
        </script>
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

            function edit(id, sid, aid) {
                let row = document.getElementById("row_" + id);
                $("#eovog").val(row.cells[1].innerHTML);
                $("#ener").val(row.cells[2].innerHTML);
                $("#erd").val(row.cells[3].innerHTML);
                $("#egender").val(row.cells[5].innerHTML);
                $("#eutas").val(row.cells[4].innerHTML);
                $("#eschool").val(sid);
                $("#eclass").val(aid);
                $("#edit_id").val(row.cells[0].innerHTML);
                
                $.ajax({
                    type: 'POST',
                    url: '/ajax/angisublist',
                    data: jQuery.param({
                        type: "angilist",
                        id: sid,

                    }),
                    success: function(data) {
                        $("#eclass").html(data);
                        $("#eclass").val(aid);
                    }
                });
                
                $.ajax({
                    type: 'POST',
                    url: '/ajax/editstudent',
                    data: jQuery.param({
                        type: "edits",
                        id: id,

                    }),
                    success: function(data) {
                        //console.log(data);
                        if(data=="no"){ }
                        else{
                            const obj = JSON.parse(data);
                            //console.log(obj.hentei);
                            $("#ehentei").val(obj.hentei);
                            $("#edsects").val(obj.dsects);
                            $("#eclub").val(obj.club);
                            $("#eohayg").val(obj.ohayg);
                            $("#ehayg").val(obj.hayg);
                        }
                    }
                });
                $('#editmodal').modal('show');
            };
            function shilj(id, sid) {
                let row = document.getElementById("row_" + id);
                $('#shiljmodal').modal('show');
                $("#shschoolinfo").html(row.cells[1].innerHTML + " " + row.cells[2].innerHTML + " сурагчийн бүртгэл шилжсэнээр бүртгэх үү?");
                $("#sh_id").val(id);
                $("#sh_sid").val(sid);
                $("#angi_sh").val(row.cells[7].innerHTML + " " + row.cells[8].innerHTML);
            }
        </script>
        <?php require ROOT . "/pages/end.php"; ?>