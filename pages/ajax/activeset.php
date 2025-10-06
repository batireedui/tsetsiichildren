<?php
if (isset($_SESSION['user_id'])) {
    if ($_POST["type"] == "activeAdd") {
        $shalguurid = $_POST["shalguurid"];
        $turul = $_POST["turul"];
        $jil = $_SESSION['jil'];
        _selectNoParam(
            $dstmt,
            $dcount,
            "SELECT id FROM activeshes WHERE shalguur_id = $shalguurid and turul = '$turul'",
            $did
        );
        if ($dcount > 0) {
            echo "old";
        } else {
            try {
                $success = _exec(
                    "INSERT INTO activeshes(shalguur_id, turul, jil, created_at, updated_at) VALUES(?, ?, ?, ?, ?)",
                    "iisss",
                    [$shalguurid, $turul, $jil, ognoo(), ognoo()],
                    $count
                );
                echo "ok";
            } catch (Exception $e) {
                $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
                // echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
            } finally {
                if (isset($e)) {
                    logError($e);
                }
            }
        }
    } else if ($_POST["type"] == "activeRemove") {
        $shalguurid = $_POST["shalguurid"];
        $turul = $_POST["turul"];
        $jil = $_SESSION['jil'];
        try {
            $success = _exec(
                "DELETE FROM activeshes WHERE shalguur_id = ? and turul = ? and jil = ?",
                "iss",
                [$shalguurid, $turul, $jil],
                $count
            );
            echo "ok";
        } catch (Exception $e) {
            $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
            echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
        } finally {
            if (isset($e)) {
                logError($e);
            }
        }
    } else if ($_POST["type"] == "changeTuluv") {
        $shalguurid = $_POST["shalguurid"];
        $tuluv = $_POST["tuluv"];
        echo $tuluv;
        if ($tuluv == "true") $tuluv = 1;
        else $tuluv = 0;
        try {
            $success = _exec(
                "UPDATE shalguurs SET tuluv = ? WHERE id = ?",
                "ii",
                [$tuluv, $shalguurid],
                $count
            );
        } catch (Exception $e) {
            $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
            //echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
        } finally {
            if (isset($e)) {
                logError($e);
            }
        }
    }
}
