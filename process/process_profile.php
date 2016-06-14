<?php
/**
 * Created by IntelliJ IDEA.
 * User: pakabah
 * Date: 14/06/2016
 * Time: 12:17 AM
 */
session_start();
include("../connection/config.php");
require_once('ImageManipulator.php');



global $db;
$username = $_SESSION['username'];

$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];

$validExtensions = array('.png','.jpg','jpeg');
$fileExtension = strrchr($_FILES['file']['name'], ".");
$manipulator = new ImageManipulator($_FILES['file']['tmp_name']);
$newname = uniqid().$fileExtension;

$manipulator->save('../lisitngs/'.$newname);

$query = "UPDATE users SET name=?, phone=?,email=?,profile_pic=? WHERE username=?";
$q = $db->prepare($query);
$q->execute(array($name,$phone,$email,'lisitngs/'.$newname,$username));