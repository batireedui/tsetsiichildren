<?php
// phone, userpassword хүлээж авна
$email = trim(post('email', 100));
$password = trim(post('password', 100));
$user_role = trim(post('role', 10));
// Алдааг хадгалах массив үүсгэнэ
$errors = [];

// Хэрэв phone password алдаатай бол алдааг session-д бичээд логин хуудас руу үсэргэнэ
if (sizeof($errors) > 0) {
    $_SESSION['errors'] = $errors;
    redirect('/login');
}
if ($user_role == "admin") {
    _selectRow(
        "select id, concat(lname, ' ', fname), email from users where email=? and pass=?",
        'ss',
        [$email, $password],
        $user_id,
        $user_name,
        $user_email
    );
}
else if ($user_role == "najiltan") {
    _selectRow(
        "select id, concat(fname, ' ', lname), email, school_id from najiltans where email=? and pass=?",
        'ss',
        [$email, $password],
        $user_id,
        $user_name,
        $user_email,
        $school_id
    );
}
else if ($user_role == "teacher") {
    _selectRow(
        "select id, concat(fname, ' ', lname), email, school_id from teachers where email=? and pass=?",
        'ss',
        [$email, $password],
        $user_id,
        $user_name,
        $user_email,
        $school_id
    );
}
if (!empty($user_id)) {
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $success = _exec("insert into loginlog(user, hezee, email, userid, user_role, device, ip) VALUES(?, ?, ?, ?, ?, ?, ?)",
    'sssisss',
    [$user_name, ognoo(), $user_email, $user_id, $user_role, $user_agent, getIpAddress()],
    $count);
    
    $_SESSION['user_id'] = $user_id;
    $_SESSION['user_name'] = $user_name;
    $_SESSION['user_email'] = $user_email;
    $_SESSION['user_role'] = $user_role;
    $_SESSION['errors'] = "";

    if ($user_role == "admin") {
        $_SESSION['school_id'] = "";
    } else {
        $_SESSION['school_id'] = $school_id;
    }
    redirect('/');
} else {
    $_SESSION['errors'] = ["Таны нэвтрэх нэр эсвэл нууц үг буруу байна"];
    if ($user_role == "admin") {
        redirect('/adminpanel/login');
    } else if ($user_role == "najiltan") {
        redirect('/school/login');
    } else if ($user_role == "teacher") {
        redirect('/teacher/login');
    }
}
