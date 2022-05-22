
<!DOCTYPE html>
<html lang="en">
    <head>
		<!-- import Bootstrap CSS -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
        
        <!-- site-wide stylesheet -->
        <link rel = "stylesheet" type = "text/css" href = "styles/style.css">
        
        <!-- metadata -->
        <title>Cookies and Sessions - Manage</title>
        <meta charset="UTF-8">
        <meta name="description" content="The management page for the admin">
        <meta name="keywords" content="cookies, sessions, education, swinburne, enhancements, extra">
        <meta name="author" content="Aidan Davies, Jesh Kumar, Dylan Lewis, Nimash Rathnayake, Kasun Jayawardhana">
    </head>

        <body>
            <!-- sticky menu bar, with navigation links to other pages -->
            <?php include 'menu.inc'; ?>

            <!-- header contains school logo, and info relating to the page's creation -->
            <?php include 'header.inc'; ?>
            
            <h1>Manage Records</h1>

            <div class="content-block">
                <h2>All Entries</h2>
                <?php

                    if (isset($_POST["fsearch"]))
                    {
                        $first_name = trim ($_POST["first_name"]);
                        $last_name = trim ($_POST["last_name"]);
                        $student_id = trim ($_POST["student_id"]);

                        $query = "SELECT * FROM quiz_attempts WHERE first_name LIKE '%$first_name%' AND last_name LIKE '%$last_name%' AND student_id LIKE '%$student_id%'";
                    }
                    
                    else if (isset($_POST["ffull"]))
                    {
                        $query = "SELECT * FROM quiz_attempts WHERE score= 100 AND attempt_num = 1";
                    }
                    else if (isset($_POST["fhalf"]))
                    {
                        $query = "SELECT * FROM quiz_attempts WHERE score< 50 AND attempt_num = 2";
                    }
                    else if (isset($_POST["fdelete"]))
                    {
                        $student_id = $_POST["student_id"];
                        $query = "DELETE FROM quiz_attempts WHERE student_id=$student_id";
                    }
                    else if (isset($_POST["fupdate"]))
                    {
                        $student_id = $_POST["student_id"];
                        $score = $_POST["score"];
                        $query = "UPDATE quiz_attempts SET score = '$score' WHERE student_id=$student_id";
                    }

                    else {
                        $query = "SELECT * FROM quiz_attempts ";
                    }

                    // connect to the SQL database
                    require_once ("db_settings.php");
                    $sql_db = @mysqli_connect($host, $user, $pwd, $db_name);
                    if ($sql_db)
                    {
                        //echo"<p>Connection succesful!</p>";
                        
                        $result = mysqli_query($sql_db, $query);

                        if ($result){
                            //echo "<p>select succesful</p>";
                            $record = mysqli_fetch_assoc ($result);
                            if ($record) {
                                echo "<table border='1' >";
                                echo "<tr> <th class='alternative-th'>Attempt Id</th> <th class='alternative-th'>Attempt Date</th> <th class='alternative-th'>First Name</th> <th class='alternative-th'>Last Name</th> <th class='alternative-th'>Student ID</th> <th class='alternative-th'>Score</th> <th class='alternative-th'>Number of Attempts</th> </tr>";
                                while ($record){
                                    echo "<tr class='alternative-tr'><td>{$record['attempt_id']}</td>";
                                    echo "<td class='alternative-td'>{$record['attempt_date']}</td>";
                                    echo "<td class='alternative-td'>{$record['first_name']}</td>";
                                    echo "<td class='alternative-td'>{$record['last_name']}</td>";
                                    echo "<td class='alternative-td'>{$record['student_id']}</td>";
                                    echo "<td class='alternative-td'>{$record['score']}</td>";
                                    echo "<td class='alternative-td'>{$record['attempt_num']}</td></tr>";
                                    $record = mysqli_fetch_assoc ($result);
                                }
                                echo "</table>";
                                mysqli_free_result($result);
                            }
                            else 
                                echo "<p>No attempts recorded</p>";    
                        }
                        else {
                            echo "<p>select unsuccesful.</p>";
                        }
                        mysqli_close($sql_db);
                    }
                    else {
                        echo "<p>Connection failed!</p>";
                    }
                ?>
            
                <h2>Search Student</h2>
                <form action = "manage.php" method = "post">
                    <p><label>First name: <input type = "text" name ="first_name"/></label></p>
                    <p><label>Last name: <input type = "text" name = "last_name"/></label></p>
                    <p><label> Student ID: <input type = "text" name ="student_id"/></label></p>
                    <input type="submit" name ="fsearch" value= "Search"/>
                </form>

                <h2> Show all students with 100% on first attempt</h2>
                <form>
                    <input type = "submit" name ="ffull" value = "Search">
                </form>

                <h2> Show all students with over 50% on second attempt</h2>
                <form>
                    <input type = "submit" name ="fhalf" value = "Search">
                </form>

                <h2> Delete all attempts of a student </h2>
                <form>
                    <p><label>Student ID <input type = "text" name = "student_id"/></label></p>
                    <input type = "submit" name ="fdelete" value = "Delete"/>
                </form>

                <h2> Update quiz score </h2>
                <form>
                    <p><label>Student ID <input type = "text" name = "student_id"/></label></p>
                    <p><label>New Score <input type ="text" name = "score"/></label></p>
                    <input type = "submit " name ="fupdate" value = "Update"/>
                </form>
        </div>
    </body>
</html>