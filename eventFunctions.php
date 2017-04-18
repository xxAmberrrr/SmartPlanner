<?php

    require 'quickstart.php';

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
    
    function addEvent($eventName, $days, $deadline, $minTime, $maxTime) {
        $client = getClient();
        $service = new Google_Service_Calendar($client);

        $calendarId = 'csj8vhvrbdsl01m8vnjihpfve4@group.calendar.google.com';

        for($i = 0; $i < $days; $i++) {
            $dateStart = rand_date(date('Y-m-d'), $deadline, $minTime, $maxTime);

            $event = new Google_Service_Calendar_Event(array(
                'summary' => $eventName,
                'start' => array(
                    'dateTime' => $dateStart,
                    'timeZone' => 'Europe/Amsterdam',
                ),
                'end' => array(
                    'dateTime' => date('Y-m-d\TH:i:s',strtotime('+2 hours',strtotime($dateStart))),
                    'timeZone' => 'Europe/Amsterdam',
                ),
            ));

            $event = $service->events->insert($calendarId, $event);
            printf('Event(s) created: %s\n', $event->htmlLink);
        }
    }

    function getEvents() {
        $client = getClient();
        $service = new Google_Service_Calendar($client);


        //List of calendars
        $calendarList = $service->calendarList->listCalendarList();

        $calendars = array(); //Empty array for calendars
        $calendarsSelected = array(); //Empty array for selected calendars

        array_push($calendarsSelected, '228iua7de1js8if439cgsgk4dc@group.calendar.google.com'); //MT3C
        //array_push($calendarsSelected, 'xxamberrrr12@gmail.com'); //Amber Hoogland
        array_push($calendarsSelected, 'ihl73aqpljlu9u67srth0657s8@group.calendar.google.com'); //School
        array_push($calendarsSelected, 'csj8vhvrbdsl01m8vnjihpfve4@group.calendar.google.com'); //SmartPlanner
        array_push($calendarsSelected, 'k6m04v2tp7ortm5ol5kg8clkuk@group.calendar.google.com'); //Werk

        //Params to filter
        $optParams = array(
        'orderBy' => 'starttime',
        'singleEvents' => TRUE,
        'timeMin' => date('c'),
        'showDeleted' => FALSE,
        ); 

        while(true) {
        //use calendarsSelected when interface is ready
        // foreach ($calendarList->getItems() as $calendarListEntry) {
        //   array_push($calendarsSelected, $calendarListEntry->getId());
        // }

        //For every calendar in calendarsSelected show the events
        for($i = 0; $i < count($calendarsSelected); $i++) {
            $results = $service->events->listEvents($calendarsSelected[$i], $optParams);

            foreach($results->getItems() as $event) {
            $start = null;
            $end = null;

            if(isset($event->start->dateTime)) {
                $start = $event->start->dateTime;
            }

            if(isset($event->end->dateTime)) {
                $end = $event->end->dateTime;
            }

            if(empty($start)) {
                if(isset($event->start->date)) {
                    $start = $event->start->date;
                }
            }
            
            if(empty($end)) {
                if(isset($event->end->date)) {
                    $end = $event->end->date;
                }
            }

            return $start;
            //printf("%s (%s)(%s)\n", $event->getSummary(), $start, $end);
            }
        }

        $pageToken = $calendarList->getNextPageToken();

        if ($pageToken) {
            $optParams = array('pageToken' => $pageToken);
            $calendarList = $service->calendarList->listCalendarList($optParams);
        } 

        else {
            break;
        }
        }
    }

?>