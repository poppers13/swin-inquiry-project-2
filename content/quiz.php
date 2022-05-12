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
        <meta name="description" content="How to navigate this web page">
        <meta name="keywords" content="cookies, sessions, education, swinburne, home, menu">
        <meta name="author" content="Aidan Davies, Jesh Kumar, Dylan Lewis, Nimash Rathnayake, Kasun Jayawardhana">
    </head>
    
    <body id="index-body">
        <!-- sticky menu bar, with navigation links to other pages -->
        <?php include 'menu.inc'; ?>

        <!-- header contains school logo, and info relating to the page's creation -->
        <?php include 'header.inc'; ?>
        
        <h1>Cookies and Sessions Quiz</h1>
        
        <div class="content-block">
            <form method="post" action="markquiz.php" novalidate="novalidate">
                <?php
                    // connect to the SQL database
                    require_once ("db_settings.php");
                    $sql_db = @mysqli_connect($host, $user, $pwd, $db_name);

                    if (!$sql_db) {
                        // if connection is unsuccessful, then replace quiz form with error message
                        echo "<p>Failed to connect to database: try reloading the page.</p>";
                    } else {
                        // replace this with random generation later: until then, every question will be retrieved
                        // apparently, use "SELECT * FROM yourTableName ORDER BY RAND() LIMIT 1" as the query to select a random row
                        // so "SELECT * FROM quiz_questions ORDER BY RAND() LIMIT 5" selects 5 random rows, i assume
                        $result = mysqli_query($sql_db, "SELECT * FROM quiz_questions");
                        // RETRIEVE QUESTION LIST
                        $questions = mysqli_fetch_all($result, MYSQLI_ASSOC);
                        $question_string = "";
                        $is_first_row = true;
                        
                        // generate question string (to be passed into the $_POST superglobal)
                        foreach ($questions as $row) {
                            if (!$is_first_row) {
                                $question_string .= ",";
                            } else {
                                $is_first_row = false;
                            }
                            $question_string .= $row['name'];
                        }
                    }
                ?>
                
                <!-- STORE QUESTION LIST IN THIS FIELD!!!!
                    "value" should be a comma separated list of all question names in the order they appear: this can later be separated into an array
                    e.g. value="alternatives,definition,function,history,timeout" is the default list
                    you can include PHP code inside the value string to do this list: 
                    for example, value="<_?php echo "the question list" ?_>" (just without the underscores) -->
                <input type="hidden" name="question_list" value="<?php echo $question_string ?>">
                
                <fieldset>
                    <legend><strong>Personal Details</strong></legend>

                    <p>
                        <label for="studentid">Student ID</label>
                        <input type="text" name="studentid" id="studentid" required="required" pattern="\d{7,10}">
                    </p><p>
                        <label for="firstname">First Name</label>
                        <input type="text" name="firstname" id="firstname" required="required" pattern="[A-Za-z \-]{1,30}">
                    </p><p>
                        <label for="lastname">Last Name</label>
                        <input type="text" name="lastname" id="lastname" required="required" pattern="[A-Za-z \-]{1,30}">
                    </p>
                </fieldset>

                <fieldset>
                    <legend><strong>Questions</strong></legend>
                    
                    <?php
                        if ($sql_db) {
                            $q_num = 1;
                            foreach ($questions as $row) {
                                // retrieve all mandatory fields for this question
                                $q_title = $row['title'];
                                $q_type = $row['type'];
                                $q_name = $row['name'];
                                $q_ids = explode(",", $row['ids']); // split comma-separated string into numeric array
                                $q_options = explode(",", $row['options']);
                                $q_answer = explode(",", $row['answer']);
                                $output_html = "<fieldset>\n<legend>$q_num. $q_title</legend>\n"; // output_html = string containing current question
                                // DEV NOTE: if there's a way to have multiple possible conditions for a single case, combine checkbox and radio (and perhaps text and number as well)
                                switch ($q_type) {
                                    case 'text':
                                        $output_html .= "<label for=\"$q_name\">$q_options[0]</label>\n<input type=\"text\" name=\"$q_name\" id=\"$q_ids[0]\">\n";
                                        break;
                                    case 'number':
                                        $q_min = $row['min_len'];
                                        $q_max = $row['max_len'];
                                        $output_html .= "<label for=\"$q_name\">$q_options[0]</label>\n<input type=\"number\" name=\"$q_name\" id=\"$q_ids[0]\" min=\"$q_min\" max=\"$q_max\">\n";
                                        break;
                                    case 'checkbox':
                                        for ($i = 0; $i < count($q_ids); $i += 1) {
                                            $id = $q_ids[$i];
                                            $text = $q_options[$i];
                                            $output_html .= "<input type=\"$q_type\" name=\"$q_name\" id=\"$id\" value=\"$id\"><label for=\"$id\">$text</label>\n";
                                        }
                                        break;
                                    case 'radio':
                                        for ($i = 0; $i < count($q_ids); $i += 1) {
                                            $id = $q_ids[$i];
                                            $text = $q_options[$i];
                                            $output_html .= "<input type=\"$q_type\" name=\"$q_name\" id=\"$id\" value=\"$id\"><label for=\"$id\">$text</label>\n";
                                        }
                                        break;
                                    case 'dropdown':
                                        $output_html .= "<select name=\"$q_name\" id=\"$q_name\" required=\"required\">\n<option value=\"\" selected=\"selected\" disabled=\"disabled\">Select Answer</option>\n";
                                        for ($i = 0; $i < count($q_ids); $i += 1) {
                                            $id = $q_ids[$i];
                                            $text = $q_options[$i];
                                            $output_html .= "<option value=\"$id\">$text</option>\n";
                                        }
                                        $output_html .= "</select>\n";
                                        break;
                                    default:
                                        $output_html = "<fieldset>\n<p>Question $q_num could not be generated: unknown data type given.</p>\n";
                                }
                                $q_num += 1;
                                $output_html .= "</fieldset>\n";
                                echo $output_html;
                            }
                        }
                    ?>
                </fieldset>
                <!-- buttons for submitting and resetting the form, with included Bootstrap CSS styling and glyph icons -->
                <button type="submit" class="btn btn-success" id="submit-button"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Submit</button>
                <button type="reset" class="btn btn-danger"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Reset Answers</button>
            </form>
        </div>
        
        <!-- footer with email contacts for every member -->
        <?php include 'footer.inc'; ?>
    </body>
</html>
