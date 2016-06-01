<?php
/**
 * Created by IntelliJ IDEA.
 * User: pakabah
 * Date: 21/05/2016
 * Time: 9:44 AM
 */
session_start();
include("../connection/config.php");
include("../includes/func_listings.php");

global $db;

$postdata = file_get_contents("php://input");
$dataObj = json_decode($postdata,false);
$username = $_SESSION['username'];

if($dataObj->getRecentListing)
{
    $app = new listing();
    echo $app->getRecentListings($db);
}
elseif($dataObj->getAllListing)
{
    $app = new listing();
    echo $app->getAllListings($db);
}
elseif($dataObj->getSearchListing)
{
    $search = $dataObj->search;
    $app = new listing();
    echo $app->getSearchListing($search,$db);
}
elseif($dataObj->uploadListing)
{
    $hostel_name = $dataObj->hostelname;
    $region = $dataObj->region;
    $campus = $dataObj->campus;
    $area = $dataObj->area;
    $location = $dataObj->location;
    $phone = $dataObj->phone;
    $email = $dataObj->email;
    $rooms = $dataObj->rooms;

    $long = "";
    $lat  = "";

//    $long = $dataObj->long;
//    $lat  = $dataObj->lat;

    $app = new listing();
    echo $app->uploadListing($hostel_name,$username,$region,$campus,$area,$location,$phone,$email,$rooms,$long,$lat,$db);
}
elseif($dataObj->getMyListings)
{

}
elseif($dataObj->getAllAgentListing)
{
    $app = new listing();
    echo $app->getAllAgents($db);
}
elseif($dataObj->getDetailListing)
{
    $id = $dataObj->id;
    $app = new listing();
    echo $app->getDetails($id,$db);
}
elseif($dataObj->getMyListing)
{
    $app = new listing();
    echo $app->getAllMyListings($username,$db);
}
elseif($dataObj->getAgentListing)
{
    $app = new listing();
    echo $app->getRecentAgents($db);
}