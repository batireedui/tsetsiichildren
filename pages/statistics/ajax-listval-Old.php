<?php
$val = "";
$h_jil = $_SESSION['jil'];
$school_id = $_SESSION['school_id'];
$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['user_role'];
$jil = $_POST['jil'];

$table = "sudalgaas";

if($jil != $h_jil){
    $table = $table . substr($jil, 0, 4);
}

$sql = "";

if($user_role == "najiltan"){
    $sql = " and schools.school_id = '$school_id' ";
}

$vsql = "";

if($user_role == "najiltan"){
    $vsql = " and school_id = '$school_id' ";
}
else if($user_role == "teacher"){
    _selectNoParam(
        $st,
        $co,
        "SELECT id FROM angis WHERE teacher_id = '$user_id' and school_id = '$school_id'",
         $angi_id
    );
    
    if (isset($co) > 0) {
        $atoo = 1;
        while (_fetch($st)){
            if($atoo == 1) $vsql = $vsql . " and (";
            $vsql = $vsql . " students.angi_id = '$angi_id' ";
            if($atoo < $co){
                $vsql = $vsql . " or ";
            }
            if($atoo == $co){
                $vsql = $vsql . ")";
            }
            $a++;
        }
    }
}

if ($_POST["type"] == "valget") {
    $pid = $_POST["id"];
    $myObj = new stdClass();
    $schools = new stdClass();
    _selectNoParam(
        $sstmt,
        $scount,
        "SELECT (SELECT COUNT(distinct student_id) FROM `$table` 
            INNER JOIN students ON $table.student_id = students.id 
            WHERE shalguur_id = '$pid' $vsql), 
        (SELECT COUNT(distinct student_id) FROM `$table` 
            INNER JOIN students ON $table.student_id = students.id 
            WHERE shalguur_id = '$pid' and value = 1  $vsql)",
        $too,
        $yes
    );
    while (_fetch($sstmt)) {
        //array_push($val, [$too, $yes, $no]);
        $val .= "<div class='btn btn-outline-secondary' style='margin: 10px'>Судалгаа бөглөсөн: $too</div><div class='btn btn-outline-danger' style='margin: 10px' onclick='itemGet($pid, 1)'>Тийм: $yes</div>";
    }
    
    _selectNoParam(
        $sstmts,
        $scounts,
        "SELECT COUNT(distinct student_id), school_id, schools.school_name FROM `$table` INNER JOIN students ON $table.student_id = students.id INNER JOIN schools ON students.school_id = schools.id WHERE `value` = 1 AND shalguur_id = '$pid' $vsql GROUP BY school_id",
        $stoo,
        $sid,
        $sname
    );
    $sstoo = [];
    $ssname= [];
    while (_fetch($sstmts)) {
        //$sstoo[] = array("stoo"=>$stoo,"sid"=>$sid,"sname"=>$sname);
        array_push($sstoo, $stoo);
        array_push($ssname, $sname);
    }
    
    $myObj->val = $val;
    $myObj->sstoo = $sstoo;
    $myObj->ssname = $ssname;
    $data = json_encode($myObj);
    echo $data;
}

