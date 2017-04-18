<?php

    require 'eventFunctions.php';

     $client = getClient();
     $service = new Google_Service_Calendar($client);

    //getEvents();

    //$eventName, $days, $deadline, $minTime, $maxTime
    //addEvent('Amber test 2', 3, '2017-04-28', '09:00:00', '17:00:00');

    $freebusy = new Google_Service_Calendar_FreeBusyRequest();
    $freebusy->setTimeMin("2017-04-18T13:00:00+01:00");
    $freebusy->setTimeMax("2017-04-28T13:00:00+01:00");
    $freebusy->setTimeZone('Europe/Amsterdam');

    $item = new Google_Service_Calendar_FreeBusyRequestItem();
    $item->setId('ihl73aqpljlu9u67srth0657s8@group.calendar.google.com');

    $freebusy->setItems(array($item));

    $query = $service->freebusy->query($freebusy);


    var_dump($query);

?>