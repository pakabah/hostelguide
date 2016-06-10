<?php
/**
 * Created by IntelliJ IDEA.
 * User: pakabah
 * Date: 30/05/2016
 * Time: 12:36 PM
 */
session_start();
include("../connection/config.php");
require_once('ImageManipulator.php');
include("../includes/func_listings.php");



global $db;
$username = $_SESSION['username'];

$count = $_POST['count'];
$hostel_name =$_POST['hostelname'];
$hostelId = uniqid("HST");
$hsid = $_SESSION['hsId'];

if($count == 0)
{
    session_start();
    $hostel_name =$_POST['hostelname'];
    $region = $_POST['region'];
    $campus = $_POST['campus'];
    $area =  $_POST['area'];
    $location = $_POST['location'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $description  =  $_POST['description'];
    $lat = $_POST['lat'];
    $log = $_POST['lon'];
    $facilities = $_POST['facilities'];
    $services = $_POST['services'];


    $apps = new listing();

    $apps->uploadListing($hostel_name,$username,$region,$campus,$area,$location,$phone,$email,$log,$lat,$description,$hostelId,$db);

    $apps->insertFacility($hostelId,$facilities,$db);

    $apps->insertServices($hostelId,$services,$db);

    $app = new listing();

    if($_POST['oneRoom'])
    {
        $oneRoom = $_POST['oneRoom'];
        try{
            $app->insertRoomPrice($hostelId,"1",$oneRoom,$db);
        }
        catch(PDOException $ex)
        {

        }
    }
    if($_POST['twoRoom'])
    {
        $twoRoom = $_POST['twoRoom'];
        try{
            $app->insertRoomPrice($hostelId,"2",$twoRoom,$db);
        }
        catch(PDOException $ex)
        {

        }
    }
    if($_POST['threeRoom'])
    {
        $threeRoom = $_POST['threeRoom'];
        try{
            $app->insertRoomPrice($hostelId,"3",$threeRoom,$db);
        }
        catch(PDOException $ex)
        {

        }
    }
    if($_POST['fourRoom'])
    {
        $fourRoom = $_POST['fourRoom'];
        try{
            $app->insertRoomPrice($hostelId,"4",$fourRoom,$db);
        }
        catch(PDOException $ex)
        {

        }
    }
    if($_POST['fiveRoom'])
    {
        $fiveRoom = $_POST['fiveRoom'];
        try{
            $app->insertRoomPrice($hostelId,"5",$fiveRoom,$db);
        }
        catch(PDOException $ex)
        {

        }
    }

    $validExtensions = array('.png','.jpg','jpeg');
    $fileExtension = strrchr($_FILES['file']['name'], ".");
    $manipulator = new ImageManipulator($_FILES['file']['tmp_name']);
    $newname = $hostel_name.uniqid().$fileExtension;

    $manipulator->save('../lisitngs/'.$newname);

    $app = new listing();
    $app->uploadPictures($hostelId,'lisitngs/'.$newname,$db);

    $hostelId = $_SESSION['hsId'];
}

if($count > 0)
{
    $validExtensions = array('.png','.jpg','jpeg');
    $fileExtension = strrchr($_FILES['file']['name'], ".");
    $manipulator = new ImageManipulator($_FILES['file']['tmp_name']);
    $newname = $hostel_name.uniqid().$fileExtension;

    $manipulator->save('../lisitngs/'.$newname);

    $app = new listing();
    $app->uploadPictures($hsid,'lisitngs/'.$newname,$db);
    echo $hsid;
}




