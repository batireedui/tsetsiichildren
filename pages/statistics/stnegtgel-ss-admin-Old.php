<?php
$h_jil = $_SESSION['jil'];
$school_id = $_SESSION['school_id'];
$id = $_POST['id'];
$jil = $_POST['jil'];

$table = "sudalgaas";

if($jil != $h_jil){
    $table = $table . substr($jil, 0, 4);
}

$where = "";

_selectNoParam(
    $stmt,
    $count,
    "SELECT DISTINCT shalguurs.id, shalguurs.name, shalguurs.ded, shalguurs.hariulttype, shalguurs.turul FROM `shalguurs` WHERE shalguurs.tuluv = 1 ORDER BY  shalguurs.id;",
    $shalguur_id,
    $shalguur_name,
    $shalguur_ded,
    $hariulttype,
    $shalguurs_turul
);
$shalguurs = array();
while (_fetch($stmt)) {
    array_push($shalguurs, [$shalguur_id, $shalguur_name, $shalguur_ded, $hariulttype, $shalguurs_turul]);
}

$schools = array();
if ($_SESSION['user_role'] == "najiltan") {
    _selectNoParam(
        $stmts,
        $counst,
        "SELECT id, school_name FROM `schools` WHERE id = " . $_SESSION['school_id'],
        $s_id,
        $s_name
    );
    while (_fetch($stmts)) {
        array_push($schools, [$s_id, $s_name]);
    }
    $where = " students.school_id = $s_id and ";
} elseif ($_SESSION['user_role'] == "admin") {
    _selectNoParam(
        $stmts,
        $counst,
        "SELECT id, school_name FROM `schools`",
        $s_id,
        $s_name
    );
    while (_fetch($stmts)) {
        array_push($schools, [$s_id, $s_name]);
    }
}

?>

<style>
    .rotate {
        padding: .5rem;
        position: relative;
        -webkit-transform: rotate(180deg);
        transform: rotate(180deg);
        white-space: nowrap;
        -webkit-writing-mode: vertical-rl;
        writing-mode: vertical-rl;
    }

    th {
        vertical-align: bottom;
        border: 1px solid #697a8d;
    }

    table td,
    table th {
        border: 1px solid #697a8d;
        padding: .5rem .75rem;
    }
</style>
<div class="table-responsive text-nowrap">
    <table class="table-header-rotated">
        <thead class="table-light">
            <tr>
                <th></th>
                <?php $d = 0;
                foreach ($shalguurs as $key => $val) : $d++; ?>
                    <th colspan="2">
                        <div class="rotate"><?php echo $d . ") " . $val[1] ?></div>
                    </th>
                <?php endforeach ?>
            </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            <?php if ($id == "0") { ?>
                <tr>
                    <td>Бага анги</td>
                    <?php
                    //SELECT COUNT(id), sudalgaas2024.shalguur_id FROM `sudalgaas2024` WHERE sudalgaas2024.angi < 6 and sudalgaas2024.value = '1' GROUP BY sudalgaas2024.shalguur_id;
                    /*
                    _selectRowNoParam(
                            "SELECT COUNT(DISTINCT student_id) FROM `$table` INNER JOIN students ON $table.student_id = students.id WHERE $where $table.angi < 6 and $table.value = '1' and $table.shalguur_id = $val[0]",
                            $val_too
                        );
                    */
                    _selectNoParam(
                        $bs,
                        $bc,
                        "SELECT COUNT(id), $table.shalguur_id FROM `$table` WHERE $table.angi < 6 and $table.value = '1' GROUP BY $table.shalguur_id",
                        $btoo,
                        $bshalguur_id
                    );
                    $arrayBaga = array();
                    while(_fetch($bs)) {
                        $ro = new stdClass();
                        $ro->btoo = $btoo;
                        $ro->bshalguur_id = $bshalguur_id;
                        array_push($arrayBaga, $ro);
                    }
                    foreach ($shalguurs as $key => $val) :
                        echo "<td colspan='2'>";
                        foreach($arrayBaga as $ele) {
                            if($val[0] == $ele->bshalguur_id) {
                                echo "$ele->btoo ";
                            }
                        }
                        echo "</td>";
                    ?>
                    <?php endforeach ?>
                </tr>
                <tr>
                    <td>Дунд/Ахлах анги</td>
                    <?php
                     _selectNoParam(
                        $as,
                        $ac,
                        "SELECT COUNT(id), $table.shalguur_id FROM `$table` WHERE $table.angi > 5 and $table.value = '1' GROUP BY $table.shalguur_id",
                        $atoo,
                        $ashalguur_id
                    );
                    $arrayAhlah = array();
                    while(_fetch($as)) {
                        $aro = new stdClass();
                        $aro->atoo = $atoo;
                        $aro->ashalguur_id = $ashalguur_id;
                        array_push($arrayAhlah, $aro);
                    }
                    foreach ($shalguurs as $key => $val) :
                        /*
                        _selectRowNoParam(
                            "SELECT COUNT(DISTINCT student_id) FROM `$table` INNER JOIN students ON $table.student_id = students.id WHERE $where $table.angi > 5 and $table.value = '1' and $table.shalguur_id = $val[0]",
                            $val_too
                        );*/
                        
                        echo "<td colspan='2'>";
                        foreach($arrayAhlah as $ele) {
                            if($val[0] == $ele->ashalguur_id) {
                                echo "$ele->atoo ";
                            }
                        }
                        echo "</td>";
                    ?>
                    <?php endforeach ?>
                </tr>
                <?php } else {
                _selectNoParam(
                    $as,
                    $ac,
                    "SELECT COUNT(DISTINCT $table.student_id), $table.shalguur_id,  students.school_id  FROM `$table` INNER JOIN students ON $table.student_id = students.id WHERE $table.value = '1' GROUP BY $table.shalguur_id, students.school_id",
                    $stoo,
                    $sshalguur_id,
                    $sschool_id
                );
                $arraySchool = array();
                while(_fetch($as)) {
                    $aro = new stdClass();
                    $aro->stoo = $stoo;
                    $aro->sshalguur_id = $sshalguur_id;
                    $aro->sschool_id = $sschool_id;
                    array_push($arraySchool, $aro);
                }
                foreach ($schools as $skey => $sval) {
                ?>
                    <tr>
                        <td><?= $sval[1] ?></td>
                        <?php
                        foreach ($shalguurs as $key => $val) :
                            /*
                            _selectRowNoParam(
                                "SELECT COUNT(DISTINCT $table.student_id) FROM `$table` INNER JOIN students ON $table.student_id = students.id WHERE $table.value = '1' and $table.shalguur_id = $val[0] and students.school_id = $sval[0]",
                                $val_too
                            );
                            */
                            echo "<td colspan='2'>";
                            foreach($arraySchool as $key_s => $els) {
                                if($val[0] == $els->sshalguur_id && $sval[0] == $els->sschool_id) {
                                    echo "$els->stoo ";
                                    unset($arraySchool[$key_s]);
                                    break;
                                }
                            }
                            echo "</td>";
                        ?>
                        <?php endforeach ?>
                    </tr>
            <?php }
            } ?>
        </tbody>
    </table>
</div>