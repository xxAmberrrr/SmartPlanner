<?php
    require 'quickstart.php';
    
    // Get the API client and construct the service object.
    $client = getClient();
    $service = new Google_Service_Calendar($client);


    //List of calendars
    $calendarList = $service->calendarList->listCalendarList();

    $calendars = array(); //Empty array for calendars
    $calendarsSelected = array(); //Empty array for selected calendars

    array_push($calendarsSelected, '228iua7de1js8if439cgsgk4dc@group.calendar.google.com'); //MT3C
    array_push($calendarsSelected, 'xxamberrrr12@gmail.com'); //Amber Hoogland
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

        if(isset($event->start->dateTime)) {
            $start = $event->start->dateTime;
        }

        if(empty($start)) {
            if(isset($event->start->date)) {
            $start = $event->start->date;
            }
        }

        printf("%s (%s)\n", $event->getSummary(), $start);
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
?>