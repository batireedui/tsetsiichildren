<?php 
require ROOT . "/pages/ssp.class.php";
// DB table to use

$sql = "";
$h_jil = $_SESSION['jil'];
if ($_SESSION['user_role'] == "najiltan") {
    $sql = " and students.school_id = ".$_SESSION['school_id'];
} elseif ($_SESSION['user_role'] == "teacher") {
    $sql = " and students.school_id = ".$_SESSION['school_id']." and angis.teacher_id = ".$_SESSION['user_id'];
}
$sql = "SELECT students.id as student_id, fname, lname, gender, schools.school_name, schools.id as school_id, 
CONCAT(angis.angi, angis.buleg) AS angi, angis.id as angi_id, rd, 
(SELECT DISTINCT(student_id) FROM `sudalgaas` WHERE student_id = students.id and jil = '$h_jil') as eseh 
FROM students INNER JOIN schools ON students.school_id = schools.id INNER JOIN angis ON students.angi_id = angis.id WHERE students.tuluv=0" . $sql;

$table = <<<EOT
( $sql ) temp
EOT;
$primaryKey = 'student_id';
 $columns = array(
    array(
        'db' => 'student_id',
        'dt' => 'DT_RowId',
        'formatter' => function( $d, $row ) {
            // Technically a DOM id cannot start with an integer, so we prefix
            // a string. This can also be useful if you have multiple tables
            // to ensure that the id is unique with a different prefix
            return 'row_'.$d;
        }
    ),
    array( 'db' => 'student_id', 'dt' => 'student_id'),
    array( 'db' => 'fname',  'dt' => 'fname' ),
    array( 'db' => 'lname',   'dt' => 'lname' ),
    array( 'db' => 'gender',     'dt' => 'gender'),
    array( 'db' => 'school_name',     'dt' => 'school_name' ),
    array( 'db' => 'school_id',     'dt' => 'school_id' ),
    array( 'db' => 'angi',     'dt' => 'angi' ),
    array( 'db' => 'angi_id',     'dt' => 'angi_id' ),
    array( 'db' => 'rd', 'dt' => 'rd'),
    array( 'db' => 'eseh',     'dt' => 'eseh' )
);
 
// SQL server connection information
$sql_details = array(
    'user' => DB_USER,
    'pass' => DB_PASSWORD,
    'db'   => DB_NAME,
    'host' => DB_HOST
);
 
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

echo json_encode(
	SSP::simple(  $_GET, $sql_details, $table, $primaryKey, $columns)
);