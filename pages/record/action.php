<?php
if (isset($_POST['schooladd'])) {
    $school_name = post('school_name', 300);
    $sum = post('sum', 255);
    $director = post('director', 300);
    $phone = post('phone', 300);
    try {
        $success = _exec(
            "insert into schools (school_name, `sum`, director, phone, tuluv, created_at, updated_at) values (?, ?, ?, ?, ?, ?, ?)",
            'sssssss',
            [$school_name, $sum, $director, $phone, "0", ognoo(), ognoo()],
            $count
        );
    } catch (Exception $e) {
        $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
        // echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
    } finally {
        if (isset($e)) {
            logError($e);
        }
    }
    redirect("/school/school");
} else if (isset($_POST['schooledit'])) {
    $id = post('eschool_id', 10);
    $school_name = post('eschool_name', 300);
    $sum = post('esum', 255);
    $director = post('edirector', 300);
    $phone = post('ephone', 300);
    try {
        $success = _exec(
            "UPDATE schools SET school_name=?, `sum`=?, director=?, phone=?, updated_at=? WHERE id=?",
            'sssssi',
            [$school_name, $sum, $director, $phone, ognoo(), $id],
            $count
        );
    } catch (Exception $e) {
        $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
        // echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
    } finally {
        if (isset($e)) {
            logError($e);
        }
    }
    redirect("/school/school");
} else if (isset($_POST['schooldelete'])) {
    /*$id = post('dschool_id', 10);
    try {
        $success = _exec(
            "DELETE FROM schools WHERE id=?",
            'i',
            [$id],
            $count
        );
    } catch (Exception $e) {
        $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
        // echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
    } finally {
        if (isset($e)) {
            logError($e);
        }
    }*/
    redirect("/school/school");
} else if (isset($_POST['teacherdelete'])) {
    $id = post('teacher_id', 10);
    try {
        $success = _exec(
            "UPDATE teachers SET tuluv ='1' WHERE id=?", //"DELETE FROM teachers WHERE id=?",
            'i',
            [$id],
            $count
        );
         $_SESSION['messages'] = ["Амжилттай устгагдлаа."];
    } catch (Exception $e) {
        $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
        // echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
    } finally {
        if (isset($e)) {
            logError($e);
        }
    }
    redirect("/teacher/list");
} else if (isset($_POST['teacheradd'])) {
    $fname = post('fname', 300);
    $lname = post('lname', 300);
    $gender = post('gender', 255);
    $email = post('email', 300);
    $phone = post('phone', 300);
    $rd = post('rd', 20);
    $school = post('school', 10);
    $pass = post('pass', 300);
    $mergejil = post('mergejil', 500);
    $jil= post('jil', 10);

    $stoo = 0;
    $emailtoo = 0;
    _selectRowNoParam(
        "SELECT count(id) FROM teachers WHERE rd = '$rd'",
        $stoo
    );
    _selectRowNoParam(
        "SELECT count(id) FROM teachers WHERE email = '$email'",
        $emailtoo
    );
    if($stoo > 0){
        $_SESSION['messages'] = ["Өөр сургуульд бүртгэлтэй байна."];
    }
    else if($emailtoo > 0){
        $_SESSION['messages'] = ["Email хаяг бүртгэлтэй байна."];
    }
    else {
        try {
            $success = _exec(
                "INSERT INTO teachers(fname, lname, gender, email, phone, rd, school_id, pass, tuluv, updated_at, mergejil, jil) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
                'ssssssisisss',
                [$fname, $lname, $gender, $email, $phone, $rd, $school, $pass, 0, ognoo(), $mergejil, $jil],
                $count
            );
            $_SESSION['messages'] = ["Амжилттай бүртгэгдлээ."];
        } catch (Exception $e) {
            $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
             //echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
        } finally {
            if (isset($e)) {
                logError($e);
            }
    }
    }
    redirect("/teacher/list");
} else if (isset($_POST['teacheredit'])) {
    $id = post('eteacher_id', 10);
    $fname = post('efname', 300);
    $lname = post('elname', 300);
    $gender = post('egender', 255);
    $email = post('eemail', 300);
    $phone = post('ephone', 300);
    $rd = post('erd', 20);
    $school = post('eschool', 10);
    $mergejil = post('emergejil', 150);
    $jil = post('ejil', 150);
    $pass = post('epass', 300);
    try {
        $success = _exec(
            "UPDATE teachers SET fname=?, lname=?, gender=?, email=?, phone=?, rd=?, school_id=?, pass=?, updated_at=?, tuluv=?, mergejil=?, jil=? WHERE id=?",
            'ssssssississi',
            [$fname, $lname, $gender, $email, $phone, $rd, $school, $pass, ognoo(), 0, $mergejil, $jil, $id],
            $count
        );
        $_SESSION['messages'] = ["Мэдээлэл засагдлаа."];
    } catch (Exception $e) {
        $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
        // echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
    } finally {
        if (isset($e)) {
            logError($e);
        }
    }
    redirect("/teacher/list");
} else if (isset($_POST['najiltandelete'])) {
    $id = post('najiltan_id', 10);
    try {
        $success = _exec(
            "UPDATE najiltans SET tuluv ='1' WHERE id=?", //"DELETE FROM najiltans WHERE id=?",
            'i',
            [$id],
            $count
        );
        $_SESSION['messages'] = ["Мэдээлэл устгагдлаа."];
    } catch (Exception $e) {
        $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
        // echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
    } finally {
        if (isset($e)) {
            logError($e);
        }
    }
    redirect("/najiltan/list");
} else if (isset($_POST['najiltanadd'])) {
    //print_r($_POST);
    $fname = post('fname', 300);
    $lname = post('lname', 300);
    $gender = post('gender', 255);
    $email = post('email', 300);
    $phone = post('phone', 300);
    $rd = post('rd', 20);
    $school = post('school', 10);
    $pass = post('pass', 300);
    try {
        $success = _exec(
            "INSERT INTO najiltans(fname, lname, gender, email, phone, rd, school_id, pass, tuluv, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
            'ssssssisiss',
            [$fname, $lname, $gender, $email, $phone, $rd, $school, $pass, '0', ognoo(), ognoo()],
            $count
        );
        $_SESSION['messages'] = ["Мэдээлэл бүртгэгдлээ."];
    } catch (Exception $e) {
        $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
         echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
    } finally {
        if (isset($e)) {
            logError($e);
        }
    }
    redirect("/najiltan/list");
} else if (isset($_POST['najiltanedit'])) {
    $id = post('enajiltan_id', 10);
    $fname = post('efname', 300);
    $lname = post('elname', 300);
    $gender = post('egender', 255);
    $email = post('eemail', 300);
    $phone = post('ephone', 300);
    $rd = post('erd', 20);
    $school = post('eschool', 10);
    $pass = post('epass', 300);
    try {
        $success = _exec(
            "UPDATE najiltans SET fname=?, lname=?, gender=?, email=?, phone=?, rd=?, school_id=?, pass=?, updated_at=? WHERE id=?",
            'ssssssissi',
            [$fname, $lname, $gender, $email, $phone, $rd, $school, $pass, ognoo(), $id],
            $count
        );
        $_SESSION['messages'] = ["Мэдээлэл засагдлаа."];
    } catch (Exception $e) {
        $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
        // echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
    } finally {
        if (isset($e)) {
            logError($e);
        }
    }
    redirect("/najiltan/list");
} else if (isset($_POST['angiadd'])) {
    $angi = post('class', 300);
    $buleg = post('buleg', 255);
    $school_id = post('school', 300);
    $teacher_id = post('teacher', 300);
    try {
        $success = _exec(
            "INSERT INTO angis(name, angi, buleg, tuluv, school_id, teacher_id, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
            'sisiiiss',
            ['', $angi, $buleg, '0', $school_id, $teacher_id, ognoo(), ognoo()],
            $count
        );
        $_SESSION['messages'] = ["Анги бүртгэгдлээ."];
    } catch (Exception $e) {
        $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
        // echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
    } finally {
        if (isset($e)) {
            logError($e);
        }
    }
    redirect("/angilist");
} else if (isset($_POST['angiedit'])) {
    $angi_id = post('eangi_id', 10);
    $angi = post('eclass', 300);
    $buleg = post('ebuleg', 255);
    $school_id = post('eschool', 300);
    $teacher_id = post('eteacher', 300);
    try {
        $success = _exec(
            "UPDATE angis SET name=?, angi=?, buleg=?, tuluv=?, school_id=?, teacher_id=?, updated_at=? WHERE id = ?",
            'sisiiisi',
            ['', $angi, $buleg, '0', $school_id, $teacher_id, ognoo(), $angi_id],
            $count
        );
        $_SESSION['messages'] = ["Анги засагдлаа."];
    } catch (Exception $e) {
        $_SESSION['messages'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
        // echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
    } finally {
        if (isset($e)) {
            logError($e);
        }
    }
    redirect("/angilist");
} else if (isset($_POST['angidelete'])) {
    $id = post('dangi_id', 10);
    _selectRowNoParam(
        "SELECT count(id) FROM students WHERE angi_id = '$id'",
        $stoo
    );
    if($stoo > 0){
        $_SESSION['messages'] = ["Ангид сурагч бүртгэлтэй байна. Иймд утсгах боломжгүй."];
    }
    else{
        try {
            $success = _exec(
                "DELETE FROM angis WHERE id=?",
                'i',
                [$id],
                $count
            );
            $_SESSION['messages'] = ["Анги устгагдлаа."];
        } catch (Exception $e) {
            $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
            // echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
        } finally {
            if (isset($e)) {
                logError($e);
            }
        }
    }
    redirect("/angilist");
} else if (isset($_POST['studentdelete'])) {
    $id = post('s_id', 10);
    _selectRowNoParam(
        "SELECT count(student_id) FROM sudalgaas WHERE student_id = '$id'",
        $stoo
    );
    if($stoo > 0){
        $_SESSION['messages'] = ["Сурагч судалгаанд хамрагдсан тул устгах боомжгүй байна."];
    }
    else {
        try {
            $success = _exec(
                "DELETE FROM students WHERE id=?",
                'i',
                [$id],
                $count
            );
        } catch (Exception $e) {
            $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
            // echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
        } finally {
            if (isset($e)) {
                logError($e);
            }
        }
    }
    redirect("/students/list");
} else if (isset($_POST['studentadd'])) {
    $fname = post('ovog', 300);
    $lname = post('ner', 255);
    $gender = post('gender', 300);
    $phone = post('utas', 300);
    $rd = post('rd', 300);
    $school_id = post('school', 300);
    $angi_id = post('class', 300);
    
    $hayg = post('hayg', 300);
    $ohayg = post('ohayg', 300);
    $club= post('club', 300);
    $hentei = post('hentei', 300);
    $dsects = post('dsects', 300);


    try {
        $success = _exec(
            "INSERT INTO students(fname, lname, gender, phone, rd, school_id, angi_id, created_at, tuluv, hayg, ohayg, hentei, dsects, club) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
            'sssssiisisssss',
            [$fname, $lname, $gender, $phone, $rd, $school_id, $angi_id, ognoo(), '0', $hayg, $ohayg, $hentei, $dsects, $club],
            $count
        );
    } catch (Exception $e) {
        $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
        // echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
    } finally {
        if (isset($e)) {
            logError($e);
        }
    }
    redirect("/students/list");
} else if (isset($_POST['studentedit'])) {
    $fname = post('eovog', 300);
    $lname = post('ener', 255);
    $gender = post('egender', 300);
    $phone = post('eutas', 300);
    $rd = post('erd', 300);
    $school_id = post('eschool', 10);
    $angi_id = post('eclass', 10);
    $edit_id = post('edit_id', 10);
    
    $hayg = post('ehayg', 300);
    $ohayg = post('eohayg', 300);
    $club= post('eclub', 300);
    $hentei = post('ehentei', 300);
    $dsects = post('edsects', 300);
    
    try {
        $success = _exec(
            "UPDATE students SET fname=?, lname=?, gender=?, phone=?, rd=?, school_id=?, angi_id=?, created_at=?, hayg=?, ohayg=?, hentei=?, dsects=?, club=?, tuluv=? WHERE id = ?",
            'sssssiissssssii',
            [$fname, $lname, $gender, $phone, $rd, $school_id, $angi_id, ognoo(), $hayg, $ohayg, $hentei, $dsects, $club, "0", $edit_id],
            $count
        );
    } catch (Exception $e) {
        $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
        // echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
    } finally {
        if (isset($e)) {
            logError($e);
        }
    }
    redirect("/students/list");
} else if (isset($_POST['shangilaladd'])) {
    $angilal = post('angilal', 300);
    try {
        $success = _exec(
            "INSERT INTO shalguurbuleg(name, tuluv) VALUES (?, '0')",
            's',
            [$angilal],
            $count
        );
    } catch (Exception $e) {
        $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
        // echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
    } finally {
        if (isset($e)) {
            logError($e);
        }
    }
    redirect("/shalguurlist");
} else if (isset($_POST['shangilaledit'])) {
    $angilal = post('eangilal', 300);
    $id = post('eid', 10);
    try {
        $success = _exec(
            "UPDATE shalguurbuleg SET name=? WHERE id=?",
            'si',
            [$angilal, $id],
            $count
        );
    } catch (Exception $e) {
        $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
        // echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
    } finally {
        if (isset($e)) {
            logError($e);
        }
    }
    redirect("/shalguurlist");
} else if (isset($_POST['bulegdelete'])) {
    /*$dbuleg_id = post('dbuleg_id', 300);
    try {
        $success = _exec(
            "DELETE FROM shalguurbuleg WHERE id=?",
            'i',
            [$dbuleg_id],
            $count
        );
        $_SESSION['action'] = "Бүлэг устгагдлаа!";
    } catch (Exception $e) {
        $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
        // echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
    } finally {
        if (isset($e)) {
            logError($e);
        }
    }*/
    redirect("/shalguurlist");
} else if (isset($_POST['shalguuradd'])) {
    $buleg = $_POST['buleg'];
    $shner = $_POST['shner'];
    $hariult = $_POST['hariult'];
    $expand = 0;
    $tuluv = 0;
    $dedturul = 0;
    if ($_POST['expand'] == "on") {
        $expand = 1;
    }
    if ($_POST['tuluv'] == "on") {
        $tuluv = 1;
    }
    if (isset($_POST['dedturul']) == "on") {
        $dedturul = 1;
    }
    try {
        $success = _exec(
            "INSERT INTO shalguurs(buleg_id, name, ded, turul, tuluv, created_at, updated_at, hariulttype) VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
            'isiiissi',
            [$buleg, $shner, $expand, $hariult, $tuluv, ognoo(), ognoo(), $dedturul],
            $count
        );
        $_SESSION['action'] = "Бүлэг устгагдлаа!";
    } catch (Exception $e) {
        $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
        // echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
    } finally {
        if (isset($e)) {
            logError($e);
        }
    }
    redirect("/shalguurlist");
} else if (isset($_POST['shalguuredit'])) {
    $id = $_POST['id'];
    $buleg = $_POST['buleg'];
    $shner = $_POST['shner'];
    $hariult = $_POST['hariult'];
    $expand = 0;
    $tuluv = 0;
    $dedturul = 0;
    if (isset($_POST['expand']) == "on") {
        $expand = 1;
    }
    if (isset($_POST['tuluv']) == "on") {
        $tuluv = 1;
    }
    if (isset($_POST['dedturul']) == "on") {
        $dedturul = 1;
    }
    $success = _exec(
        "UPDATE shalguurs SET buleg_id=?, name=?, ded=?, turul=?, tuluv=?, updated_at=?, hariulttype=? WHERE id = ?",
        'isiiisii',
        [$buleg, $shner, $expand, $hariult, $tuluv, ognoo(), $dedturul, $id],
        $count
    );
    redirect("/shalguurlist");
} else if (isset($_POST['shalguurdelete'])) {
    /*$dbuleg_id = post('dangi_id', 300);
    try {
        $success = _exec(
            "DELETE FROM shalguurs WHERE id=?",
            'i',
            [$dbuleg_id],
            $count
        );
        $_SESSION['action'] = "Бүлэг устгагдлаа!";
    } catch (Exception $e) {
        $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
        // echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
    } finally {
        if (isset($e)) {
            logError($e);
        }
    }*/
    redirect("/shalguurlist");
} else if (isset($_POST['studentshilj'])) {

    $id = post('sh_id', 300);
    $schoolid = post('sh_sid', 300);
    $angi_sh = post('angi_sh', 300);
    $tailbar = post('tailbar', 300);
    try {
        
        $success = _exec(
            "INSERT INTO shilj(school_id, angi, hezee, tailbar, user_type, user_id, student_id, jil) VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
            'issssiis',
            [$schoolid, $angi_sh, ognooday(), $tailbar, $_SESSION['user_role'], $_SESSION['user_id'], $id, $_SESSION['jil']],
            $count
        );
        
        $success = _exec(
            "UPDATE students SET school_id=?, angi_id = ?, tuluv=? WHERE id=?",
            'iiii',
            ["0", "0", "1" , $id],
            $count
        );
        $_SESSION['messages'] = ["Амжилттай шилжилт хийгдлээ."];
       
    } catch (Exception $e) {
         //echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
    } finally {
        if (isset($e)) {
            logError($e);
        }
    }
    redirect("/students/list");
} else if (isset($_POST['asranadd'])) {

    $ard = post('asid', 20);
    
    $as_ovog = post('as_ovog', 300);
    $as_ner = post('as_ner', 300);
    $as_bol = post('as_bol', 300);
    $as_ajil = post('as_ajil', 300);
    $as_hbe = post('as_hbe', 300);
    $as_sohe = post('as_sohe', 300);
    $as_mun = post('as_mun', 300);
    $as_utas = post('as_utas', 300);
    
    $as_eovog = post('as_eovog', 300);
    $as_ener = post('as_ener', 300);
    $as_ebol = post('as_ebol', 300);
    $as_eajil = post('as_eajil', 300);
    $as_ehbe = post('as_ehbe', 300);
    $as_esohe = post('as_esohe', 300);
    $as_emun = post('as_emun', 300);
    $as_eutas = post('as_eutas', 300);
    try {
        $success = _exec(
            "DELETE FROM asran WHERE student_id=?",
            'i',
            [$ard],
            $count
        );
        
        $success = _exec(
            "INSERT INTO asran(student_id, ovog, ner, bolovsrol, ajil, hbe, sohe, mun, utas, eovog, ener, ebolovsrol, eajil, ehbe, esohe, emun, eutas) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
            'issssssssssssssss',
            [$ard, $as_ovog, $as_ner, $as_bol, $as_ajil, $as_hbe, $as_sohe, $as_mun, $as_utas, $as_eovog, $as_ener, $as_ebol, $as_eajil, $as_ehbe, $as_esohe, $as_emun, $as_eutas],
            $count
        );
        $_SESSION['messages'] = ["Амжилттай бүртгэгдлээ."];
       
    } catch (Exception $e) {
         //echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
    } finally {
        if (isset($e)) {
            logError($e);
        }
    }
    redirect("/students/list");
} else if (isset($_POST['studentgracancel'])) {

    $id = post('sh_sid', 300);
    try {
            $success = _exec(
            "UPDATE students SET tuluv=? WHERE id=?",
            'ii',
            ["0" , $id],
            $count
        );
        $_SESSION['messages'] = ["Амжилттай хасалт хийгдлээ."];
       
    } catch (Exception $e) {
         //echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
    } finally {
        if (isset($e)) {
            logError($e);
        }
    }
    redirect("/students/gra");
}