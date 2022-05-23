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
    
    <body>
        <!-- sticky menu bar, with navigation links to other pages -->
        <?php include 'menu.inc'; ?>

        <!-- header contains school logo, and info relating to the page's creation -->
        <?php include 'header.inc'; ?>
        
        <h1>View Quiz Questions</h1>
        
        <section class="content-block">
            <p>(Note that the comma-separated strings have had spaces inserted, to improve formatting.)</p>
            <?php
                // connect to the SQL database
                require_once ("db_settings.php");
                $sql_db = @mysqli_connect($host, $user, $pwd, $db_name);
                if ($sql_db) {
                    $query = "SELECT * FROM quiz_questions";
                    $result = mysqli_query($sql_db, $query);
                    
                    // if a connection was made
                    if ($result) {
                        // if the table is not empty
                        $record = mysqli_fetch_all($result, MYSQLI_ASSOC);
                        if ($record) {
                            
                            // setup table and header row
                            echo "<table border='1' class=\"alternative-table\">";
                            echo "<tr class='alternative-tr'> \n<th class='alternative-th'>Name</th> \n<th class='alternative-th'>Type</th> \n<th class='alternative-th'>Title</th> \n<th class='alternative-th'>IDs</th> \n<th class='alternative-th'>Options</th> \n<th class='alternative-th'>Answer</th> \n<th class='alternative-th'>Minimum Length</th> \n<th class='alternative-th'>Maximum Length</th></tr>";
                            
                            // loop through each question in the table
                            foreach ($record as $row){
                                $q_title = $row['title'];
                                $q_type = $row['type'];
                                $q_name = $row['name'];
                                $q_ids = str_replace(",", ", ", $row['ids']); // add spaces after commas, for better formatting
                                $q_options = str_replace(",", ", ", $row['options']);
                                $q_answer = str_replace(",", ", ", $row['answer']);
                                $q_min_len = $row['min_len'];
                                $q_max_len = $row['max_len'];
                                
                                echo "<tr class='alternative-tr'> \n<td class='alternative-td'>$q_name</td> \n<td class='alternative-td'>$q_type</td> \n<td class='alternative-td'>$q_title</td> \n<td class='alternative-td'>$q_ids</td> \n<td class='alternative-td'>$q_options</td> \n<td class='alternative-td'>$q_answer</td> \n<td class='alternative-td'>$q_min_len</td> \n<td>$q_max_len</td></tr>";
                            }
                            echo "</table>";
                            mysqli_free_result($result);
                        }
                        else 
                            echo "<p>No questions were found.</p>";    
                    }
                    else {
                        echo "<p>Select query was unsuccessful.</p>";
                    }
                    mysqli_close($sql_db);
                }
                else {
                    echo "<p>Connection failed.</p>";
                }
            ?>
        </section>
        
        <!-- footer with email contacts for every member -->
        <?php include 'footer.inc'; ?>
    </body>
</html>
