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
$hsid = $_POST['hsid'];

if($count == 0)
{
    $hostel_name =$_POST['hostelname'];
    $region = $_POST['region'];
    $campus = $_POST['campus'];
    $area =  $_POST['area'];
    $location = $_POST['location'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $rooms = $_POST['rooms'];
    $description  =  $_POST['description'];
    $lat = $_POST['lat'];
    $log = $_POST['lon'];

    $app = new listing();
    $app->uploadListing($hostel_name,$username,$region,$campus,$area,$location,$phone,$email,$rooms,$log,$lat,$description,$hostelId,$db);

    $validExtensions = array('.png','.jpg','jpeg');
    $fileExtension = strrchr($_FILES['file']['name'], ".");
    $manipulator = new ImageManipulator($_FILES['file']['tmp_name']);
    $newname = $hostel_name.uniqid().$fileExtension;

    $manipulator->save('../lisitngs/'.$newname);

    $app = new listing();
    $app->uploadPictures($hostelId,$newname,$db);

    echo $hostelId;

}

if($count > 0)
{
    $validExtensions = array('.png','.jpg','jpeg');
    $fileExtension = strrchr($_FILES['file']['name'], ".");
    $manipulator = new ImageManipulator($_FILES['file']['tmp_name']);
    $newname = $hostel_name.uniqid().$fileExtension;

    $manipulator->save('../lisitngs/'.$newname);

    $app = new listing();
    $app->uploadPictures($hsid,$newname,$db);
    echo $hsid;
}




