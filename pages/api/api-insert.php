<html>

<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            font-size: 3rem;
        }
        .itemtest {
            BACKGROUND-COLOR: #f9f9f9;
            padding: 15px;
            border-radius: 15px;
            margin: 10px;
            border: solid 1px;
        }
    
        .itemded {
            padding: 3rem;
            background: rgb(235, 231, 255);
            border-radius: 10px;
        }
    *,
    *:after,
    *:before {
      box-sizing: border-box;
    }
    
    body {
      font-family: "Inter", sans-serif;
      color: #000021;
      font-size: calc(1em + 1.25vw);
      background-color: #e6e6ef;
    }
    
    form {
      display: flex;
      flex-wrap: wrap;
      flex-direction: column;
    }
    
    .label {
      display: flex;
      cursor: pointer;
      font-weight: 500;
      position: relative;
      overflow: hidden;
      margin-bottom: 0.375em;
      /* Accessible outline */
      /* Remove comment to use */
      /*
      	&:focus-within {
      			outline: .125em solid $primary-color;
      	}
      */
    }
    .label input {
      position: absolute;
      left: -9999px;
    }
    .label input:checked + span {
      background-color: #d6d6e5;
    }
    .label input:checked + span:before {
      box-shadow: inset 0 0 0 0.4375em #00005c;
    }
    .label span {
      display: flex;
      align-items: center;
      padding: 0.375em 0.75em 0.375em 0.375em;
      border-radius: 99em;
      transition: 0.25s ease;
    }
    .label span:hover {
      background-color: #d6d6e5;
    }
    .label span:before {
      display: flex;
      flex-shrink: 0;
      content: "";
      background-color: #fff;
      width: 1.5em;
      height: 1.5em;
      border-radius: 50%;
      margin-right: 0.375em;
      transition: 0.25s ease;
      box-shadow: inset 0 0 0 0.125em #00005c;
    }
    
    
    .labelc {
      display: flex;
      cursor: pointer;
      font-weight: 500;
      position: relative;
      overflow: hidden;
      margin-bottom: 0.375em;
      /* Accessible outline */
      /* Remove comment to use */
      /*
      	&:focus-within {
      			outline: .125em solid $primary-color;
      	}
      */
    }
    .labelc input {
      position: absolute;
      left: -9999px;
    }
    .labelc input:checked + span {
      background-color: #d6d6e5;
    }
    .labelc input:checked + span:before {
      box-shadow: inset 0 0 0 0.4375em #00005c;
    }
    .labelc span {
      display: flex;
      align-items: center;
      padding: 0.375em 0.75em 0.375em 0.375em;
      border-radius: 99em;
      transition: 0.25s ease;
    }
    .labelc span:hover {
      background-color: #d6d6e5;
    }
    .labelc span:before {
      display: flex;
      flex-shrink: 0;
      content: "";
      background-color: #fff;
      width: 1.5em;
      height: 1.5em;
      border-radius: 10%;
      margin-right: 0.375em;
      transition: 0.25s ease;
      box-shadow: inset 0 0 0 0.125em #00005c;
    }
    .button {
        background-color: #0189d3;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 3rem;
        border-radius: 30rem;
        border: 0.1rem solid #044372;
        cursor: pointer;
        margin-bottom: 10rem;
    }
    h3{
        border-bottom: 0.3rem solid #990404;
        padding-bottom: 1rem;
    }
    </style>
</head>
<body>
<?php

$student_id = $_GET["id"];
$angi = $_GET["angi"];
$name = $_GET["name"];
$user_id = $_GET["user_id"];
$school_id = $_GET["school_id"];
_selectRowNoParam(
    "SELECT angis.angi FROM students INNER JOIN angis ON students.angi_id = angis.id WHERE students.id = '$student_id'",
    $angi
);

if ($angi > (int)5) $angi = 1;
else $angi = 0;

$jil = $_SESSION['jil'];

