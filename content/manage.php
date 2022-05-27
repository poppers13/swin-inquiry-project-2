
<!DOCTYPE html>
<html lang="en">
    <head>
		<!-- import Bootstrap CSS -->
	        <!-- Bootstrap CSS -->
            <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    
        <!-- site-wide stylesheet -->
        <link rel = "stylesheet" type = "text/css" href = "styles/style.css">
        
        <!-- metadata -->
        <title>Cookies and Sessions - Enhancements</title>
        <meta charset="UTF-8">
        <meta name="description" content="The management page for the admin">
        <meta name="keywords" content="cookies, sessions, education, swinburne, enhancements, extra">
        <meta name="author" content="Aidan Davies, Jesh Kumar, Dylan Lewis, Nimash Rathnayake, Kasun Jayawardhana">
    </head>
    
        <body>
            <?php include 'menu.inc'; ?>
            <?php include_once "header.inc"; ?>

            <h1>Manage</h1>

            <div class="content-block">
                <h2>All Entries</h2>
                <?php 
                if (!isset($_POST["search"])){
                    
                    $query = "SELECT * FROM quiz_attempts";
                }
                else 
                {               
                    $student_id = trim ($_POST["student_id"]);
                    $first_name = trim ($_POST["first_name"]);
                    $last_name = trim ($_POST["last_name"]);
                    
                    $query = "SELECT * FROM quiz_attempts WHERE student_id LIKE '%$student_id%' AND first_name LIKE '%$first_name%' AND last_name LIKE '%$last_name%'";
                }

                if(isset($_POST["full"])){

                    $query = "SELECT * FROM quiz_attempts WHERE score = 5 AND attempt_num = 1 ";
                }

                if(isset($_POST["half"])){

                    $query = "SELECT * FROM quiz_attempts WHERE score < 3 AND attempt_num = 2 ";
                }

                if(isset($_POST["delete"])){
                    ini_set('display_errors', '0');
                    $student_id = trim ($_POST["student_id"]);
                    $query1 = "DELETE FROM quiz_attempts WHERE student_id = $student_id ";

                    require_once ("db_settings.php");
                    $sql_db = @mysqli_connect($host, $user, $pwd, $db_name);
                    $result = mysqli_query($sql_db,$query1) ;
                    

                    if ($result)
                        echo "<p>Delete successful There are ". mysqli_affected_rows($sql_db). " record/s deleted</p>";
                    else 
                        echo "<p> Delete unsuccessful </p>";
                    mysqli_close($sql_db);
                    
                }
                if(isset($_POST["update"]))
                {               
                    ini_set('display_errors', '0');
                    $student_id = trim ($_POST["student_id"]);
                    $attempt_num = trim ($_POST["attempt_num"]);
                    $score = trim ($_POST["score"]);
                    
                    
                    $query1 = "UPDATE quiz_attempts SET score = $score WHERE student_id = $student_id ANd attempt_num = $attempt_num";
                    require_once ("db_settings.php");
                    $sql_db = @mysqli_connect($host, $user, $pwd, $db_name);
                    $result = mysqli_query($sql_db,$query1) ;
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
                                echo "<table border='1'>";
                                echo "<tr><th>Attempt ID</th><th>Attempt Date</th><th>First Name</th><th>Last Name</th><th>Student ID</th><th>Attempt Number</th><th>Score</th></tr>";
                                while ($record) {
                                    echo "<tr><td>{$record['attempt_id']}</td>";
                                    echo "<td>{$record['attempt_date']}</td>";
                                    echo "<td>{$record['first_name']}</td>";
                                    echo "<td>{$record['last_name']}</td>";
                                    echo "<td>{$record['student_id']}</td>";
                                    echo "<td>{$record['attempt_num']}</td>";
                                    echo "<td>{$record['score']}</td></tr>";
                                    $record = mysqli_fetch_assoc($result);
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
            </body>
            <h2> Search based on Student </h2>
            <form action = "manage.php" method ="post">
                    <p><label> Student ID: <input type="text" name= "student_id" /> </label></p>
                    <p><label> First Name: <input type="text" name= "first_name" /> </label></p>
                    <p><label> Last Name: <input type="text" name= "last_name" /> </label></p>
                    
                    <input type = "submit" name = "search" value ="Search"/>
            </form>    
            <br>    
            <form action = "manage.php" method ="post">
            
                    <input type = "submit" name = "full" value ="Show students with 100% on first attempt"/>
                </form>
                <br>      
            <form action = "manage.php" method ="post">
                <input type = "submit" name = "half" value ="Show students with below 50% on second attempt"/>
            </form>

            <h2>Delete an entry</h2>
            <form action = "manage.php" method ="post">
                    <p><label> Student ID: <input type="text" name= "student_id" /> </label></p>
                    <input type = "submit" name = "delete" value ="Delete"/>
            </form>
            <h2>Update score for a student</h2>
            <form action = "manage.php" method ="post">
                    <p><label> Student ID: <input type="text" name= "student_id" /> </label></p>
                    <p><label> Attempt number: <input type="text" name= "attempt_num" /> </label></p>
                    <p><label> Score: <input type="text" name= "score" /> </label></p>
                    <input type = "submit" name = "update" value ="update"/>
            </form>
        </div>
    <?php include_once "footer.inc"; ?>
</html>