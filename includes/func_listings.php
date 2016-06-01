<?php
/**
 * Created by IntelliJ IDEA.
 * User: pakabah
 * Date: 21/05/2016
 * Time: 9:44 AM
 */
class listing
{

    function getRecentListings($db)
    {
        $Info = array();
        $data = array();
        $pics = array();
        $pic = array();

        $query = "SELECT * FROM listing ORDER BY hostel_id DESC LIMIT 3";
        $q = $db->prepare($query);
        $q->execute(array());

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
            $data['rooms'] = $results['rooms'];
            $data['long']  =  $results['long_location'];
            $data['lat']  =  $results['lat_location'];

            $queryPic = "SELECT * FROM listiing_pics WHERE hostel_id=?";
            $qPic  = $db->prepare($queryPic);
            $qPic->execute(array($hid));

            $resPic = $qPic->fetch(PDO::FETCH_ASSOC);

            $data['picture'] = $resPic['pic'];

            $Info[] = $data;
        }

        return json_encode($Info);
    }

    function getSearchListing($search,$db)
    {
        $Info = array();
        $data = array();

//        $query = "SELECT * FROM listing WHERE hostel_name LIKE ? OR campus LIKE ? OR area LIKE ?";
//        $q = $db->prepare($query);
//        $q->execute(array('%'.$search.'%','%'.$search.'%','%'.$search.'%'));

        $query = "SELECT * FROM listing WHERE hostel_name LIKE ?";
        $q = $db->prepare($query);
        $q->execute(array('%'.$search.'%'));

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
            $data['rooms'] = $results['rooms'];
            $data['long']  =  $results['long_location'];
            $data['lat']  =  $results['lat_location'];

            $queryPic = "SELECT * FROM listiing_pics WHERE hostel_id=?";
            $qPic  = $db->prepare($queryPic);
            $qPic->execute(array($hid));

            $resPic = $qPic->fetch(PDO::FETCH_ASSOC);
            $data['picture'] = $resPic['pic'];

            $Info[] = $data;
        }

        return json_encode($Info);
    }

    function getAllListings($db)
    {
        $Info = array();
        $data = array();

        $query = "SELECT * FROM listing";
        $q = $db->prepare($query);
        $q->execute(array());

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

    function getDetails($id,$db)
    {
        $Info = array();
        $data = array();
        $pics = array();
        $pic = array();

        $query = "SELECT * FROM listing WHERE hostel_id=?";
        $q = $db->prepare($query);
        $q->execute(array($id));

        $profile = "manager";

        WHILE($results = $q->fetch(PDO::FETCH_ASSOC))
        {
            $hid = $results['hostel_id'];
            $data['id'] = $results['hostel_id'];
            $data['hostel_name'] =  $results['hostel_name'];
            $username =  $results['username'];
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
            $data['details'] = $results['description'];

            $queryM = "SELECT * FROM users WHERE profile=? AND username=?";
            $qM = $db->prepare($queryM);
            $qM->execute(array($profile,$username));
            $resultsM = $qM->fetch(PDO::FETCH_ASSOC);

            $queryPic = "SELECT * FROM listiing_pics WHERE hostel_id=?";
            $qPic  = $db->prepare($queryPic);
            $qPic->execute(array($hid));

            WHILE($resPic = $qPic->fetch(PDO::FETCH_ASSOC))
            {
                $pic['pics'] = $resPic['pic'];
                $pics[] = $pic;
            }
            $data['pictures'] = json_encode($pics);

            $data['name'] = $resultsM['name'];
            $data['email'] = $resultsM['email'];
            $data['phone'] = $resultsM['phone'];

            $Info[] = $data;
        }

        return json_encode($Info);
    }

    function uploadListing($hostelName,$username,$region,$campus,$area,$location,$phone,$email,$rooms,$long,$lat,$description,$hostelId,$db)
    {

        $query = "INSERT INTO listing(hostel_id, hostel_name, username, region, campus, area, location, contact_phone, contact_email, rooms, long_location, lat_location,description) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $q = $db->prepare($query);
        $q->execute(array($hostelId,$hostelName,$username,$region,$campus,$area,$location,$phone,$email,$rooms,$long,$lat,$description));
        return "1";
    }

    function uploadPictures($hostel_id,$pic,$db)
    {
        $query = "INSERT INTO listiing_pics(hostel_id, pic) VALUES (?,?)";
        $q = $db->prepare($query);
        $q->execute(array($hostel_id,$pic));
        return "1";
    }


    function getAllMyListings($username,$db)
    {
        $Info = array();
        $data = array();

        $query = "SELECT * FROM listing WHERE username=?";
        $q = $db->prepare($query);
        $q->execute(array($username));

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

    function getAllAgents($db)
    {
        $Info = array();
        $data = array();
        $profile = "manager";

        $query = "SELECT * FROM users WHERE profile=?";
        $q = $db->prepare($query);
        $q->execute(array($profile));

        while($results = $q->fetch(PDO::FETCH_ASSOC))
        {
            $data['name'] = $results['name'];
            $data['email'] = $results['email'];
            $data['phone'] = $results['phone'];

            $Info[] = $data;
        }

        return json_encode($Info);
    }

    function getRecentAgents($db)
    {
        $Info = array();
        $data = array();
        $profile = "manager";

        $query = "SELECT * FROM users WHERE profile=? LIMIT 2";
        $q = $db->prepare($query);
        $q->execute(array($profile));

        while($results = $q->fetch(PDO::FETCH_ASSOC))
        {
            $data['name'] = $results['name'];
            $data['email'] = $results['email'];
            $data['phone'] = $results['phone'];

            $Info[] = $data;
        }

        return json_encode($Info);
    }
}