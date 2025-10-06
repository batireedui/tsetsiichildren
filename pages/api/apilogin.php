<?php
header('Content-Type: application/json');

$json = file_get_contents('php://input');
$obj = json_decode($json,true);
$email = $obj['email'];
$pass = $obj['password'];
$val = array();
if ($email != "" && $pass!=""){
    _selectRow(
        "select id, fname, lname, email, school_id, phone from teachers where email=? and pass=?",
        'ss',
        [$email, $pass],
        $user_id,
        $fname,
        $lname,
        $user_email,
        $school_id, 
        $phone
    );
    if (!empty($user_id)) 
    {
        _selectRow(
            "select school_name from schools where id=?",
            'i',
            [$school_id],
            $school_name
        );
        $angiList = array();
        _select(
            $stmt,
            $count,
            "select id, angi, buleg from angis where teacher_id=?",
            'i',
            [$user_id],
            $angi_id, $angi, $buleg
        );
        while(_fetch($stmt)){
            array_push($angiList,[$angi_id, $angi, $buleg]);
        }
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $success = _exec("insert into loginlog(user, hezee, email, userid, user_role, device, ip) VALUES(?, ?, ?, ?, ?, ?, ?)",
        'sssisss',
        [$fname." ".$lname, ognoo(), $user_email, $user_id, "teacher", $user_agent, getIpAddress()],
        $count);
        $val = ["user_id"=>$user_id, "fname"=>$fname, "lname"=>$lname, "user_email"=>$user_email, "school_name"=>$school_name, "school_id"=>$school_id, "user_phone"=>$phone, "angiList"=>$angiList];
    }
    else {
    $val = ["Таны нэвтрэх нэр эсвэл нууц үг буруу байна"];
    }
    
}
else {
    $val = ["nodata".$email.$pass];
}
$json = json_encode([$val]);
echo $json;