<?php
/**
 * Created by IntelliJ IDEA.
 * User: pakabah
 * Date: 19/05/2016
 * Time: 12:59 PM
 */
session_start();
include("../connection/config.php");
include("../includes/func_login.php");

global $db;

$postdata = file_get_contents("php://input");
$dataObj = json_decode($postdata,false);
$uname = $_SESSION['username'];
$mName = $_SESSION['name'];

if($dataObj->login)
{
    $username = $dataObj->username;
    $password = $dataObj->password;

    $app = new login();
    echo $app->create_login($username,$password,$db);
}
elseif($dataObj->signup)
{
    $name = $dataObj->name;
    $username = $dataObj->username;
    $password = $dataObj->password;
    $profile = $dataObj->profile;
    $email= $dataObj->email;
    $phone = $dataObj->phone;

    $app = new login();
    echo $app->create_signup($username,$password,$name,$phone,$email,$profile,$db);

}
elseif($dataObj->isloggedIn)
{

    session_start();
    if($_SESSION['username'])
    {
        echo "1";
    }
    else
    {
        echo "0";
    }
}
elseif($dataObj->logout)
{
    $app = new login();
    echo $app->logout();
}
elseif($dataObj->getUsername)
{
    echo $mName;
}
