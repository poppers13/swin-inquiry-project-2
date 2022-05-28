<!DOCTYPE html>
<html lang="en">
    <head>
		<!-- import Bootstrap CSS -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
        
        <!-- site-wide stylesheet -->
        <link rel = "stylesheet" type = "text/css" href = "styles/style.css">
        
        <!-- metadata -->
        <title>Cookies and Sessions - Home</title>
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

        <h1>Welcome!</h1>
        
        <!-- section containing main content: summary, video and signs -->
        <div class="content-block">
            <p>This website provides a summary of <em>cookies and sessions</em>: what they are, how they work and why they're used. If you'd like a overview of the site's pages, then click <strong><a href="https://youtube.com/watch?v=ZpIWiQYZq-Y">here for part 1</a></strong> and <strong><a href="https://youtube.com/watch?v=ZpYCEr9RuOE">here for part 2</a></strong> of the YouTube video tour, or simply watch the videos below!</p>
            
            <!-- embedded versions of the YouTube tour videos, with Bootstrap styling for responsive scaling based on browser size -->
            <div class="embed-responsive embed-responsive-16by9">
                <!-- this iframe element has been signed off by the facilitator of this assignment, Fatma Mohammed, as it is necessary for this video player -->
                <iframe class="embed-responsive-item" width="640" height="360" title="A video showing the various pages available on the 'Cookies and Sessions' website." id="youtube-video" src="https://www.youtube.com/embed/ZpIWiQYZq-Y"></iframe>
            </div>
            <div class="embed-responsive embed-responsive-16by9">
                <!-- this iframe element has been signed off by the facilitator of this assignment, Fatma Mohammed, as it is necessary for this video player -->
                <iframe class="embed-responsive-item" width="640" height="360" title="A video showing the PHP functions available on the 'Cookies and Sessions' website." id="youtube-video" src="https://www.youtube.com/embed/ZpYCEr9RuOE"></iframe>
            </div>
            
            <br/>
            <p>To navigate to other pages on this site, use the menu located at the top, or the signs below. Simply click on the relevant topic to be taken there!</p>
			
            <!-- signs image, and corresponding image map -->
            <img src="images/direction_signs.png" id="signs-image" alt="Multi-colored arrow-shaped signs indicating directions to various places. The labels read: 'What are cookies?',  'History', 'Usage', 'Alternatives', 'Quiz' and 'Enhancements'." usemap="#signmap">
            
            <map name="signmap">
                <!-- red --> <area shape="poly" coords="456,40,95,75,42,128,104,174,466,141" alt="'What are cookies?' sign" href="topic2.php">
                <!-- white --> <area shape="poly" coords="514,41,869,75,927,128,864,173,505,140" alt="History sign" href="topic1.php">
                <!-- green --> <area shape="poly" coords="68,185,425,216,481,270,417,316,58,282" alt="Usage sign" href="topic3.php">
                <!-- yellow --> <area shape="poly" coords="570,186,931,227,920,326,561,284,507,226" alt="Alternatives sign" href="topic4.php">
                <!-- orange --> <area shape="poly" coords="82,376,441,343,503,385,449,443,91,473" alt="Quiz sign" href="quiz.php">
                <!-- blue --> <area shape="poly" coords="564,300,912,392,958,456,885,491,541,395" alt="Enhancements sign" href="enhancements.php">
            </map>
        </div>
        
        <!-- footer with email contacts for every member -->
        <?php include 'footer.inc' ?>
        
        <!-- IMAGES USED:
        Original signs image (edited for this page): https://www.bartush.com/wp-content/uploads/2016/04/Direction-sign-Vector.jpg
        -->
    </body>
</html>