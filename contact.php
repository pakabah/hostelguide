<?php
$recipient = "fatonnavdiu@gmail.com"; ///  Your Email address
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];
$subject = $_POST['subject'];
$formcontent=" From: $name \n Message: $message";
$headers = "From: $email \r\n";
mail($recipient, $subject, $formcontent, $headers) or die("Error!");
?>