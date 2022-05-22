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
        <section class="content-block">
            <?php
                // connect to the SQL database
                require_once ("db_settings.php");
                $sql_db = @mysqli_connect($host, $user, $pwd, $db_name);
                
                // declaring all field information as empty strings to add information into them later
                $attempt_id = "";
                $attempt_date = date("Y-m-d H:i:s"); 

                $first_name = "";
                $last_name = "";
                $student_id = "";
                $attempt_num = 0;

                // declaring all questions as empty strings so that things can be added to them
                $score = 0;

                // retrieving the list of questions and putting into an associative array
                $result = mysqli_query($sql_db, "SELECT * FROM quiz_questions");
                $questions = mysqli_fetch_all($result, MYSQLI_ASSOC);
                $question_names = array();
                $question_type = array();

                foreach ($questions as $field) {
                    // this $q_name will contain all of the names for the questions to be used in code ahead
                    $q_name = $field['name'];
                    $q_type = $field['type'];
                    // putting each of the names from the loop into the $question_names array
                    array_push($question_names, $q_name);
                    array_push($question_type, $q_type);
                }

                /* assigning all of the question names and adapts to how many questions there are  the extract 
                function will take out each of the values from the $question_names array and assign it to a new variable
                with the prefix of name_[i]
                we can now access each question name by using these depending on how many questions there are (8 questions)
                */ 
                for ($i = 1; $i <= count($question_names); $i++) {
                    extract($question_names, EXTR_PREFIX_ALL, "name");
                }

                echo $name_1;

                for ($i = 1; $i <= count($question_type); $i++) {
                    extract($question_names, EXTR_PREFIX_ALL, "type");
                }
                // need to make array with entire database
                // need an array with question string exploded to get each question out

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

                    // Checking if all questions are filled in and then continuing to put values             // Q1. TEXT
                $question_1 = "";
                    $score = "0";
                    $score = intval($score);
                 if (isset($_POST["alternatives-text"])){
                    $question_1 = $_POST["alternatives-text"];
                        if ($question_1 == "storing the data of the user to be used again" + "storing data"){ 
                                //will probably add more to this at another time so there can be more variety in correct responses. but for now i think these two answers will make do.
                        echo "<p>Correct - 1/1 marks.</p>";
                        $score = $score + 1;
                        } else {
                        echo "<p>Incorrect - 0/1 marks.</p>";
                    }
                }
               // Q2. RADIO
                $score = intval($score); //intval makes it an int so 1+1 correct marks = 2 and not 11 by adding strings if that makes sense
                 if (isset($_POST["definition-radio"])){
                    $question_2 = $_POST["definition-radio"];
                        if ($question_2 == "definition-radio1"){
                             echo "<p>Correct - 1/1 marks.</p>";
                        $score = $score + 1;
                        } else {
                        echo "<p>Incorrect - 0/1 marks.</p>";
                    }
                }
                // Q3. CHECKBOX
                $score = intval($score);
                 if (in_array("checkbox-function3", $_POST["function-checkbox"])){
                        echo "<p>Correct, Cookies are used to personalise a user's web experience - 1/1 marks.</p>";
                        $score = $score + 1;
                    }
                 if (in_array("checkbox-function5", $_POST["function-checkbox"])){
                        echo "<p>Correct, Cookies are used in tracking users web activity - 1/1 marks.</p>";
                        $score = $score + 1;
                    }
                 if (in_array("checkbox-function6", $_POST["function-checkbox"])){
                        echo "<p>Correct, cookies do assist with authorisation - 1/1 marks.</p>";
                        $score = $score + 1;
                    }
                else {
                        echo "<p>Incorrect - 0/1 marks.</p>";
                }

                // Q4. DROPDOWN
                $score = intval($score);
                     if (isset($_POST["history-dropdown"])){
                      $question_4 = $_POST["history-dropdown"];
                           if ($question_4 == "history-dropdown2"){
                              echo "<p>Correct, the financial times declared that cookies were dangerous - 1/1 marks.</p>";
                               $score = $score + 1;
                         } else {
                    echo "<p>Incorrect - 0/1 marks.</p>";
                }
            }
                // Q5. NUMBER
                $score = intval($score);
                     if (isset($_POST["question_5num"])){
                         $question_5 = $_POST["question_5num"];
                              if ($question_5 == "30"){
                             echo "<p>Correct, the default time period for a cookie to expire is 30 minutes - 1/1 marks.</p>";
                             $score = $score + 1;
                        } else {
                        echo "<p>Incorrect, it takes 30 minutes for a cookie to timeout by default - 0/1 marks.</p>";
                    }
                }

                echo "<p>Your score for this quiz was $score out of 7 </p>"; // will implement this later when i have made random question gen to get a percent from test and i will do some tidying up when i come back to this after random question maker is done.($score/7*100 %)//

                // Conditions for the number of attempts once all of the inputs have been validated 
                if (isset($_POST['firstname'])) {
                    if (isset($_POST['lastname'])) {
                        if (isset($_POST['studentid'])) {
                            $attempt_num = $attempt_num + 1;
                        }
                    }
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
                $err_msg .= "<p>Please enter your Student ID.</p>";
            
            else
                $student_id = sanitise_input ($student_id);
                if (!preg_match("/^[0-9]{7,10}+$/",$student_id))
                    $err_msg .= "<p>Student ID can only contain numbers and length between 7 - 10.</p>";

            //First name
            if (trim($first_name)=="")
                $err_msg .= "<p>Please enter your First name.</p>";
            
            else
                $first_name = sanitise_input ($first_name);
                if (!preg_match("/^[a-zA-Z'-_ ]{1,30}+$/",$first_name))
                    $err_msg .= "<p>First name can only contain Maximum 30 letters ,[space], hyphen characters.</p>";


            //Last name
            if (trim($last_name)=="")
                $err_msg .= "<p>Please enter your Last name.</p>";
            
            else
                $last_name = sanitise_input ($last_name);
                if (!preg_match("/^[a-zA-Z'-_ ]{1,30}+$/",$last_name))
                    $err_msg .= "<p>Last name can only contain Maximum 30 letters ,[space], hyphen characters.</p>";
            }

            //Q1
            if (isset ($_POST["alternatives"]) && ($_POST["alternatives"]!="")){
                $q1 = $_POST["alternatives"]; 
                $q1 = sanitise_input ($q1);
            }
            else
                $err_msg .= "<p>Please answer Question 1.</p>";
            

            //Q2
            if (isset ($_POST["definition"])){
                $q2 = $_POST["definition"];
                $q2 = sanitise_input ($q2);
            }      
            else 
                $err_msg .= "<p>Please answer Question 2.<p>";
            
            //Q3
            if (isset ($_POST["client_true"])){
                $q3a = ($_POST["client_true"]);
                $q3a = sanitise_input ($q3a);
            }
            if (isset ($_POST["client_false"])){
                $q3b = ($_POST["client_false"]);
                $q3b = sanitise_input ($q3b);
            }
            if (!isset ($_POST["client_true" || "client_false"]))
                $err_msg .= "<p>Please answer Question 3.<p>";   

            //Q4
            if (isset ($_POST["file_true"])){
                $q4a = ($_POST["file_true"]);
                $q4a = sanitise_input ($q4a);
            }
            if (isset ($_POST["file_false"])){
                $q4b = ($_POST["file_false"]);
                $q4b = sanitise_input ($q4b);
            }
            if (!isset ($_POST["client_true" || "client_false"]))
                $err_msg .= "<p>Please answer Question 4.<p>"; 

            //Q5 
            if (isset ($_POST["function1"])){
                $q5 = $_POST["function1"];
                $q5 = sanitise_input ($q5);
            }
            if (isset ($_POST["function2"])){
                $q5 = $_POST["function2"];
                $q5 = sanitise_input ($q5);
            }
            if (isset ($_POST["function3"])){
                $question_3 = $_POST["function3"];
                $question_3 = sanitise_input ($q5);
            }
            if (isset ($_POST["function4"])){
                $q5 = $_POST["function4"];
                $q5 = sanitise_input ($q5);
            }
            if (isset ($_POST["function5"])){
                $q5 = $_POST["function5"];
                $q5 = sanitise_input ($q5);
            }
            if (isset ($_POST["function6"])){
                $q5 = $_POST["function6"];
                $q5 = sanitise_input ($q5);
            }
            if (!isset ($_POST["function1" || "function2" || "function3" || "function4" || "function5" || "function6"])){
                $err_msg .= "<p>Please answer Question 5.<p>";
            }

            // Q6
            if (isset ($_POST["history"]) && ($_POST["history"]!="")){
                $q6 = $_POST["history"];
                $q6 = sanitise_input ($q6);
            }
            else 
                $err_msg .= "<p>Please answer Question 6.<p>";

            //Q7
            if (isset ($_POST["creator"]) && ($_POST["creator"]!="")){
                $q7 = $_POST["creator"]; 
                $q7 = sanitise_input ($q7);
            }
            else
                $err_msg .= "<p>Please answer Question 7.</p>";
            
            //Q8
            if (isset ($_POST["timeout"]) && ($_POST["timeout"]!="")){
                $question_5 = $_POST["timeout"];
                $question_5 = sanitise_input ($question_5);
            }
            else 
                $err_msg .= "<p>Please answer Question 8.<p>";

            //Error msg

            if ($err_msg!="")
                echo $err_msg;

                // only allowing for a max of 2 attempts
                if ($attempt_num < 2) {
                    // query to insert all of the inputs that the user has put into the form
                    $query = "INSERT INTO $sql_table (attempt_id, attempt_date, first_name, last_name, student_id, attempt_num, score) 
                    VALUES (NULL , '$attempt_date' , '$first_name' , '$last_name' , '$student_id' , '$attempt_num', '$score' )";
                    $result = mysqli_query($sql_db, $query);

                    // the query that we wrote will now go to the database and send that query and receive the results inside of the result variable

                    // if the result is true, then select everything that's been entered in the form into the database and show it in a table
                    if ($result == true) { 
                        $query = "SELECT * FROM $sql_table";
                        $result = mysqli_query($sql_db, $query);
                        $record = mysqli_fetch_assoc($result);
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
                            echo "<p>Successfully added new question attempt!</p>";
                        }

                    }
                    else { 
                        echo "<p>Something is wrong with " , $query , "</p>";
                    }
                    mysqli_close($sql_db);
                }
                // if the attempt number is greater than 2, then redirection to a page saying max attempts
                else {
                    echo "<p>You have reached the maximum number of attempts.</p>";
                    echo "<p>Please try again later.</p>";
                }
                    
                }
            ?>
        </section>
    </body>

</html>
