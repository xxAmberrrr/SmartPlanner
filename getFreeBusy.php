<?php

    require 'eventFunctions.php';

    $client = getClient();
    $service = new Google_Service_Calendar($client);

    $freebusy = new Google_Service_Calendar_FreeBusyRequest();
    $freebusy->setTimeMin("2017-04-18T13:00:00+01:00");
    $freebusy->setTimeMax("2017-04-28T13:00:00+01:00");
    $freebusy->setTimeZone('Europe/Amsterdam');

    $workCal = new Google_Service_Calendar_FreeBusyRequestItem();
    $workCal->setId('k6m04v2tp7ortm5ol5kg8clkuk@group.calendar.google.com');

    $smartPlannerCal = new Google_Service_Calendar_FreeBusyRequestItem();
    $smartPlannerCal->setId('csj8vhvrbdsl01m8vnjihpfve4@group.calendar.google.com');

    $schoolCal = new Google_Service_Calendar_FreeBusyRequestItem();
    $schoolCal->setId('ihl73aqpljlu9u67srth0657s8@group.calendar.google.com');

    $scheduleCal = new Google_Service_Calendar_FreeBusyRequestItem();
    $scheduleCal->setId('228iua7de1js8if439cgsgk4dc@group.calendar.google.com');

    $freebusy->setItems(array($workCal, $smartPlannerCal, $schoolCal, $scheduleCal));

    $query = $service->freebusy->query($freebusy);

    $queryWork = $query->getCalendars()["k6m04v2tp7ortm5ol5kg8clkuk@group.calendar.google.com"]["modelData"]["busy"];
    $querySmartPlanner = $query->getCalendars()["csj8vhvrbdsl01m8vnjihpfve4@group.calendar.google.com"]["modelData"]["busy"];
    $querySchool = $query->getCalendars()["ihl73aqpljlu9u67srth0657s8@group.calendar.google.com"]["modelData"]["busy"];
    $querySchedule = $query->getCalendars()["228iua7de1js8if439cgsgk4dc@group.calendar.google.com"]["modelData"]["busy"];

    for($i = 0; $i < count($queryWork); $i++) {
        var_dump($queryWork[$i]["start"]);
        var_dump($queryWork[$i]["end"]);
    }

    for($i = 0; $i < count($querySmartPlanner); $i++) {
        var_dump($querySmartPlanner[$i]["start"]);
        var_dump($querySmartPlanner[$i]["end"]);
    }

    for($i = 0; $i < count($querySchool); $i++) {
        var_dump($querySchool[$i]["start"]);
        var_dump($querySchool[$i]["end"]);
    }

    for($i = 0; $i < count($querySchedule); $i++) {
        var_dump($querySchedule[$i]["start"]);
        var_dump($querySchedule[$i]["end"]);
    }

    //var_dump($queryWork);
    //var_dump($querySmartPlanner);
    //var_dump($querySchool);
    //var_dump($scheduleCal);

?>