if ($_POST["type"] == "itemvalget") {
    $pid = $_POST["id"];
    $getval = $_POST["getval"];
    _selectRowNoParam(
        "SELECT name FROM shalguurs WHERE id = '$pid'",
        $name1
    );
    _selectNoParam(
        $sstmt,
        $scount,
        "SELECT shalguur_id, name, count(distinct student_id) FROM `$table` 
            INNER JOIN shalguurs ON $table.shalguur_id = shalguurs.id 
            WHERE value='1' and 
            student_id IN (SELECT DISTINCT student_id FROM `$table` INNER JOIN students ON $table.student_id = students.id WHERE shalguur_id = '$pid' and value='1' $vsql) GROUP BY shalguur_id",
        //"SELECT COUNT(student_id), shalguur_id, shalguurs.name, value FROM `$table` INNER JOIN shalguurs ON $table.shalguur_id = shalguurs.id WHERE student_id IN (SELECT DISTINCT student_id FROM `$table` WHERE shalguur_id = '$pid' and value = '$getval') GROUP BY shalguur_id",
        $shalguur_id,
        $name,
        $too
    );
    $tempName = "";
    while (_fetch($sstmt)) {
        if ($tempName == $shalguur_id) {
                $val .= "<a href='/statistics/stcompare-list?id=$shalguur_id&ids=$pid&name=$name&jil=$jil'><button class='btn btn-outline-danger' style='margin: 10px'>Тийм: $too</button></a><br>";
        } else {
            /*if ($value == "0") {
                $val .= "<div>Шалгуур: <span style='font-weight: bold'>$name</span></div><button class='btn btn-outline-primary' style='margin: 10px'>Үгүй: $too</button>";
            } else {*/
                $val .= "<tr><td><div>Шалгуур: <span style='font-weight: bold'>$name</span></div></td><td><a href='/statistics/stcompare-list?id=$shalguur_id&ids=$pid&name=$name&name1=$name1&jil=$jil'><button class='btn btn-outline-danger' style='margin: 10px'>Тийм: $too</button></a></td></tr>";
            //}
        }
        $tempName = $shalguur_id;
    }
    echo "<table class='table'>" . $val ."</table>";
    //echo json_encode($val);
}
/*
if ($_POST["type"] == "itemvalget") {
    $pid = $_POST["id"];
    $getval = $_POST["getval"];
    _selectNoParam(
        $sstmt,
        $scount,
        "SELECT shalguur_id, name, count(student_id), value FROM `$table` INNER JOIN shalguurs ON $table.shalguur_id = shalguurs.id WHERE student_id IN (SELECT DISTINCT student_id FROM `$table` INNER JOIN students ON $table.student_id = students.id WHERE students.school_id='$school_id' and shalguur_id = '$pid' and value='1') GROUP BY shalguur_id, value",
        //"SELECT COUNT(student_id), shalguur_id, shalguurs.name, value FROM `$table` INNER JOIN shalguurs ON $table.shalguur_id = shalguurs.id WHERE student_id IN (SELECT DISTINCT student_id FROM `$table` WHERE shalguur_id = '$pid' and value = '$getval') GROUP BY shalguur_id",
        $shalguur_id,
        $name,
        $too,
        $value
    );
    $tempName = "";
    while (_fetch($sstmt)) {
        if ($tempName == $shalguur_id) {
                $val .= "<a href='/statistics/stcompare-list?id=$shalguur_id&ids=$pid&name=$name'><button class='btn btn-outline-danger' style='margin: 10px'>Тийм: $too</button></a><br>";
        } else {
            if ($value == "0") {
                $val .= "<div>Шалгуур: <span style='font-weight: bold'>$name</span></div><button class='btn btn-outline-primary' style='margin: 10px'>Үгүй: $too</button>";
            } else {
                $val .= "<div>Шалгуур: <span style='font-weight: bold'>$name</span></div><a href='/statistics/stcompare-list?id=$shalguur_id&ids=$pid&name=$name'><button class='btn btn-outline-danger' style='margin: 10px'>Тийм: $too</button></a>";
            }
        }
        $tempName = $shalguur_id;
    }
    echo $val;
    //echo json_encode($val);
}

/*
_selectNoParam(
    $sstmt,
    $scount,
    "SELECT value, shalguur_id, shalguurded_id FROM $table WHERE student_id ='2'",
    $value,
    $shalguur_id,
    $shalguurded_id
);
while (_fetch($sstmt)) {
    array_push($val, [$value, $shalguur_id, $shalguurded_id]);
}
for($i = 22997; $i<22999; $i++){
        $success = _exec(
            "DELETE FROM $table WHERE student_id = ?",
            'i',
            [$i],
            $count
        );
foreach($val as $v)
    {
       
        $success = _exec(
            "INSERT INTO $table(student_id, teacher_id, user_type, value, shalguur_id, shalguurded_id, jil, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
            'iisiiisss',
            [$i, '1', 'admin', $v[0], $v[1], $v[2], '2022-2023', ognoo(), ognoo()],
            $count
        );
    }
    echo $i. "   ";
}*/