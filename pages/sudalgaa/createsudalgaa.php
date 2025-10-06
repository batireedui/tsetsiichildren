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
                    <h4 class="fw-bold py-3 mb-4">Судалгаа бүртгэх</h4>
                </div>
            </div>
            <div></div>
            <div class="table-responsive text-nowrap">
                <table class="display" id="datalist">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Эцэг/эх-ийн нэр</th>
                            <th>Нэр</th>
                            <th>РД</th>
                            <th>Хүйс</th>
                            <th>Сургууль</th>
                            <th>Анги</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <tr>
                            <th>#</th>
                            <th>Эцэг/эх-ийн нэр</th>
                            <th>Нэр</th>
                            <th>РД</th>
                            <th>Хүйс</th>
                            <th>Сургууль</th>
                            <th>Анги</th>
                            <th></th>
                        </tr>
                    </tbody>
                </table>
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
                    ajax: 'ss-createsudalgaa',
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
                            data: 'gender'
                        },
                        {
                            data: 'school_name'
                        },
                        {
                            data: 'angi'
                        },
                        {
                            data: null,
                            "bSortable": false,
                            "mRender": function(data) {
                                if (data.eseh == null) {
                                    return '<a href="/sudalgaa/insertsudalgaa?id=' + data.student_id + '&angi=' + data.angi_id + '&type=0"><div class="btn btn-warning">Судалгаа бөглөх</div></a>';
                                } else {
                                    return '<a href="/sudalgaa/insertsudalgaa?id=' + data.student_id + '&angi=' + data.angi_id + '&type=1"><div class="btn btn-primary">Засах</div></a>';
                                }

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
        <?php require ROOT . "/pages/end.php"; ?>