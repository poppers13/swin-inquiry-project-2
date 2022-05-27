<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- import Bootstrap CSS -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
        
        <!-- site-wide stylesheet -->
        <link rel = "stylesheet" type = "text/css" href = "styles/style.css">
        
        <!-- metadata -->
        <title>Cookies and Sessions - Mark Quiz</title>
        <meta charset="UTF-8">
        <meta name="description"    content="How to navigate this web page">
        <meta name="keywords"       content="cookies, sessions, education, swinburne, home, menu">
        <meta name="author"         content="Aidan Davies, Jesh Kumar, Dylan Lewis, Nimash Rathnayake, Kasun Jayawardhana">
    </head>

    <body>
        <!-- sticky menu bar, with navigation links to other pages -->
        <?php include 'menu.inc'; ?>

        <!-- header contains school logo, and info relating to the page's creation -->
        <?php include 'header.inc'; ?>

        <h1>Mark Quiz</h1>
        
        <div class="content-block">
            <?php
                // 1. REDIRECTION - checking if the first name has been entered, if not then terminate the code and send back to quiz page
                if (!isset ($_POST['firstname'])) {
                    header("location:quiz.php");
                    exit();
                }
                // 2. CONNECTION - connect to the SQL database
                require_once ("db_settings.php");
                $sql_db = @mysqli_connect($host, $user, $pwd, $db_name);
                
                // declaring all field information as empty strings to add information into them later
                $attempt_id = "";
                $attempt_date = date("Y-m-d H:i:s"); 

                $first_name = "";
                $last_name = "";
                $student_id = "";
                $err_msg = "";
                $attempt_num = 1;
                $score = 0;
                // using this boolean to check if the answers have all been answered or not. if all true then add attempt
                $questions = true;
                // start as being true and in the case of a question then leave it as is. otherwise set it to false

                // retrieving the list of questions and putting into an associative array
                //$result = mysqli_query($sql_db, "SELECT * FROM quiz_questions");
                $select_qnames = mysqli_query($sql_db, "SELECT name FROM quiz_questions");
                $select_qtypes = mysqli_query($sql_db, "SELECT type FROM quiz_questions");
                $select_qids = mysqli_query($sql_db, "SELECT ids FROM quiz_questions");
                $select_qanswers = mysqli_query($sql_db, "SELECT answer FROM quiz_questions");
                
                //$questions = mysqli_fetch_all($result, MYSQLI_ASSOC);
                /*
                $fetch_qnames = mysqli_fetch_assoc($select_qnames);
                $fetch_qtypes = mysqli_fetch_assoc($select_qtypes);
                $fetch_qids = mysqli_fetch_assoc($select_qids);
                $fetch_qanswers = mysqli_fetch_assoc($select_qanswers);
                */
                
                // declaring empty arrays for the values of the fields to go into
                $question_names = array();
                $question_types = array();
                $question_ids = array();
                $question_answers = array();

                // looping through the array and putting all the values into question_names array
                foreach ($select_qnames as $field) {
                    // this $q_name will contain all of the names for the questions to be used in code ahead
                    $q_name = $field['name'];
                    // putting each of the names from the loop into the $question_names array
                    array_push($question_names, $q_name);
                }
                // looping through the array and putting all the values into question_type array
                foreach ($select_qtypes as $field) {
                    $q_type = $field['type'];
                    array_push($question_types, $q_type);
                }

                // looping through the array and putting all the values into question_answers array
                foreach ($select_qanswers as $field) {
                    $q_answer = $field['answer'];
                    array_push($question_answers, $q_answer);
                }

                /* assigning all of the question names and adapts to how many questions there are 
                the extract function will take out each of the values from the $question_names array and assign it to a new variable
                with the prefix of name_[i] -> the values begin from 0 up to how many question there are minus 1 (8 questions, 0->7)
                */ 
                for ($i = 0; $i < 5; $i++) {
                    extract($question_names, EXTR_PREFIX_ALL, "name");
                }

                for ($i = 0; $i < count($question_types); $i++) {
                    extract($question_types, EXTR_PREFIX_ALL, "type");
                }

                for ($i = 0; $i < 5; $i++) {
                    extract($question_ids, EXTR_PREFIX_ALL, "id");
                }

                for ($i = 0; $i < 5; $i++) {
                    extract($question_answers, EXTR_PREFIX_ALL, "answer");
                }

                // Sanitising Function
                function sanitise_input($data) {
                    $data = trim($data);
                    $data = stripslashes($data);
                    $data = htmlspecialchars($data);
                    return $data;
                }

                // STUDENT DETAIL VALIDATION
                $err_msg = "";

                // VALIDATION - Student ID
                if (isset ($_POST["studentid"]) && ($_POST["studentid"] != "")) {
                    if (is_numeric($_POST["studentid"]) == true) { // use the form value until it's acutally set below
                        $student_id = trim($student_id);
                        $student_id = sanitise_input($student_id);
                        // once cleaned, put the value into the variable
                        $student_id = $_POST["studentid"];
                    } else {
                        $err_msg .= "<p>Student ID can only contain numbers with length between 7 - 10.</p>";
                    }
                } else {
                    $err_msg .= "<p>Please enter your Student ID.</p>";
                }

                // VALIDATION - First Name
                if (isset ($_POST["firstname"]) && ($_POST["firstname"] != "")) {
                    if (!preg_match("/^[a-zA-Z_-\s]{1,30}+$/", $_POST["firstname"])) { // use \s for a space in regex
                        $err_msg .= "<p>First name can only contain Maximum 30 letters, [space], hyphen characters.</p>";
                    } else {
                        $first_name = trim($_POST["firstname"]);
                        $first_name = sanitise_input($first_name);
                        // once cleaned, put the value into the variable
                        $first_name = $_POST["firstname"];
                    }
                } else {
                    $err_msg .= "<p>Please enter your First Name</p>";
                }
                 
                // VALIDATION - Last Name
                if (isset ($_POST["lastname"]) && ($_POST["lastname"] != "")) {
                    if (!preg_match("/^[a-zA-Z_-\s]{1,30}+$/", $_POST["lastname"])) {
                        $err_msg .= "<p>Last name can only contain Maximum 30 letters, [space], hyphen characters.</p>";
                    } else {
                        $last_name = trim($_POST["lastname"]);
                        $last_name = sanitise_input($last_name);
                        // once cleaned, put the value into the variable
                        $last_name = $_POST["lastname"];
                    }
                } else {
                    $err_msg .= "<p>Please enter your Last Name</p>";
                }
               
                // going through all questions to check their type before validation
                for ($i = 0; $i < 5; $i++) {
                    $q_num = $i + 1;

                    // checking if the question selected is a checkbox **need to check if all the boxes have been checked or not
                    /*
                    if (${"type_" . $i} == "checkbox") {
                        // CHECKBOX QUESTION VALIDATION
                        if (in_array("checkbox-function1" , $_POST["name_" . $i]))
                        {
                            echo "hi";
                            // storing the checked boxes array in the variable called $checkbox
                            $checkbox = $_POST[${"name_" . $i}];
                            // breaks the checked boxes that user entered from string into an array
                            $user_answer = explode("," , $checkbox);
                            // CHECKBOX QUESTION MARKING
                            $score = intval($score);
                            if ($user_answer[$i] == ${"answer_" . $i}) {
                                echo "<p>Correct, Cookies are used to personalise a user's web experience - 1/1 marks.</p>";
                                $score = $score + 1;
                            }
                            else {
                                echo "<p>Incorrect - 0/1 marks.</p>";
                            }
                        }
                        else 
                        {
                            $err_msg .= "<p>Please answer question $q_num.</p>";
                            $questions = false;
                        }

                    }
                    */
                    // checking if the question selected is a text input
                    if (${"type_" . $i} == "text") {
                        // TEXT QUESTION VALIDATION
                        if (isset ($_POST[${"name_" . $i}]) && ($_POST[${"name_" . $i}] != ""))
                        {
                            $text = $_POST[${"name_" . $i}];
                            $text = sanitise_input($text);

                            // TEXT QUESTION MARKING
                            $score = intval($score);
                            if ($text == ${"answer_" . $i}) {
                            //will probably add more to this at another time so there can be more variety in correct responses. but for now i think these two answers will make do.
                                echo "<p>Correct - 1/1 marks.</p>";
                                $score = $score + 1;
                            } else {
                                echo "<p>Incorrect - 0/1 marks.</p>";
                            }
                        }   
                        else 
                        {
                            $err_msg .= "<p>Please answer question $q_num.<p>";
                            $questions = false;
                        }
                    }

                    // checking if the question selected is a radio 
                    if (${"type_" . $i} == "radio") {
                        // RADIO QUESTION VALIDATION
                        if (isset ($_POST[${"name_" . $i}])) 
                        {
                            $radio = $_POST[${"name_" . $i}];
                            
                            // RADIO QUESTION MARKING
                            $score = intval($score); //intval makes it an int so 1+1 correct marks = 2 and not 11 by adding strings if that makes sense
                            if ($radio == ${"answer_" . $i}) 
                            {
                                echo "<p>Correct - 1/1 marks.</p>";
                                $score = $score + 1;
                            } else {
                                echo "<p>Incorrect - 0/1 marks.</p>";
                            }
                        }
                        else
                        {
                            $err_msg .= "<p>Please answer question $q_num.<p>"; 
                            $questions = false;
                        }
                        /*if (!isset ($_POST["client_true" || "client_false"])) // *is this part also need if we already did the part above?
                        {
                            $err_msg .= "<p>Please answer question $q_num.<p>"; 
                        }
                        */
                    }

                    // checking if the question selected is a dropdown
                    if (${"type_" . $i} == "dropdown") {
                        // DROPDOWN QUESTION VALIDATION
                        if (isset ($_POST[${"name_" . $i}]) && ($_POST[${"name_" . $i}] != ""))
                        {
                            $dropdown = $_POST[${"name_" . $i}];
                            
                            // DROPDOWN QUESTION MARKING
                            $score = intval($score);
                            if ($dropdown == ${"answer_" . $i})
                            {
                                echo "<p>Correct, the financial times declared that cookies were dangerous - 1/1 marks.</p>";
                                $score = $score + 1;
                            } else {
                                echo "<p>Incorrect - 0/1 marks.</p>";
                            }
                        }
                        else 
                        {
                            $err_msg .= "<p>Please answer question $q_num.<p>";
                            $questions = false;
                        }    
                    }
                    
                    // checking if the question selected is a number input
                    if (${"type_" . $i} == "number") {
                        // NUMBER QUESTION VALIDATION
                        if (isset ($_POST[${"name_" . $i}]) && ($_POST[${"name_" . $i}] != ""))
                        {
                            if (is_numeric($_POST[${"name_" . $i}]) == true) {
                                $number = sanitise_input($number);
                                $number = $_POST[${"name_" . $i}];
                                
                                // NUMBER QUESTION MARKING
                                $score = intval($score);
                                if ($number == ${"answer_" . $i}) {
                                    echo "<p>Correct, the default time period for a cookie to expire is 30 minutes - 1/1 marks.</p>";
                                    $score = $score + 1;
                                } else {
                                    echo "<p>Incorrect, it takes 30 minutes for a cookie to timeout by default - 0/1 marks.</p>";
                                }
                            } else {
                                echo "<p>Please enter a number between 1-60 for question $q_num.</p>";
                            }

                        }
                        else 
                        {
                            $err_msg .= "<p>Please answer question $q_num.<p>";
                            $questions = false;
                        } 
                    }
                }
                
                /*
                // RADIO - What kind of file is a cookie?
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

                // CHECKBOX - What are the 3 main functions of web cookies?
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
                */

                // CHECKING WHETHER STUDENT EXISTS IN DB FOR ATTEMPTS
                $select_studentids = mysqli_query($sql_db, "SELECT * FROM quiz_attempts WHERE student_id = $student_id");
                $student_ids = array();

                if ($select_studentids == true) {
                    // looping through the array and putting all the values into student_ids array
                    foreach ($select_studentids as $field) {
                        $sid = $field['student_id'];
                        // putting each of the names from the loop into the $student_ids array
                        array_push($student_ids, $sid);
                    }

                    for ($i = 0; $i < count($student_ids); $i++) {
                        extract($student_ids, EXTR_PREFIX_ALL, "sid");
                    }

                    // count number of rows which has the instance of the id
                    for ($i = 0; $i < count($student_ids); $i++) {
                        // check to see if there are any student ids in the database
                        if ($student_id == ${"sid_" . $i}) {
                            // if yes, count how many there are and if greater than 2, don't submit attempt
                            if (mysqli_num_rows($select_studentids) > 2) {
                                echo "<p>You have already had 2 attempts. Please try again later.</p>";
                            } else {
                                $attempt_num = $attempt_num + 1;
                            }
                        } else {
                            // if there isn't already a student id in the database, then add an attempt
                            $attempt_num = $attempt_num + 1;
                        }
                    }
                }

                // Adding attempt number before scoring
                if (isset ($_POST['firstname']) && ($_POST["firstname"] != "")) {
                    if (isset ($_POST['lastname']) && ($_POST["lastname"] != "")) {
                        if (isset ($_POST['studentid']) && ($_POST["studentid"] != "")) {
                            if ($questions == true) {
                                if ($score != 0) {
                                    $attempt_num = $attempt_num + 1;
                                // complete the rest of the code and add an attempt into the db
                                // first or second attempt
                                }
                            }
                        }
                    } 
                }
                // *will implement this later when i have made random question gen to get a percent from test and i will do some tidying up when i come back to this after random question maker is done.($score/7*100 %)//

                // SCORE CONDITIONS
                $percentage = ($score / 5) * 100;
                echo "<p>Congratulations $first_name $last_name! Your score for this quiz was $score out of 5. That's $percentage% !</p>";
                if ($attempt_num == 1) {
                    echo "<p>It took you $attempt_num attempt. Would you like to <a href='quiz.php'>try again?</a></p>";
                } elseif ($attempt_num == 2) {
                    echo "<p>It took you $attempt_num attempts. Would you like to <a href='quiz.php'>try again?</a></p>";
                } elseif ($attempt_num > 2) {
                    echo "<p>You have already had more than 2 attempts. Please try again later.</p>";
                }

                // conditions if the connection isn't made
                if (!$sql_db) {
                    echo "<p>Database connection failure!</p>";
                }
                else {
                    // ** need to fix this up so that created if doesn't exists already : $table = "CREATE TABLE IF NOT EXISTS quiz_attempts";
                    $sql_table = "quiz_attempts";
                    // need to check if the fields in the form have been entered or not using validation

                    // Echoing all errors if the string isn't empty
                    if ($err_msg != "")
                        echo $err_msg;

                    // only allowing for a max of 2 attempts *SETTING THIS UP PROPERLY
                    if ($attempt_num < 3) {
                        $table = "SELECT * FROM quiz_attempts";
                        $check_table = mysqli_query($sql_db, $table);
                        if (!$check_table) {
                        // create the table
                            $create_table = "CREATE TABLE quiz_attempts (
                                attempt_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                attempt_date datetime,
                                first_name varchar(30),
                                last_name varchar(30),
                                student_id int(11),
                                attempt_num int(11),
                                score int(11) 
                                )";

                            $make_table = mysqli_query($sql_db, $create_table);

                        } else {
                            // query to insert all of the inputs that the user has put into the form
                            $query = "INSERT INTO $sql_table (attempt_id, attempt_date, first_name, last_name, student_id, attempt_num, score) 
                            VALUES (NULL , '$attempt_date' , '$first_name' , '$last_name' , '$student_id' , '$attempt_num', '$score' )";
                            // the query that we wrote will now go to the database and send that query and receive the results inside of the result variable
                            $result = mysqli_query($sql_db, $query);
                            
                            echo "<p>You had less than 2 attempts. <a href='quiz.php'>Click here</a> to try again!</p>";

                            // if the result is true, then select everything that's been entered in the form into the database and show it in a table
                            if ($result == true) { 
                                $query = "SELECT * FROM $sql_table";
                                $result = mysqli_query($sql_db, $query);
                                $record = mysqli_fetch_assoc($result);
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
                                    echo "<p>Successfully added new question attempt!</p>";
                                }

                            }
                            else { 
                                echo "<p>Something is wrong with " , $query , "</p>";
                            }
                            mysqli_close($sql_db);
                        }
                    }
                }
            ?>
        </div>
        <!-- footer with email contacts for every member -->
        <?php include 'footer.inc'; ?>
    </body>
</html>