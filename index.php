<!DOCTYPE html>

<html>

    <head>

        <title>Smart Planner</title>

    </head>

    <body>

        <form action="getEvents.php">
            <input type="submit" value="Get your events"/>
        </form>

        <br>
        <br>

        <form action="getFreeBusy.php">
            <input type="submit" value="Get your busy time data"/>
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
            <input type="submit" value="Insert a event"/>
        </form>

    </body>

</html>