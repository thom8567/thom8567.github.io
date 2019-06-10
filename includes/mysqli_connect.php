<?php

$mysqli = new mysqli('127.0.0.1', 'homestead', 'secret', 'wattbike', '3306');
if ( $mysqli -> connect_error ){
    exit ( 'Error connecting to Database' );
}
mysqli_report( MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT );
$mysqli -> set_charset('utf8mb4');