<?php
if (isset($_POST['student_id']) && isset($_POST['user_id'])) {
    $posts = $_POST;
    $student_id = $posts["student_id"];
    $user_role = "teacher";
    $user_id = $posts["user_id"];
    $school_id = $posts["school_id"];
    
    unset($posts["student_id"]);
    unset($posts["user_id"]);
    unset($posts["school_id"]);
    $too = count($posts);
    if ($too > 0) {
        
        _selectRowNoParam(
            "SELECT angi FROM `angis` INNER JOIN students ON angis.id = students.angi_id WHERE students.id = '$student_id'", $angi);
        
        try {
            $success = _exec(
                "DELETE FROM sudalgaas WHERE student_id = ? and jil=? and created_at < ?",
                'iss',
                [$student_id, $_SESSION['jil'], ognoo()],
                $count
            );
        } catch (Exception $e) {
             echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
        } finally {
            if (isset($e)) {
                logError($e);
            }
        }
        foreach ($posts as $key => $value) {
            if (@strpos($value, "***") > -1) {
            } else {
                if (strpos($key, "hariult") > -1) {
                    $sh_id = substr($key, 7, strlen($key));
                    $dedval = 0;
                    $shval = $value;
                    if (strpos($sh_id, "-") > -1) {
                        $sh_id = substr($sh_id, 0, strpos($sh_id, "-"));
                        $shval = 1;
                        $dedval = $value;
                    }
                    //echo $sh_id . " " . $shval . " " . $dedval . "<br>";
                    try {
                        $success = _exec(
                            "INSERT INTO sudalgaas(student_id, teacher_id, user_type, value, shalguur_id, shalguurded_id, jil, created_at, angi) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
                            'iisiiissi',
                            [$student_id, $user_id, $user_role, $shval, $sh_id, $dedval, $_SESSION['jil'], ognoo(), $angi],
                            $count
                        );
                    } catch (Exception $e) {
                         echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
                    } finally {
                        if (isset($e)) {
                            logError($e);
                        }
                    }
                } else if (strpos($key, "olon") > -1) {
                    $sh_id = substr($key, 4, strlen($key) - 5);
                    foreach ($value as $okey => $ovalue) {
                        //echo $sh_id . " - " . $ovalue . "<br>";
                        try {
                            $success = _exec(
                                "INSERT INTO sudalgaas(student_id, teacher_id, user_type, value, shalguur_id, shalguurded_id, jil, created_at, angi) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
                                'iisiiissi',
                                [$student_id, $user_id, $user_role, "1", $sh_id, $ovalue, $_SESSION['jil'], ognoo(), $angi],
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
                    }
                } else if (strpos($key, "dedmulti") > -1) {
                    $sh_id = substr($key, 8, strlen($key) - 9);
                    foreach ($value as $okey => $ovalue) {
                        //echo $sh_id . " - " . $ovalue . "<br>";
                        try {
                            $success = _exec(
                                "INSERT INTO sudalgaas(student_id, teacher_id, user_type, value, shalguur_id, shalguurded_id, jil, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
                                'iisiiissi',
                                [$student_id, $user_id, $user_role, "1", $sh_id, $ovalue, $_SESSION['jil'], ognoo(), $angi],
                                $count
                            );
                        } catch (Exception $e) {
                            // echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
                        } finally {
                            if (isset($e)) {
                                logError($e);
                            }
                        }
                    }
                }
            }
        }
    }
    redirect("/api/apiadd?school_id=$school_id&user_id=$user_id");
}
