<?php require("start.php");
require("header.php");
?>
<!-- / Menu -->
<style>
    .ic {
        font-size: 48px;
    }
</style>
<!-- Layout container -->
<div class="layout-page">
    <!-- Navbar -->

    <?php require("navbar.php");
    $at = "Админ";
    $table = "users";
    $schoolSql = "SUBSTRING('Admin', 1, 5)";
    if ($user_role == "teacher") {
        $table = "teachers";
        $schoolSql = "(SELECT school_name FROM schools WHERE schools.id = school_id)";
        $at = "Багш";
    } else if ($user_role == "najiltan") {
        $table = "najiltans";
        $schoolSql = "(SELECT school_name FROM schools WHERE schools.id = school_id)";
        $at = "Нийгмийн ажилтан";
    }
    $_SESSION['messages'] = ["Хуучин болон шинэ нууц үгээ оруулна"];
    _selectRowNoParam("SELECT fname, lname, phone, email, pass, $schoolSql FROM $table WHERE id = '$user_id'", $fname, $lname, $phone, $email, $pass, $school);

    if (isset($_POST['passchange'])) {
        $passnew = post('newPassword', 100);

        if ($_POST['oldPassword'] == $pass) {
            try {
                $success = _exec(
                    "UPDATE $table SET pass = ? WHERE id='$user_id'",
                    's',
                    [
                        $passnew
                    ],
                    $count
                );

                $_SESSION['messages'] = ["Нууц үг амжилттай солигдлоо. "];
            } catch (Exception $e) {
                $_SESSION['messages'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
                echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
            } finally {
                if (isset($e)) {
                    logError($e);
                }
            }
        } else {
            $_SESSION['messages'] = ["Хуучин нууц үг буруу байна."];
        }
    }
    ?>
    <!-- / Navbar -->
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <!-- User Sidebar -->
            <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
                <!-- User Card -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="user-avatar-section">
                            <div class=" d-flex align-items-center flex-column">
                                <div class="user-info text-center">
                                    <h4 class="mb-2 upper"><?= $_SESSION['user_name'] ?></h4>
                                    <span class="badge bg-label-success"><?= $at ?></span>
                                </div>
                            </div>
                        </div>
                        <h5 class="pb-2 border-bottom mb-4"></h5>
                        <div class="info-container">
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <span class="fw-bold me-2">Эцэг/эх-ийн нэр:</span>
                                    <span class="upper"><?= $fname ?></span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-bold me-2">Нэр:</span>
                                    <span class="upper"><?= $lname ?></span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-bold me-2">Утас:</span>
                                    <span><?= $phone ?></span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-bold me-2">Email:</span>
                                    <span><?= $email ?></span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-bold me-2">Байгууллага:</span>
                                    <span><?= $school ?></span>
                                </li>
                            </ul>
                            <!--
                            <div class="d-flex justify-content-center pt-3">
                                <a href="javascript:;" class="btn btn-primary me-3" data-bs-target="#editUser" data-bs-toggle="modal">Засварлах</a>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
            <!--/ User Sidebar -->


            <!-- User Content -->
            <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
                <div class="card mb-4">
                    <h5 class="card-header">Нууц үг солих</h5>
                    <div class="card-body">
                        <form method="POST" class="fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate">
                            <?php if (isset($_SESSION['messages'])) : ?>
                                <div class="alert alert-danger alert-dismissible" role="alert" id="info">
                                    <?php foreach ($_SESSION['messages'] as $v) {
                                        echo "- $v<br>";
                                    } ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php unset($_SESSION['messages']);
                            endif ?>
                            <div class="row">
                                <div class="mb-3 col-12 col-sm-4 form-password-toggle fv-plugins-icon-container">
                                    <label class="form-label" for="oldPassword">Хуучин нууц үг</label>
                                    <div class="input-group input-group-merge has-validation">
                                        <input class="form-control" type="password" id="oldPassword" name="oldPassword" placeholder="············">
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    </div>
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>

                                <div class="mb-3 col-12 col-sm-4 form-password-toggle fv-plugins-icon-container">
                                    <label class="form-label" for="newPassword">Шинэ нууц үг</label>
                                    <div class="input-group input-group-merge has-validation">
                                        <input class="form-control" type="password" id="newPassword" name="newPassword" onkeyup="checkPass()" placeholder="············">
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    </div>
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>

                                <div class="mb-3 col-12 col-sm-4 form-password-toggle fv-plugins-icon-container">
                                    <label class="form-label" for="confirmPassword">Нууц үгээ давтан оруул</label>
                                    <div class="input-group input-group-merge has-validation">
                                        <input class="form-control" type="password" name="confirmPassword" id="confirmPassword" onkeyup="checkPass()" placeholder="············">
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    </div>
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                                <div>
                                    <input type="submit" id="passchange" name="passchange" class="btn btn-primary me-2" value="Солих"/>
                                </div>
                            </div>
                            <input type="hidden">
                        </form>
                    </div>
                </div>
                <!--/ Change Password -->

                <!-- Recent Devices -->
                <div class="card mb-4">
                    <h5 class="card-header">Таны хандалтын түүх</h5>
                    <div class="table-responsive">
                        <table class="table border-top">
                            <thead>
                                <tr>
                                    <th class="text-truncate">Хэзээ</th>
                                    <th class="text-truncate">IP Хаяг</th>
                                    <th class="text-truncate">Төхөөрөмж</th>
                                </tr>
                            </thead>
                            <tbody><?php
                                    _selectNoParam(
                                        $stmt,
                                        $count,
                                        "SELECT device, hezee, ip FROM loginlog WHERE user_role='$user_role' and userid='$user_id'",
                                        $device,
                                        $hezee,
                                        $ip
                                    );
                                    if ($count > 0) :
                                        while (_fetch($stmt)) :
                                    ?>
                                        <tr>
                                            <td class="text-truncate"><?= $hezee ?></td>
                                            <td class="text-truncate"><?= $ip ?></td>
                                            <td class="text-truncate"><?= $device ?></td>
                                        </tr>
                                    <?php endwhile ?>
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--/ Recent Devices -->
            </div>
            <!--/ User Content -->
        </div>
    </div>
    <!-- Footer -->
    <?php require "footer.php"; ?>
    <script>
        function checkPass() {
            let p1 = $("#newPassword").val();
            let p2 = $("#confirmPassword").val();
            if (p1 === p2) {
                $("#info").html("Нууц үг таарлаа");
                $("#passchange").removeAttr("disabled");
            } else {
                $("#info").html("Нууц үг тохирохгүй байна");
                $("#passchange").attr("disabled", true);
            }
        }
    </script>
    <?php require "end.php"; ?>