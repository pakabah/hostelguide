<?php
/**
 * Created by IntelliJ IDEA.
 * User: pakabah
 * Date: 09/06/2016
 * Time: 10:34 AM
 */

class user
{

    function getMyDetails($username,$db)
    {
        $data = array();
        $query = "SELECT * FROM users WHERE username=?";
        $q = $db->prepare($query);
        $q->execute(array($username));

        $res = $q->fetch(PDO::FETCH_ASSOC);

        $data['name'] = $res['name'];
        $data['email'] = $res['email'];
        $data['phone'] = $res['phone'];
        $data['pic'] = $res['profile_pic'];

        return json_encode($data);
    }

    function updateDetails($username,$name,$email,$phone,$db)
    {
        $query = "UPDATE users SET name=?, email=?,phone=? WHERE username=?";
        $q = $db->prepare($query);
        $q->execute(array($name,$email,$phone,$username));

        return 1;
    }

    function updatePassword($oldPassword,$newPassword,$username,$db)
    {
        $oldPassword = hash("sha256", $oldPassword);
        $newPassword = hash("sha256", $newPassword);

        $query = "SELECT * FROM users WHERE username=? AND password=?";
        $q = $db->prepare($query);
        $q->execute(array($username,$oldPassword));
        $res = $q->fetch(PDO::FETCH_ASSOC);
        if(!empty($res))
        {
            $queryUpdate = "UPDATE users SET password=? WHERE username=?";
            $qUpdate = $db->prepare($queryUpdate);
            $qUpdate->execute(array($newPassword,$username));
            return 1;
        }
        else
        {
            return 0;
        }
    }
}