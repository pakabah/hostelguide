<?php
/**
 * Created by IntelliJ IDEA.
 * User: pakabah
 * Date: 26/05/2016
 * Time: 8:28 PM
 */

class search
{
    function searchTerm($searchTerm,$region,$campus,$area,$db)
    {
        $Info = array();
        $data = array();


        if(isset($searchTerm) && empty($region) && empty($campus) && empty($area))
        {
            $query = "SELECT * FROM listing WHERE hostel_name LIKE ? ";
            $q = $db->prepare($query);
            $q->execute(array('%'.$searchTerm.'%'));
        }
        else if(empty($searchTerm) && isset($region) && isset($campus) && isset($area))
        {
            $query = "SELECT * FROM listing WHERE  region LIKE ? OR campus LIKE ? OR area LIKE ?";
            $q = $db->prepare($query);
            $q->execute(array('%'.$region.'%','%'.$campus.'%','%'.$area.'%'));
        }
        else if(isset($searchTerm) && isset($region) && empty($campus) && empty($area))
        {
            $query = "SELECT * FROM listing WHERE hostel_name LIKE ? OR region LIKE ?";
            $q = $db->prepare($query);
            $q->execute(array('%'.$searchTerm.'%','%'.$region.'%'));
        }
        else if(empty($searchTerm) && isset($region) && empty($campus) && empty($area))
        {
            $query = "SELECT * FROM listing WHERE  region LIKE ? ";
            $q = $db->prepare($query);
            $q->execute(array('%'.$region.'%'));
        }
        else if(empty($searchTerm) && empty($region) && isset($campus) && empty($area))
        {
            $query = "SELECT * FROM listing WHERE campus LIKE ?";
            $q = $db->prepare($query);
            $q->execute(array('%'.$campus.'%'));
        }
        else if(empty($searchTerm) && empty($region) && empty($campus) && isset($area))
        {
            $query = "SELECT * FROM listing WHERE area LIKE ?";
            $q = $db->prepare($query);
            $q->execute(array('%'.$area.'%'));
        }
        else
        {
            $query = "SELECT * FROM listing WHERE hostel_name LIKE ?";
            $q = $db->prepare($query);
            $q->execute(array('%'.$searchTerm.'%'));
        }


        WHILE($results = $q->fetch(PDO::FETCH_ASSOC))
        {
            $hid = $results['hostel_id'];

            $data['id'] = $results['hostel_id'];
            $data['hostel_name'] =  $results['hostel_name'];
            $data['username']  = $results['username'];
            $data['region']  = $results['region'];
            $data['campus'] = $results['campus'];
            $data['area']  = $results['area'];
            $data['location'] = $results['location'];
            $data['phone'] =  $results['contact_phone'];
            $data['email']  = $results['contact_email'];
            $data['long']  =  $results['long_location'];
            $data['lat']  =  $results['lat_location'];

            $queryPic = "SELECT * FROM listiing_pics WHERE hostel_id=?";
            $qPic  = $db->prepare($queryPic);
            $qPic->execute(array($hid));

            $queryRoom = "SELECT * FROM listing_rooms WHERE hostel_id=?";
            $qRoom = $db->prepare($queryRoom);
            $qRoom->execute(array($hid));

            $queryFacility = "SELECT * FROM listing_facility WHERE hostel_id=?";
            $qFacility = $db->prepare($queryFacility);
            $qFacility->execute(array($hid));

            $resFacility = $qFacility->fetch(PDO::FETCH_ASSOC);

            $resPic = $qPic->fetch(PDO::FETCH_ASSOC);

            $resRoom = $qRoom->fetch(PDO::FETCH_ASSOC);

            $data['facility'] = $resFacility['facility'];
            $data['rooms'] = $resRoom['room'];
            $data['price'] = $resRoom['price'];
            $data['picture'] = $resPic['pic'];

            $Info[] = $data;
        }

        return json_encode($Info);
    }
}