$sql = "";
if ($user_role == "najiltan") {
    $sql = " and students.school_id = $school_id";
} elseif ($user_role == "teacher") {
    $sql = " and students.school_id = $school_id and angis.teacher_id = $user_id";
}
_selectNoParam(
    $stmt,
    $count,
    "SELECT students.id FROM students INNER JOIN angis ON students.angi_id = angis.id WHERE students.tuluv=0 " . $sql,
    $id
);
$students = array();

while (_fetch($stmt)) {
    array_push($students, $id);
}
$check = "";
$check = array_search($student_id, $students);

?>

        <?php if ($check > -1) :

            _selectNoParam(
                $e_stmt,
                $e_count,
                "SELECT value, shalguur_id, shalguurded_id FROM `sudalgaas` WHERE student_id = '$student_id' and jil = '$jil'",
                $e_value,
                $e_shalguur_id,
                $e_shalguurded_id
            );
            $e_sudalgaa = array();
            if ($e_count > 0) {
                while (_fetch($e_stmt)) {
                    array_push($e_sudalgaa, ["value" => $e_value, "e_shalguur_id" => $e_shalguur_id, "e_shalguurded_id" => $e_shalguurded_id]);
                }
            }
            _selectNoParam(
                $stmt,
                $count,
                "SELECT id, name FROM shalguurbuleg WHERE shalguurbuleg.tuluv = 1 ORDER BY shalguurbuleg.id",
                $buleg_id,
                $buleg_name
            );

        ?>      <div class="container">
                    <form action="/api/api-action" method="POST" onsubmit='disableButton()'>
                        <h2><?= $name ?></h2>
                        <input type="text" value="<?= $student_id ?>" name="student_id" style="display: none;" readonly />
                        <input type="text" value="<?= $user_id ?>" name="user_id" style="display: none;" readonly />
                        <input type="text" value="<?= $school_id ?>" name="school_id" style="display: none;" readonly />
                        <?php while (_fetch($stmt)) :
                            $dugaar = 1;
                            _selectNoParam(
                                $qstmt,
                                $qcount,
                                "SELECT shalguurs.id, shalguurs.name, shalguurs.ded, shalguurs.hariulttype, shalguurs.turul FROM `shalguurs` INNER JOIN activeshes ON shalguurs.id = activeshes.shalguur_id WHERE activeshes.turul = '$angi' AND buleg_id = '$buleg_id' AND shalguurs.tuluv = 1 ORDER BY  shalguurs.id",
                                $shalguur_id,
                                $shalguur_name,
                                $shalguur_ded,
                                $hariulttype,
                                $shalguurs_turul
                            ); ?>
                            <div>
                                <h3><?= $buleg_name ?></h3>
                                <?php while (_fetch($qstmt)) {
                                    $eval = 0;
                                    $ededval = 0;
                                    for ($i = 0; $i < count($e_sudalgaa); $i++) {
                                        if ($e_sudalgaa[$i]["e_shalguur_id"] == $shalguur_id) {
                                            $eval = $e_sudalgaa[$i]["value"];
                                            $ededval = $e_sudalgaa[$i]["e_shalguurded_id"];
                                        }
                                    }
                                    echo "<div class='itemtest'><div style='font-weight: bold; margin-bottom: 1rem'>$dugaar). $shalguur_name</div>";
                                    if ($shalguurs_turul == '0') {
                                        if ($shalguur_ded == '1') {
                                            echo "<label class='label'>
                                                      <input type='radio' name='hariult$shalguur_id' value='1***' onclick=\"HideShow($shalguur_id, 1)\" required>
                                                      <span>Тийм</span>
                                                  </label>";
                                            _selectNoParam(
                                                $dstmt,
                                                $dcount,
                                                "SELECT id, name, turul FROM `shalguurdeds` WHERE shalguur_id = '$shalguur_id' AND tuluv = 1",
                                                $ded_id,
                                                $ded_name,
                                                $ded_turul
                                            );
                                            
                                            if ($hariulttype == '0') {
                                                echo "<div class='itemded' style='display: none' id='deddiv$shalguur_id'><strong>Доорх сонголтоос сонголт хийнэ</strong>";
                                                while (_fetch($dstmt)) {
                                                    echo "<label class='label'>
                                                              <input data-dedradio='dedradio$shalguur_id' type='radio' name='hariult$shalguur_id-1' value='$ded_id'>
                                                              <span>$ded_name</span>
                                                          </label>";
                                                }
                                            } else if ($hariulttype == '1') {
                                                echo "<div class='itemded' style='display: none' id='deddiv$shalguur_id'><strong>Доорх сонголтоос сонголт хийнэ (Олон сонголт хийх боломжтой.)</strong>";
                                                while (_fetch($dstmt)) {
                                                    echo "<label class='labelc'>
                                                              <input data-dedradio='dedradio$shalguur_id' type='checkbox' onclick=checkHandle(\"dedmulti$shalguur_id-[]\") name='dedmulti$shalguur_id-[]' value='$ded_id'>
                                                              <span>$ded_name</span>
                                                          </label>";
                                                }
                                            }
                                            echo "</div>";
                                        } else {
                                            echo "<label class='label'>
                                                    <input type='radio' name='hariult$shalguur_id' value='1' onclick=\"HideShow($shalguur_id, 1)\" required>
                                                     <span>Тийм</span>
                                                </label>";
                                        }
                                        echo "<label class='label'>
                                                      <input type='radio' name='hariult$shalguur_id' value='0' onclick=\"HideShow($shalguur_id, 0)\">
                                                      <span>Үгүй</span>
                                                  </label>";
                                    } else if ($shalguurs_turul == '1') {
                                        $qtype = "radio";
                                        if ($hariulttype == '1') $qtype = "checkbox";
                                        _selectNoParam(
                                            $dstmt,
                                            $dcount,
                                            "SELECT id, name, turul FROM `shalguurdeds` WHERE shalguur_id = '$shalguur_id' AND tuluv = 1",
                                            $ded_id,
                                            $ded_name,
                                            $ded_turul
                                        );
                                        echo "<div style='padding: 10px'><div class='checkbox-group required'>";
                                        while (_fetch($dstmt)) {
                                            echo "<label class='label'>
                                                      <input type='$qtype' name='olon$shalguur_id-[]' onclick=checkHandle(\"olon$shalguur_id-[]\") value='$ded_id' required>
                                                      <span>$ded_name</span>
                                                  </label>";
                                        }
                                        echo "</div></div>";
                                    }
                                    $dugaar++;
                                    echo "</div>";
                                } ?>
                            </div>
                        <?php endwhile; ?>
                        <div><input id="sudalgaa_add" class="button" type="submit" value="ХАДГАЛАХ" style="width: 100%;" name="sudalgaa_add" /></div>
                    </form>
                     </div>
                    </body>
                    
        <?php endif; ?>
        <script src="/assets/vendor/libs/jquery/jquery.js"></script>
        <script type="text/javascript">
            function disableButton() {
                var btn = document.getElementById('sudalgaa_add');
                btn.disabled = true;
                btn.value = 'Түр хүлээнэ үү...'
            }

            function checkHandle(v) {
                let matches = document.querySelectorAll("[name='" + v + "']");
                let checkBool = false;
                for (let i = 0; i < matches.length; i++) {
                    if (matches[i].checked === true) {
                        checkBool = true;
                        break;
                    }
                }
                if (checkBool === false) {
                    for (let i = 0; i < matches.length; i++) {
                        matches[i].setAttribute('required', '')
                    }
                } else {
                    for (let i = 0; i < matches.length; i++) {
                        matches[i].removeAttribute('required')
                    }
                }
            };

            function HideShow(v, t) {
                let matches = document.querySelectorAll("[data-dedradio='dedradio" + v + "']");

                if (t) {
                    $('#deddiv' + v).css("display", "");
                    if (matches.length > 0)
                        matches[0].setAttribute('required', '');
                } else {
                    for (let i = 0; i < matches.length; i++) {
                        matches[i].checked = false;
                    }
                    $('#deddiv' + v).css("display", "none");
                    if (matches.length > 0)
                        matches[0].removeAttribute('required')
                }
            }
        </script>
        </html>