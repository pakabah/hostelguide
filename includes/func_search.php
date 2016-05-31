<?php
/**
 * Created by IntelliJ IDEA.
 * User: pakabah
 * Date: 26/05/2016
 * Time: 8:28 PM
 */

class search
{
    function searchTerm($searchTerm,$region="",$campus="",$area="",$db)
    {
        $Info = array();
        $data = array();

        $query = "SELECT * FROM listing WHERE hostel_name LIKE ? OR region LIKE ? OR campus LIKE ? OR area LIKE ?";
        $q = $db->prepare($query);
        $q->execute(array('%'.$searchTerm.'%','%'.$region.'%','%'.$campus.'%','%'.$area.'%'));

        WHILE($results = $q->fetch(PDO::FETCH_ASSOC))
        {
            $data['id'] = $results['hostel_id'];
            $data['hostel_name'] =  $results['hostel_name'];
            $data['username']  = $results['username'];
            $data['region']  = $results['region'];
            $data['campus'] = $results['campus'];
            $data['area']  = $results['area'];
            $data['location'] = $results['location'];
            $data['phone'] =  $results['contact_phone'];
            $data['email']  = $results['contact_email'];
            $data['rooms'] = $results['rooms'];
            $data['long']  =  $results['long_location'];
            $data['lat']  =  $results['lat_location'];

            $Info[] = $data;
        }

        return json_encode($Info);
    }
}