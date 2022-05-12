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
                <!-- STORE QUESTION LIST IN THIS FIELD!!!!
                    "value" should be a comma separated list of all question names in the order they appear: this can later be separated into an array
                    e.g. value="alternatives,definition,function,history,timeout" is the default list
                    you can include PHP code inside the value string to do this list: 
                    for example, value="<_?php echo "the question list" ?_>" (just without the underscores) -->
                <input type="hidden" name="question_list" value="alternatives,definition,function[],history,timeout">
                
                <?php
                    // connect to the SQL database
                    require_once ("db_settings.php");
                    $sql_db = @mysqli_connect($host, $user, $pwd, $db_name);
                
                    if (!$sql_db) {
                        // if connection is unsuccessful, then replace quiz form with error message
                        echo "<p>Failed to connect to database: try reloading the page.</p>";
                    } else {
                        // put rest of question generation code here
                    }
                ?>
                
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

                    <!-- text input question -->
                    <fieldset>
                        <legend>1. What are web caches designed to store?</legend>
                        <label for="alternatives"><i>Answer: </i></label>
                        <input type="text" name="alternatives" id="alternatives" required="required">
                    </fieldset>

                    <!-- radio multi choice question -->
                    <fieldset>
                        <legend>2. A cookie is stored client side</legend>
                        <input type="radio" name="definition" id="definition-true" value="definition-true" required="required"><label for="definition-true">True</label>
                        <input type="radio" name="definition" id="definition-false" value="definition-false"><label for="definition-false">False</label>
                    </fieldset>
                    
                    <!-- checkbox multi choice question -->
                    <fieldset>
                        <legend>3. What are the 3 main functions of web cookies?</legend>
                        <input type="checkbox" name="function[]" id="cleanup" value="cleanup"><label for="cleanup">HDD Cleanup</label>
                        <input type="checkbox" name="function[]" id="eating" value="eating"><label for="eating">Eating</label>
                        <input type="checkbox" name="function[]" id="personalisation" value="personalisation" required><label for="personalisation">Personalisation</label>
                        <input type="checkbox" name="function[]" id="networking" value="networking"><label for="networking">Internet Protocols & Networking</label>
                        <input type="checkbox" name="function[]" id="tracking" value="tracking"><label for="tracking">Tracking</label>
                        <input type="checkbox" name="function[]" id="authorisation" value="authorisation"><label for="authorisation">Authorisation</label>
                    </fieldset>
                    
                    <!-- dropdown question -->
                    <fieldset>
                        <legend>4. Which publication declared that cookies are unsafe for the public in February 1996?</legend>
                        <select name="history" id="history" required="required">
                            <option value="" selected="selected" disabled>Select Answer</option>
                            <option value="new-york">The New York Times</option>
                            <option value="financial-times">Financial Times</option>
                            <option value="scientific-american">Scientific American</option>
                            <option value="time-magazine">Time Magazine</option>
                        </select>
                    </fieldset>
                    
                    <!-- leaving the last question blank for now: we'll decide later what this should be -->
                    <fieldset>
                        <legend>5. By default, how long does it take for a session to time out?</legend>
                        <label for="timeout">Minutes (between 1 and 60): </label>
                        <input type="number" name="timeout" id="timeout" required="required" min="1" max="60">
                    </fieldset>
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
