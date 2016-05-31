<?php
/**
 * Created by IntelliJ IDEA.
 * User: akabah
 * Date: 12/14/15
 * Time: 10:44 PM
 */
//$hostname = "p3plcpnl0658.prod.phx3.secureserver.net";
$hostname = "localhost";
$usrname = "hostel_user";
$password = "ndvem92";
$dbname = "hostelguide";

global $db;
try {
$db = new PDO("mysql:host=$hostname;dbname=$dbname",$usrname,$password);
//echo "connected";
}catch (PDOException $pe) {
    die("Could not connect to the database $dbname :" . $pe->getMessage());
}
//$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
