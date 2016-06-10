<?php
/**
 * Created by IntelliJ IDEA.
 * User: pakabah
 * Date: 09/06/2016
 * Time: 10:35 AM
 */
session_start();
include("../connection/config.php");
include("../includes/func_user.php");

global $db;

$postdata = file_get_contents("php://input");
$dataObj = json_decode($postdata,false);
$username = $_SESSION['username'];


if($dataObj->getMyInfo)
{
    $app = new user();
    echo $app->getMyDetails($username,$db);
}
elseif($dataObj->updateDetails)
{
    $name = $dataObj->name;
    $email = $dataObj->email;
    $phone = $dataObj->phone;

    $app = new user();
    echo $app->updateDetails($username,$name,$email,$phone,$db);
}
elseif($dataObj->updatePassword)
{
    $oldPass = $dataObj->oldPassword;
    $newPass = $dataObj->newPassword;

    $app = new user();
    echo $app->updatePassword($oldPass,$newPass,$username,$db);
}