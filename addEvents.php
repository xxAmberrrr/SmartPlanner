<?php

    require 'quickstart.php';
    //require 'getEvents.php';
    require 'index.php';

   // $name = 'testTask';
    //$planningTimeAvailable;
    //$deadline = '2017-04-28';
    //$timeNeeding;
   // $daysNeeding = 3;
    //$dateNow = date('Y-m-d');

    //$minTime = '09:00:00';
    //$maxTime = '17:00:00';

    function rand_date($min_date, $max_date, $min_time, $max_time) {
        $min_epoch = strtotime($min_date);
        $max_epoch = strtotime($max_date);
        $min_time_epoch = strtotime($min_time);
        $max_time_epoch = strtotime($max_time);

        $rand_epoch = rand($min_epoch, $max_epoch);
        $rand_time_epoch = rand($min_time_epoch, $max_time_epoch);

        $date = date('Y-m-d', $rand_epoch);
        $time = date('H:i:s', $rand_time_epoch);

        return $date . 'T' . $time;
    }

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

    $scheduleStart = [];
    $scheduleEnd = [];

    for($i = 0; $i < count($queryWork); $i++) {
        array_push($scheduleStart, $queryWork[$i]["start"]);
        array_push($scheduleStart, $queryWork[$i]["end"]);
    }

    for($i = 0; $i < count($querySmartPlanner); $i++) {
        array_push($scheduleStart, $querySmartPlanner[$i]["start"]);
        array_push($scheduleStart, $querySmartPlanner[$i]["end"]);
    }

    for($i = 0; $i < count($querySchool); $i++) {
        array_push($scheduleStart, $querySchool[$i]["start"]);
        array_push($scheduleStart, $querySchool[$i]["end"]);
    }

    for($i = 0; $i < count($querySchedule); $i++) {
        array_push($scheduleStart, $querySchedule[$i]["start"]);
        array_push($scheduleEnd, $querySchedule[$i]["end"]);
    }
    
    function addEvent($eventName, $days, $deadline, $minTime, $maxTime, $scheduleStart, $scheduleEnd) {
        $client = getClient();
        $service = new Google_Service_Calendar($client);

        $calendarId = 'csj8vhvrbdsl01m8vnjihpfve4@group.calendar.google.com';

        for($i = 0; $i < $days; $i++) {
            $dateStart = rand_date(date('Y-m-d'), $deadline, $minTime, $maxTime);
            $dateEnd = date('Y-m-d\TH:i:s',strtotime('+2 hours',strtotime($dateStart)));

            //<-
            $dateStartToTime = new DateTime($dateStart);
            $dateStartUnix = $dateStartToTime->getTimestamp();

            $dateEndToTime = new DateTime($dateEnd);
            $dateEndUnix = $dateEndToTime->getTimestamp();

            $overlap = false;

            $amount = min(count($scheduleStart), count($scheduleEnd));

            for ($j = 0; $j < $amount; $j++)
            {
                $scheduleStartToTime = new DateTime($scheduleStart[$j]);
                $scheduleStartUnix = $scheduleStartToTime->getTimeStamp();
                //var_dump($scheduleStartUnix);

                $scheduleEndToTime = new DateTime($scheduleEnd[$j]);
                $scheduleEndUnix = $scheduleEndToTime->getTimestamp();

                if($dateStartUnix > $scheduleStartUnix && $dateStartUnix < $scheduleEndUnix) {
                    $overlap = true;
                    var_dump($dateStartUnix);
                    var_dump($scheduleStartUnix);
                    var_dump($scheduleEndUnix);
                }

                elseif($dateEndUnix > $scheduleEndUnix && $dateEndUnix < $scheduleEndUnix) {
                    $overlap = true;
                    var_dump($dateStartUnix);
                    var_dump($dateEndUnix);
                    var_dump($scheduleStartUnix);
                    var_dump($scheduleEndUnix);
                }

                elseif($dateStartUnix < $scheduleStartUnix && $dateEndUnix > $scheduleStartUnix) {
                    $overlap = true;
                    var_dump($dateStartUnix);
                    var_dump($scheduleStartUnix);
                    var_dump($dateEndUnix);
                }

                elseif($dateStartUnix < $scheduleEndUnix && $dateEndUnix > $scheduleEndUnix) {
                    $overlap = true;
                    var_dump($dateStartUnix);
                    var_dump($dateEndUnix);
                    var_dump($scheduleEndUnix);
                }
            }

            $event = new Google_Service_Calendar_Event(array(
                'summary' => $eventName . ($overlap? "Overlaps" : "Doesn't overlap"),
                'start' => array(
                    'dateTime' => $dateStart,
                    'timeZone' => 'Europe/Amsterdam',
                ),
                'end' => array(
                    'dateTime' => $dateEnd,
                    'timeZone' => 'Europe/Amsterdam',
                ),
            ));

            if(!$overlap)
            {
                $event = $service->events->insert($calendarId, $event);
                printf('Events have been created');
            }
        }
    }

    addEvent($_POST['taskName'], $_POST['days'], $_POST['deadline'], '09:00:00', '17:00:00', $scheduleStart, $scheduleEnd);



?>