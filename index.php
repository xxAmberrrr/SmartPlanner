<!DOCTYPE html>

<html>

    <head>

        <title>Smart Planner</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    </head>

    <body>

        <form action="getEvents.php">
            <input type="submit" class="btn btn-primary" value="Get your events"/>
        </form>

        <br>
        <br>

        <form action="getFreeBusy.php">
            <input type="submit" class="btn btn-primary" value="Get your busy time data"/>
        </form>

        <br>
        <br>

        <form action="addEvents.php" method="POST">
            Task name:
            <br>
            <input type="name" name="taskName"/>
            <br>
            How many days do you want to work on this task?
            <br>
            <input type="number" name="days"/>
            <br>
            Deadline:
            <br>
            <input type="date" name="deadline"/>
            <br>
            <br>
            <input type="submit" value="Insert a event" class="btn btn-primary"/>
        </form>

    </body>

</html>