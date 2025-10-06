<?php 
require ROOT . "/pages/ssp.class.php";
// DB table to use

$sql = "";
if ($_SESSION['user_role'] == "najiltan") {
    $sql = " and students.school_id = ".$_SESSION['school_id'];
}

elseif ($_SESSION['user_role'] == "teacher") {
    $sql = " and students.school_id = ".$_SESSION['school_id']." and angis.teacher_id = ".$_SESSION['user_id'];
}
//$sql = "SELECT students.id as student_id, fname, lname, students.phone, gender, schools.school_name, schools.id as school_id, (SELECT angis.angi FROM angis WHERE angis.id = students.angi_id) as angi, (SELECT angis.buleg FROM angis WHERE angis.id = students.angi_id) as buleg, (SELECT angis.id FROM angis WHERE angis.id = students.angi_id) as angi_id, rd FROM students INNER JOIN schools ON students.school_id = schools.id WHERE students.tuluv=0 " . $sql;
$sql = "SELECT students.id as student_id, fname, lname, students.phone, gender, rd FROM students WHERE students.school_id = 0 AND tuluv = 1";    
$table = <<<EOT
( $sql ) temp
EOT;
 
// Table's primary key
$primaryKey = 'student_id';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes

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
    array( 'db' => 'rd', 'dt' => 'rd'),
    array( 'db' => 'student_id', 'dt' => 'student_id'),
    array( 'db' => 'fname',  'dt' => 'fname' ),
    array( 'db' => 'lname',   'dt' => 'lname' ),
    array( 'db' => 'phone',     'dt' => 'phone' ),
    array( 'db' => 'gender',     'dt' => 'gender'),
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