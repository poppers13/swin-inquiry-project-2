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
            $score = 0;
            $question_1 = "";
            $question_2 = "";
            $question_3 = "";
            $question_4 = "";
            $question_5 = "";

            // Checking if all student details are filled in and then continuing to put values from HTML form into PHP code
            if (isset ($_POST["firstname"]) && ($_POST["firstname"]!="")) {
                $first_name = $_POST["firstname"];
            }
                
            if (isset ($_POST["lastname"]) && ($_POST["lastname"]!="")) {
                $last_name = $_POST["lastname"];
            }
                
            if (isset ($_POST["studentid"]) && ($_POST["studentid"]!="")) {
                $student_id = $_POST["studentid"];
            }

            // Checking if all questions are filled in and then continuing to put values from HTML form into PHP code
            
            // Q1. TEXT
            if (isset ($_POST["alternatives-text"]) && ($_POST["alternatives-text"]!="")) {
                $question_1 = $_POST["alternatives-text"];
            }

            // Q2. RADIO
            if (isset ($_POST["definition-radio"])) {
                $question_2 = $_POST["definition-radio"];
            }
            else {
                $question_2 = "Answer not filled in";
            }

            // Q3. CHECKBOX
            if (isset ($_POST["checkbox-function1"]))
                $question_3 = $_POST["checkbox-function1"];
            if (isset ($_POST["checkbox-function2"]))
                $question_3 = $_POST["checkbox-function2"];
            if (isset ($_POST["checkbox-function3"]))
                $question_3 = $_POST["checkbox-function3"];
            if (isset ($_POST["checkbox-function4"]))
                $question_3 = $_POST["checkbox-function4"];
            if (isset ($_POST["checkbox-function5"]))
                $question_3 = $_POST["checkbox-function5"];
            if (isset ($_POST["checkbox-function6"]))
                $question_3 = $_POST["checkbox-function6"];

            // Q4. DROPDOWN
            if (isset ($_POST["history-dropdown"]) && ($_POST["history-dropdown"]!="")) {
                $question_4 = $_POST["history-dropdown"];
            }

            // Q5. NUMBER
            if (isset ($_POST["q5num"]) && ($_POST["q5num"]!="")) {
                $question_5 = $_POST["q5num"];
            }

            // Question marking
            $errMsg = "";

            if ($question_1 == "Data that rarely changes") {
                $score = $score + 1;
            }
            else {
                $errMsg .= "<p>Incorrect. The correct answer is: 'data that rarely changes'</p>";
            }

            if ($question_2 == "defintion-radio1") {
                echo "<p>Correct!</p>";
                $score = $score + 1;
            }
            else {
                $errMsg .= "<p>Incorrect. The correct answer is 'False'</p>";
            }

            if ($question_3 == "checkbox-function3" && $question_3 == "checkbox-function5" && $question_3 == "checkbox-function6") {
                echo "<p>Correct!</p>";
                $score = $score + 1;
            }
            else {
                $errMsg .= "<p>Incorrect. Please select ALL correct answers: 'Personalisation, Tracking & Authorisation'</p>";
            }

            if ($question_4 == "Financial Times") {
                echo "<p>Correct!</p>";
                $score = $score + 1;
            }
            else {
                $errMsg .= "<p>Incorrect. The correct answer is: 'Financial Times'</p>";
            }

            if ($question_5 == 30) {
                echo "<p>Correct!</p>";
                $score = $score + 1;
            }
            else {
                $errMsg .= "<p>Incorrect. The correct answer is: '30' minutes</p>";
            }

            // conditions if the connection isn't made
            if (!$sql_db) {
                echo "<p>Database connection failure!</p>";
            }
            else {
                $sql_table="quiz_attempts";

                // need to check if the fields in the form have been entered or not using validation
                
            /* VALIDATION OF ALL QUESTIONS & STUDENT DETAILS */

            //Sanitising function
            function sanitise_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
                }
                
            if (isset($_POST["studentid"])){
            $err_msg = "";

            $student_id = $_POST["studentid"];
            $first_name = $_POST["firstname"];
            $last_name = $_POST["lastname"];
            
            //Student ID
            if (trim($student_id)=="")
                $err_msg .= "<p>Please enter your Student ID</p>";
            
            else
                $student_id = sanitise_input ($student_id);
                if (!preg_match("/^[0-9]{7,10}+$/",$student_id))
                    $err_msg .= "<p>Should be numbers and between 7 - 10</p>";

            //First name
            if (trim($first_name)=="")
                $err_msg .= "<p>Please enter first name</p>";
            
            else
                $first_name = sanitise_input ($first_name);
                if (!preg_match("/^[a-zA-Z'-_ ]{1,30}+$/",$first_name))
                    $err_msg .= "<p>Maximum 30 letters ,[space], hyphen characters.</p>";


            //Last name
            if (trim($last_name)=="")
                $err_msg .= "<p>Please enter last name</p>";
            
            else
                $last_name = sanitise_input ($last_name);
                if (!preg_match("/^[a-zA-Z'-_ ]{1,30}+$/",$last_name))
                    $err_msg .= "<p>Maximum 30 letters ,[space], hyphen characters.</p>";
            }
    
            //Error msg

            if ($err_msg!="")
                echo $err_msg;
            
            }
                
                /* Conditions for the number of attempts
                if ($attempt_num < 2) {
                    // allow for the person to retake quiz
                }
                else {
                    header("location: retry.html");
                }
                */

                $query = "INSERT INTO $sql_table (attempt_id, attempt_date, first_name, last_name, student_id, attempt_num) 
                VALUES ('$attempt_id' , '$attempt_date' , '$first_name' , '$last_name' , '$student_id' , '$attempt_num', '$score' )";

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