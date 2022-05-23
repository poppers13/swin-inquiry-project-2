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
        
        <h1>PHP Enhancements</h1>
        
        <section class="content-block" id="enhance-block">
            <p>This page lists all enhancements made to the PHP backend of the website. The links in each item redirect to the closest area where the enhancement in question is integrated, since some pages cannot be accessed directly from this page.</p>
            
            <h2>Question Storage & Random Selection in SQL</h2>
            <p>Instead of being included specifically on individual pages, the quiz questions are now stored within a MySQL database (viewable on a secret page <a href="viewquiztable.php">here</a>), with <a href="quiz.php#quiz-form">five randomly selected to be displayed on the quiz page for any given attempt</a> (refresh the page to see new questions). This makes the quiz more interesting for the user, since it can now have more questions testing a wider set of knowledge, and by storing it in a MySQL database, data can easily be added or modified by authorised developers and immediately be available for users of the site. Since the correct answers are stored, this also allows for creating simple, concise code that checks these answers dynamically instead of hard-coding them (this can be seen when submitting a valid quiz attempt).
            <br/><br/>
            This has been achieved by creating the SQL table <em>quiz_questions</em>, and then accessing it using the PHP <code>mysqli_query</code> function. Random selection is performed with the query <code>"SELECT * FROM quiz_questions ORDER BY RAND() LIMIT 5"</code>. Since SQL tables do not support storing arrays within singular cells, all lists have been stored as comma-separated strings, then converted into arrays using the <code>explode(",", $array_name)</code> function. Finally, to make sure that the page marking the quiz knows which questions the user was asked, a secret <code>input</code> tag (<code>type=hidden</code>) sends a comma-separated list of question names to the <code>$_POST</code> superglobal on form submission.</p>
            
            <h2>Quiz Question Generation in PHP</h2>
            <p>Building on the previous enhancement, the quiz page has been created such that now <a href="quiz.php#quiz-form">quiz questions can be automatically generated</a> by sourcing all parameters -- question titles, options and correct answers -- directly from the MySQL table and echoing HTML tags using PHP code. Different input formats can also be generated based on question type; for example, the <code>text</code> type will generate a set of <code>input</code> HTML tags, whereas the <code>dropdown</code> type will generate a <code>select</code> tag and corresponding <code>option</code> tags for each answer.
            <br/><br/>
            To do this, the PHP cycles through each question (<code>foreach ($questions as $row) {}</code>) and stores all relevant data for each row in variables. The HTML formatting is selected using a <code>switch</code> with a <code>case</code> for each data type before displaying to the user using <code>echo</code> functions with the variables inserted into the output strings.</p>
        </section>
        
        <!-- footer with email contacts for every member -->
        <?php include 'footer.inc'; ?>
    </body>
</html>
