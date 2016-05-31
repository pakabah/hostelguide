<?php
/**
 * Created by IntelliJ IDEA.
 * User: pakabah
 * Date: 19/05/2016
 * Time: 1:00 PM
 */
class login
{

    function create_login($username,$password,$db)
    {
        $password = hash("sha256", $password);

//        $query = "SELECT * FROM users WHERE username=? AND password=?";
        $query = "SELECT * FROM users WHERE username=?";
        $q = $db->prepare($query);
//        $q->execute(array($username,$password));
        $q->execute(array($username));


        $results = $q->fetch(PDO::FETCH_ASSOC);
        if(!empty($results['username']))
        {
            session_start();

            $_SESSION['username'] = $username;
            $_SESSION['name'] = $results['name'];
            $_SESSION['profile'] = $results['profile'];
            $_SESSION['sid'] = uniqid();
            $profile = $results['profile'];

            return $profile;
        }
        else
        {
            return "0";
        }
    }

    function create_signup($username,$password,$name,$number,$email,$profile,$db)
    {
        $password = hash("sha256", $password);

        if(!$this->checkUsername($username,$db))
        {
            $status = "inactive";
            $query = "INSERT INTO users(username, password, email, phone, name, profile, status) VALUES (?,?,?,?,?,?,?)";
            $q = $db->prepare($query);
            $q->execute(array($username,$password,$email,$number,$name,$profile,$status));

            session_start();

            $_SESSION['username'] = $username;
            $_SESSION['name'] = $name;
            $_SESSION['profile'] = $profile;
            $_SESSION['sid'] = uniqid();

            return "1";
        }
        else
        {
            return "0";
        }
    }


    function checkUsername($username,$db)
    {
        $query = "SELECT * FROM users WHERE username=?";
        $q= $db->prepare($query);
        $q->execute(array($username));
        $res  = $q->fetch(PDO::FETCH_ASSOC);

        if($res['username'] == $username)
        {
            return true;
        }
        else{
            return false;
        }
    }

    function logout()
    {
        unset($_SESSION['username']);
        unset($_SESSION['name']);
        unset($_SESSION['profile']);
        unset($_SESSION['sid']);

        session_destroy();
        return "1";
    }
}