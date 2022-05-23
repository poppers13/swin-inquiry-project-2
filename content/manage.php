
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
    <section class="content-block">
        <body>
            <?php include 'menu.inc'; ?>
            <?php               
                include_once "header.inc";        
            ?>
            <h2>All Entries </h2>
            <?php 
            if (!isset($_POST["student_id"])){
                echo"<p>Connection succesful!</p>";
                $query = "SELECT * FROM quiz_attempts";
            }
            else 
            {
                
                $student_id = trim ($_POST["student_id"]);
                
                
                $query = "SELECT * FROM quiz_attempts WHERE student_id LIKE '%$student_id%'";

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
                            echo "<table border = '1'>";
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
        <h2> Search based on name </h2>
        <form action = "manage.php" method ="post">
                <p><label> Student ID: <input type="text" name= "student_id" /> </label></p>
                
                <input type = "submit" value ="Search"/>
        </form>
    </section>
    <?php include_once "footer.inc"; ?>
</html>