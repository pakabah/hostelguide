<?php
/**
 * Created by IntelliJ IDEA.
 * User: pakabah
 * Date: 26/05/2016
 * Time: 8:28 PM
 */
session_start();
include("../connection/config.php");
include("../includes/func_search.php");

global $db;

$postdata = file_get_contents("php://input");
$dataObj = json_decode($postdata,false);
$username = $_SESSION['username'];

if($dataObj->search)
{
    $search = $dataObj->searchTerm;
    $region = $dataObj->region;
    $campus = $dataObj->campus;
    $area = $dataObj->area;

    $app = new search();
    echo $app->searchTerm($search,$region,$campus,$area,$db);

}