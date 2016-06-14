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
$profile = $_SESSION['profile'];

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
elseif($dataObj->getListingEdit)
{
    $app = new listing();
    echo $app->getEditDetails($dataObj->getListingEdit, $db);
}
elseif($dataObj->deleteListing)
{
    $app = new listing();
     $app->deleteListing($dataObj->deleteListing,$db);
}
elseif($dataObj->reserveListing)
{
    $id = $dataObj->id;
    $price = $dataObj->price;
    $room = $dataObj->room;
    $app = new listing();
    $app->reserve($id,$username,$price,$room,$db);
}
elseif($dataObj->checkReservation)
{
    if(isset($profile))
    {
        if($profile == "student")
        {
            echo "1";
        }else
        {
            echo "2";
        }
    }
    else
    {
        echo "0";
    }
}
elseif($dataObj->getMyReservations)
{
    $app = new listing();
    echo $app->getMyReservations($username,$db);
}
elseif($dataObj->deleteReservation)
{
    $user = $dataObj->deleteReservation;
    $hostel_id = $dataObj->hostel_id;
    $app = new listing();
    echo $app->deleteReservation($user,$hostel_id,$db);
}