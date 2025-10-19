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
                    <h4 class="fw-bold py-3 mb-4">Сурагчдын бүртгэл</h4>
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
        
            function asran(id, turul){
                let row = document.getElementById("row_" + id);
                let rd = row.cells[3].innerHTML;
                $("#aovog").val(row.cells[1].innerHTML);
                $("#aner").val(row.cells[2].innerHTML);
                $("#ard").val(rd);
                $("#asid").val(id);
                if(turul === 1){
                    $.ajax({
                    type: 'POST',
                    url: '/ajax/getasran',
                    data: jQuery.param({
                        type: "getasran",
                        id: id
                    }),
                        success: function(data) {
                            console.log(data);
                            if(data=="no"){
                                
                            }
                            else{
                                const obj = JSON.parse(data);
                                $("#as_ovog").val(obj.as_ovog);
                                $("#as_ner").val(obj.as_ner);
                                $("#as_bol").val(obj.as_bol);
                                $("#as_ajil").val(obj.as_ajil);
                                $("#as_hbe").val(obj.as_hbe);
                                $("#as_sohe").val(obj.as_sohe);
                                $("#as_mun").val(obj.as_mun);
                                $("#as_utas").val(obj.as_utas);
                                
                                $("#as_eovog").val(obj.as_eovog);
                                $("#as_ener").val(obj.as_ener);
                                $("#as_ebol").val(obj.as_ebol);
                                $("#as_eajil").val(obj.as_eajil);
                                $("#as_ehbe").val(obj.as_ehbe);
                                $("#as_esohe").val(obj.as_esohe);
                                $("#as_emun").val(obj.as_emun);
                                $("#as_eutas").val(obj.as_eutas);
                            }
                        }
                    });
                }
                $("#addAsran").modal('show');
            }
            function rdCheck(){
                if($('#crd').val().length === 8){
                let rd = $('#crd1').val()+$('#crd2').val()+$('#crd').val();
                console.log(rd);
                 $.ajax({
                    type: 'POST',
                    url: '/ajax/checkrd',
                    data: jQuery.param({
                        type: "checkrd",
                        rd: rd,
                    }),
                    success: function(data) {
                        if(data=="no"){
                            document.getElementById("studentadd").disabled = false;
                            document.getElementById("ovog").readOnly = false;
                            document.getElementById("ner").readOnly = false;
                            document.getElementById("gender").readOnly = false;
                            document.getElementById("rd").readOnly = true;
                            document.getElementById("rd").value = rd;
                            $('#addNewRd').modal('hide');
                            $('#addNew').modal('show');
                            
                        }
                        else{
                            const obj = JSON.parse(data);
                            if(obj.tuluv == 0)
                            {
                                $('#info').html(obj.fname + " "+ obj.lname + " нь " + obj.school_name + " сургуульд бүртгэлтэй байна. Тус сургуулиас шилжилт хөдөлгөөнөөр хасалт хийлгэнэ үү.")
                            }
                            else if(obj.tuluv == 2)
                            {
                                $('#info').html(obj.fname + " "+ obj.lname + " нь " + obj.school_name + " сургуулиас төгсөлтөөр бүртгэгдсэн байна. Шинээр бүртгэх боломжгүй.")
                            }
                            else{
                                console.log(obj.tuluv);
                                $("#eovog").val(obj.fname);
                                $("#ener").val(obj.lname);
                                $("#erd").val(obj.rd);
                                $("#egender").val(obj.gender);
                                $("#edit_id").val(obj.id);
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
            $(document).ready(function() {
                let table = $('#datalist').DataTable({
                    displayLength: 50,
                    lengthMenu: [50, 100, 150, 200, 500, 1000],
                    processing: true,
                    serverSide: true,
                    ajax: 'ss-shilj',
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
                                return '<div class="dropdown"><button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button><div class="dropdown-menu"><a class="dropdown-item" onclick="edit(' + data.student_id + ', 0, 0)"><i class="bx bx-edit-alt me-1"></i> Засварлах</a</div></div>';
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
        </script>
        <?php require ROOT . "/pages/end.php"; ?>