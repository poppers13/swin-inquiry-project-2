<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- import Bootstrap CSS -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
        
        <!-- site-wide stylesheet -->
        <link rel = "stylesheet" type = "text/css" href = "styles/style.css">
        
        <!-- metadata -->
        <title>Cookies and Sessions Quiz</title>
        <meta charset="UTF-8">
        <meta name="description"    content="How to navigate this web page">
        <meta name="keywords"       content="cookies, sessions, education, swinburne, home, menu">
        <meta name="author"         content="Aidan Davies, Jesh Kumar, Dylan Lewis, Nimash Rathnayake, Kasun Jayawardhana">
    </head>

    <body>
        <?php
            // connect to the SQL database
            require_once ("db_settings.php");
            $sql_db = @mysqli_connect($host, $user, $pwd, $db_name);
            
            // declaring all field information as empty strings to add information into them later
            $attempt_id = "";
            $attempt_date = "";
            $first_name = "";
            $last_name = "";
            $student_id = "";
            $attempt_num = "";
            $score = "";

            // declaring all questions as empty strings so that things can be added to them
            $question_1 = "";
            $question_2 = "";
            $question_3 = "";
            $question_4 = "";
            $question_5 = "";

            // checking if all of the variables are set before being used
            // these lines will put the values from the html form into the php code so that we can use them here.
            if (isset ($_POST["firstname"]) && ($_POST["firstname"]!="")) {
                $first_name = $_POST["firstname"];
            }
                
            if (isset ($_POST["lastname"]) && ($_POST["lastname"]!="")) {
                $last_name = $_POST["lastname"];
            }
                
            if (isset ($_POST["studentid"]) && ($_POST["studentid"]!="")) {
                $student_id = $_POST["studentid"];
            }

            if (isset ($_POST["yom"]) && ($_POST["yom"]!="")) {
                $last_name = $_POST["yom"];
            }
            if (isset ($_POST["yom"]) && ($_POST["yom"]!="")) {
                $attempt_num = $_POST["yom"];
            }

            // conditions if the connection isn't made
            if (!$sql_db) {
                echo "<p>Database connection failure!</p>";
            }
            else {
                $sql_table="quiz_attempts";

                // need to check if the fields in the form have been entered or not using validation
                
                /* VALIDATION OF ALL QUESTIONS & STUDENT DETAILS FROM NIMASH */

                $query = "INSERT INTO $sql_table (attempt_id, attempt_date, first_name, last_name, student_id, attempt_num) 
                VALUES ('$attempt_id' , '$attempt_date' , '$first_name' , '$last_name' , '$student_id' , '$attempt_num' )";

                // the query that we wrote will now go to the database and send that query and receive the results inside of the result variable
                $result = mysqli_query($sql_db, $query);

                // if the result isn't successful then show an error message, otherwise give a message that it has worked
                if (!$result) {
                    echo "<p>Something is wrong with " , $query , "</p>";
                } 
                else {
                    echo "<p>Successfully added new question attempt!</p>";
                }
            mysqli_close($sql_db);
            }
            
        ?>
    </body>

</html>