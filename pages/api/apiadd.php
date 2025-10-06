<?php
$sql = "";
$school_id = $_GET["school_id"];
$user_id = $_GET["user_id"];
$sql = " and students.school_id = $school_id and angis.teacher_id = $user_id";
_selectNoParam(
    $stmt,
    $count,
    "SELECT students.id, fname, lname, students.phone, gender, schools.school_name, schools.id, angis.angi, angis.buleg, angis.id, rd FROM students INNER JOIN schools ON students.school_id = schools.id INNER JOIN angis ON students.angi_id = angis.id WHERE students.tuluv=0 " . $sql . " ORDER BY angis.id, lname",
    $id,
    $fname,
    $lname,
    $phone,
    $gender,
    $school_name,
    $school_id,
    $angi,
    $buleg,
    $angi_id,
    $rd
);
?>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        td {
            font-size: 2rem;
            margin-top: 3rem;
            border-bottom: 1px #008CBA solid;
        }

        th {
            font-size: 2rem;
            font-weight: bold;
            background-color: #008CBA;
            color: #ffffff;
            padding-right: 1rem;
            padding-left: 1rem;
        }

        tr {
            line-height: 5rem;
        }

        .btn {
            border: none;
            color: white;
            padding: 1rem 3rem;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 1.5rem;
            font-weight: bold;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 2rem;
            line-height: 2rem;
        }
        .warning{
            background-color: #4CAF50;
        }
        .primary{
            background-color: #008CBA;
        }
    </style>
</head>

<body>
    <table style="margin: auto;">
        <thead class="row">
            <th>№</th>
            <th>Овог</th>
            <th>Нэр</th>
            <th>Анги</th>
            <th></th>
        </thead>
        <tbody>
            <?php if ($count > 0) : ?>
                <?php $too = 0;
                while (_fetch($stmt)) : $too++ ?>
                    <tr class="row">
                        <td><?= $too ?>.</td>
                        <td><?= $fname ?></td>
                        <td><?= $lname ?></td>
                        <td><?php echo $angi . $buleg ?></td>
                        <td>
                            <?php
                            $count_sid = 0;
                            _selectRowNoParam(
                                "SELECT DISTINCT(student_id) FROM `sudalgaas` WHERE student_id = '$id' and jil = '$jil'",
                                $count_sid
                            );
                            if ($count_sid > 0) {
                                echo "<a href='/api/api-insert?school_id=$school_id&user_id=$user_id&id=$id&angi=$angi&type=1&name=\"$fname  $lname\"'>
                                                        <div class='btn warning'>Засах</div>
                                                    </a>";
                            } else {
                                echo "<a href='/api/api-insert?school_id=$school_id&user_id=$user_id&id=$id&angi=$angi&type=0&name=\"$fname  $lname\"'>
                                                        <div class='btn primary'>Судалгаа бөглөх</div>
                                                    </a>";
                            }
                            ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>

</html>