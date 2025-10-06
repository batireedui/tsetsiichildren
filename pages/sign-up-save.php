<?php
$username = trim(post('username', 100));
$userpassword = trim(post('userpassword', 100));

// Алдаануудыг хадгалах массив
$errors = "Алдаа гарлаа!";

if(is_numeric($username))
{
// Ийм утастай хэрэглэгч бүртгэлтэй эсэх
    _select(
        $stmt, $count,
        "select count(*) from wp_users where user_phone=?",
        's',
        [$username],
        $numberOfPhone
    );
    
    _fetch($stmt);
    
    if ($numberOfPhone > 0) {
        $errors = "$username утасны дугаар аль хэдийн бүртгэлтэй байна.";
    }
}
else if(!filter_var($username, FILTER_VALIDATE_EMAIL)) {
  $errors = "Та email хаяг эсвэл утасны дугаар оруулна уу!";
}
else {
    
    _selectRow(
        "select count(*) from wp_users where user_email=?",
        's',
        [$username],
        $numberOfEmail
    );
    
    if ($numberOfEmail > 0) {
        $errors = "$username имэйл аль хэдийн бүртгэлтэй байна.";
    }
}
if ($errors == "Алдаа гарлаа!") {
    if(is_numeric($username)){
        $success = _exec(
            "insert into wp_users(user_phone, user_pass) VALUES (?, ?)",
            'ss',
            [$username, $userpassword],
            $count
        );
    }
    else
    {
        $success = _exec(
            "insert into wp_users(user_email, user_pass) VALUES (?, ?)",
            'ss',
            [$username, $userpassword],
            $count
        );
    }
    echo "Амжилттай бүртгэгдлээ та бүртгэлээрээ нэвтэрч орно уу!";
} else {
    echo $errors;
}