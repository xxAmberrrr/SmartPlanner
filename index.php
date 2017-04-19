<?php

    require 'eventFunctions.php';

     $client = getClient();
     $service = new Google_Service_Calendar($client);

    //getEvents();

    //$eventName, $days, $deadline, $minTime, $maxTime
    //addEvent('Amber test 2', 3, '2017-04-28', '09:00:00', '17:00:00');

//    $params = array(
//        'body' => json
//
//        'timeMax' => '2017-04-28T13:00:00+01:00',
//        'timeMin' => '2017-04-18T13:00:00+01:00',
//        'timeZone' => 'Europe/Amsterdam',
//        'items' => array(
//            [
//                 'id' => 'ihl73aqpljlu9u67srth0657s8@group.calendar.google.com',
//            ],
//        ),
//    );
//
//    $newParams = json_encode($params);
//
//    //print($newParams);
//
//    $request = new Google_Service_Calendar_FreeBusyRequest();
//
//    $result = $service->freebusy->query($request, $params);
//
//
//    $freebusy = new Google_Service_Calendar_FreeBusyRequest();
//
//    $query = $service->freebusy->query($freebusy, $newParams);
//
//    $newQuery = json_decode($query);
//
//    print($newQuery);


    $freebusy = new Google_Service_Calendar_FreeBusyRequest();
    $freebusy->setTimeMin("2017-04-18T13:00:00+01:00");
    $freebusy->setTimeMax("2017-04-28T13:00:00+01:00");
    $freebusy->setTimeZone('Europe/Amsterdam');

    $item = new Google_Service_Calendar_FreeBusyRequestItem();
    $item->setId('ihl73aqpljlu9u67srth0657s8@group.calendar.google.com');

    $freebusy->setItems(array($item));

    $query = $service->freebusy->query($freebusy);

    echo json_encode($query);


//    $date_from = '2017-04-18T13:00:00+01:00';
//    $date_to = '2017-04-28T13:00:00+01:00';
//
//    $freebusy_req = new Google_Service_Calendar_FreeBusyRequest();
//    $freebusy_req->setTimeMin(date(DateTime::ATOM, strtotime($date_from)));
//    $freebusy_req->setTimeMax(date(DateTime::ATOM, strtotime($date_to)));
//    $freebusy_req->setTimeZone('Europe/Amsterdam');
//    $item = new Google_Service_Calendar_FreeBusyRequestItem();
//    $item->setId('ihl73aqpljlu9u67srth0657s8@group.calendar.google.com');
//    $freebusy_req->setItems(array($item));
//    $query = $service->freebusy->query($freebusy_req);
//
//    echo json_encode($query);
?>