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

            $queryRoom = "SELECT * FROM listing_rooms WHERE hostel_id=?";
            $qRoom = $db->prepare($queryRoom);
            $qRoom->execute(array($hid));

            $queryFacility = "SELECT * FROM listing_facility WHERE hostel_id=?";
            $qFacility = $db->prepare($queryFacility);
            $qFacility->execute(array($hid));

            $resFacility = $qFacility->fetch(PDO::FETCH_ASSOC);

            $resRoom = $qRoom->fetch(PDO::FETCH_ASSOC);

            $data['facility'] = $resFacility['facility'];
            $data['rooms'] = $resRoom['room'];
            $data['price'] = $resRoom['price'];

            $resPic = $qPic->fetch(PDO::FETCH_ASSOC);

            $data['picture'] = $resPic['pic'];

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
        $room = array();
        $rooms = array();
        $facity = array();
        $facilities = array();
        $services = array();
        $service = array();

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

            $queryRoom = "SELECT * FROM listing_rooms WHERE hostel_id=? ORDER BY room ASC";
            $qRoom = $db->prepare($queryRoom);
            $qRoom->execute(array($hid));

            $queryFacility = "SELECT * FROM listing_facility WHERE hostel_id=?";
            $qFacility = $db->prepare($queryFacility);
            $qFacility->execute(array($hid));

            $queryServices = "SELECT * FROM listing_services WHERE hostel_id=?";
            $qServices = $db->prepare($queryServices);
            $qServices->execute(array($hid));

            WHILE($resRoom = $qRoom->fetch(PDO::FETCH_ASSOC))
            {
                $room['room'] = $resRoom['room'];
                $room['price'] = $resRoom['price'];
                $rooms[] = $room;
            }
            $data['rooms'] = json_encode($rooms);

            WHILE($resFacility = $qFacility->fetch(PDO::FETCH_ASSOC))
            {
                $facility['facility'] = $resFacility['facility'];
                $facilities[] = $facility;
            }

            WHILE($resServices = $qServices->fetch(PDO::FETCH_ASSOC))
            {
                $service['service'] = $resServices['service'];
                $services[] = $service;
            }

            $data['services'] = json_encode($services);
            $data['facilities'] = json_encode($facilities);

            $data['name'] = $resultsM['name'];
            $data['email'] = $resultsM['email'];
            $data['phone'] = $resultsM['phone'];
            $data['profile_pic'] = $resultsM['profile_pic'];

            $Info[] = $data;
        }

        return json_encode($Info);
    }

    function uploadListing($hostelName,$username,$region="",$campus="",$area="",$location="",$phone="",$email="",$long="",$lat="",$description="",$hostelId,$db)
    {
//        echo "hostelId: ".$hostelId." Hostel Name: ".$hostelName." Username: ".$username." Region: ".$region." Campus: ".$campus." Area: ".$area." Location: ".$location." Phone: ".$phone." Email: ".$email." Longitude: ".$long." Latitude: ".$lat." Description: ".$description;
        try{
            $query = "INSERT INTO listing(hostel_id, hostel_name, username, region, campus, area, location, contact_phone, contact_email, long_location, lat_location,description) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
            $q = $db->prepare($query);
            $q->execute(array($hostelId,$hostelName,$username,$region,$campus,$area,$location,$phone,$email,$long,$lat,$description));
        }catch(PDOException $ex)
        {
            echo $ex;
        }

//        return "1";
    }

    function uploadPictures($hostel_id,$pic,$db)
    {
        $query = "INSERT INTO listiing_pics(hostel_id, pic) VALUES (?,?)";
        $q = $db->prepare($query);
        $q->execute(array($hostel_id,$pic));
//        return "1";
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
            $data['description'] = $results['description'];
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
            $data['profile_pic'] = $results['profile_pic'];

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

    function insertServices($hostel_id,$services,$db)
    {
        foreach($services as $value)
        {
            $query = "INSERT INTO listing_services(hostel_id, service) VALUES (?,?)";
            $q = $db->prepare($query);
            $q->execute(array($hostel_id,$value));
        }
    }

    function insertFacility($hostel_id,$facilities,$db)
    {
        foreach($facilities as $value)
        {
            $query = "INSERT INTO listing_facility(hostel_id, facility) VALUES (?,?)";
            $q = $db->prepare($query);
            $q->execute(array($hostel_id,$value));
        }
    }

    function insertRoomPrice($hostel_id,$room,$price,$db)
    {
        $query = "INSERT INTO listing_rooms(hostel_id, room, price) VALUES (?,?,?)";
        $q = $db->prepare($query);
        $q->execute(array($hostel_id,$room,$price));
    }

    function getAdminDetails($db)
    {

    }

    public function getEditDetails($getListingEdit, $db)
    {
        $Info = array();
        $data = array();
        $pics = array();
        $pic = array();
        $room = array();
        $rooms = array();
        $facity = array();
        $facilities = array();
        $services = array();
        $service = array();

        $query = "SELECT * FROM listing WHERE hostel_id=?";
        $q = $db->prepare($query);
        $q->execute(array($getListingEdit));

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

            $queryRoom = "SELECT * FROM listing_rooms WHERE hostel_id=?";
            $qRoom = $db->prepare($queryRoom);
            $qRoom->execute(array($hid));

            $queryFacility = "SELECT * FROM listing_facility WHERE hostel_id=?";
            $qFacility = $db->prepare($queryFacility);
            $qFacility->execute(array($hid));

            $queryServices = "SELECT * FROM listing_services WHERE hostel_id=?";
            $qServices = $db->prepare($queryServices);
            $qServices->execute(array($hid));

            WHILE($resRoom = $qRoom->fetch(PDO::FETCH_ASSOC))
            {
                $room['room'] = $resRoom['room'];
                $room['price'] = $resRoom['price'];
                $rooms[] = $room;
            }
            $data['rooms'] = json_encode($rooms);

            WHILE($resFacility = $qFacility->fetch(PDO::FETCH_ASSOC))
            {
                $facility['facility'] = $resFacility['facility'];
                $facilities[] = $facility;
            }

            WHILE($resServices = $qServices->fetch(PDO::FETCH_ASSOC))
            {
                $service['service'] = $resServices['service'];
                $services[] = $service;
            }

            $data['services'] = json_encode($services);
            $data['facilities'] = json_encode($facilities);

            $data['name'] = $resultsM['name'];
            $data['email'] = $resultsM['email'];
            $data['phone'] = $resultsM['phone'];

            $Info[] = $data;
        }

        return json_encode($Info);
    }

    function deleteListing($hostelId,$db)
    {
        $query = "DELETE  FROM listing WHERE hostel_id=?";
        $q = $db->prepare($query);
        $q->execute(array($hostelId));

        $queryPrice = "DELETE FROM listing_rooms WHERE hostel_id=?";
        $qPrice = $db->prepare($queryPrice);
        $qPrice->execute(array($hostelId));

        $queryService = "DELETE FROM listing_services WHERE hostel_id=?";
        $qService = $db->prepare($queryService);
        $qService->execute(array($hostelId));

        $queryFacility = "DELETE FROM listing_facility WHERE hostel_id=?";
        $qFacility = $db->prepare($queryFacility);
        $qFacility->execute(array($hostelId));

        $queryPics = "DELETE FROM listiing_pics WHERE hostel_id=?";
        $qPics = $db->prepare($queryPics);
        $qPics->execute(array($hostelId));
    }

    public function reserve($id,$username,$price,$room,$db)
    {
        $query = "INSERT INTO listing_reservation(username, hostel_id, room, price) VALUES (?,?,?,?)";
        $q = $db->prepare($query);
        $q->execute(array($username,$id,$room,$price));
    }

    public function getMyReservations($username, $db)
    {
        $Info = array();
        $data = array();

        $query = "SELECT * FROM listing WHERE username=?";
        $q = $db->prepare($query);
        $q->execute(array($username));
        WHILE($res = $q->fetch(PDO::FETCH_ASSOC))
        {
            $hostel_id = $res['hostel_id'];


            $queryRes = "SELECT * FROM listing_reservation WHERE hostel_id=?";
            $qRes = $db->prepare($queryRes);
            $qRes->execute(array($hostel_id));
            WHILE($results = $qRes->fetch(PDO::FETCH_ASSOC))
            {
                $data['hostel_name'] =  $res['hostel_name'];
                $user =  $results['username'];
                $data['room'] = $results['room'];
                $data['price'] = $results['price'];
                $temp = $this->getNameFromUsername($user,$db);
                $data['name'] = $temp['name'];
                $data['phone'] = $temp['phone'];
                $data['email'] = $temp['email'];
                $data['username'] = $user;
                $data['hostel_id'] = $hostel_id;

                $Info[] = $data;
            }
        }

        return json_encode($Info);
    }

    public function getNameFromUsername($username,$db)
    {
        $data = array();

        $query = "SELECT * FROM users WHERE username=? ";
        $q = $db->prepare($query);
        $q->execute(array($username));
        $results = $q->fetch(PDO::FETCH_ASSOC);
        $data['name'] = $results['name'];
        $data['phone'] = $results['phone'];
        $data['email'] = $results['email'];

        return $data;
    }

    public function deleteReservation($user, $hostel_id, $db)
    {
        $query = "DELETE FROM listing_reservation WHERE username=? AND hostel_id=?";
        $q = $db->prepare($query);
        $q->execute(array($user,$hostel_id));

        return "1";
    }
}