<?php
$h_jil = $_SESSION['jil'];
$school_id = $_SESSION['school_id'];
$id = $_POST['id'];
$jil = $_POST['jil'];

$table = "sudalgaas";

if ($jil != $h_jil) {
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
    table th, tr {
        border: 1px solid #697a8d;
        padding: .5rem .75rem;
    }
</style>
<div class="table-responsive text-nowrap">
    <table class="table-header-rotated w-100" style="font-size: 12px;">
        <?php
        if ($id == "0") { ?>
            <thead class="table-light">
                <tr>
                    <th>Шалгуур үзүүлэлт</th>
                    <th>Бага анги</th>
                    <th>Анхлах анги</th>
                    <th>Нийт</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                <?php
                _selectNoParam(
                    $bs,
                    $bc,
                    "SELECT COUNT(id), $table.shalguur_id FROM `$table` WHERE $table.angi < 6 and $table.value = '1' GROUP BY $table.shalguur_id",
                    $btoo,
                    $bshalguur_id
                );
                $arrayBaga = array();
                while (_fetch($bs)) {
                    $ro = new stdClass();
                    $ro->btoo = $btoo;
                    $ro->bshalguur_id = $bshalguur_id;
                    array_push($arrayBaga, $ro);
                }
                _selectNoParam(
                    $as,
                    $ac,
                    "SELECT COUNT(id), $table.shalguur_id FROM `$table` WHERE $table.angi > 5 and $table.value = '1' GROUP BY $table.shalguur_id",
                    $atoo,
                    $ashalguur_id
                );
                $arrayAhlah = array();
                while (_fetch($as)) {
                    $aro = new stdClass();
                    $aro->atoo = $atoo;
                    $aro->ashalguur_id = $ashalguur_id;
                    array_push($arrayAhlah, $aro);
                }
                $d = 0;
                foreach ($shalguurs as $key => $val) : $d++; $dun = 0; ?>
                    <tr colspan="2">
                        <td>
                            <div style="text-align: left;"><?php echo $d . ") " . $val[1] ?></div>
                        </td>
                        <td>
                            <?php
                            foreach ($arrayBaga as $ele) {
                                if ($val[0] == $ele->bshalguur_id) {
                                    echo "$ele->btoo ";
                                    $dun += $ele->btoo;
                                }
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            foreach ($arrayAhlah as $ele) {
                                if ($val[0] == $ele->ashalguur_id) {
                                    echo "$ele->atoo ";
                                    $dun += $ele->atoo;
                                }
                            }
                            ?>
                        </td>
                        <td><?=$dun?></td>
                    </tr>
                <?php endforeach ?>

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
            while (_fetch($as)) {
                $aro = new stdClass();
                $aro->stoo = $stoo;
                $aro->sshalguur_id = $sshalguur_id;
                $aro->sschool_id = $sschool_id;
                array_push($arraySchool, $aro);
            }
            ?>
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px">Шалгуур үзүүлэлт</th>
                        <?php
                        foreach ($schools as $skey => $sval) : ?>
                            <th colspan="2" class="rotate"><?php echo $sval[1]; ?></th>
                        <?php endforeach ?>
                        <th>Нийт</th>
                    </tr>
                </thead>
            <tbody class="table-border-bottom-0">
                <?php

                foreach ($shalguurs as $key => $val) {
                ?>
                    <tr>
                        <td style="min-width: 250px;" class="text-wrap"><div style="text-align: left"><?= $val[1] ?></div></td>
                        <?php
                        $dun = 0;
                        foreach ($schools as $skey => $sval) :
                            /*
                            _selectRowNoParam(
                                "SELECT COUNT(DISTINCT $table.student_id) FROM `$table` INNER JOIN students ON $table.student_id = students.id WHERE $table.value = '1' and $table.shalguur_id = $val[0] and students.school_id = $sval[0]",
                                $val_too
                            );
                            */
                            echo "<td colspan='2'>";
                            foreach ($arraySchool as $key_s => $els) {
                                if ($val[0] == $els->sshalguur_id && $sval[0] == $els->sschool_id) {
                                    echo "$els->stoo ";
                                    $dun += $els->stoo;
                                    unset($arraySchool[$key_s]);
                                    break;
                                }
                            }
                            echo "</td>";
                        ?>
                        <?php endforeach ?>
                        <td><?=$dun?></td>
                    </tr>
            <?php }
            } ?>
            </tbody>
    </table>
</div>