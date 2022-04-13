<!DOCTYPE html>
<html lang="en">
    <head>
		<!-- import Bootstrap CSS -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
        
        <!-- site-wide stylesheet -->
        <link rel = "stylesheet" type = "text/css" href = "styles/style.css">
        
        <!-- metadata -->
        <title>Cookies and Sessions - Enhancements</title>
        <meta charset="UTF-8">
        <meta name="description" content="The enhancements made to the 'Cookies and Sessions' web page">
        <meta name="keywords" content="cookies, sessions, education, swinburne, enhancements, extra">
        <meta name="author" content="Aidan Davies, Jesh Kumar, Dylan Lewis, Nimash Rathnayake, Kasun Jayawardhana">
    </head>
    
    <body>
        <!-- sticky menu bar, with navigation links to other pages -->
        <?php include 'menu.inc'; ?>

        <!-- header contains school logo, and info relating to the page's creation -->
        <?php include 'header.inc'; ?>

        <h1>Enhancements</h1>
        
        <!-- main content: listing the enhancements made to the page -->
        <section class="content-block" id="enhance-block">
            <p>This page lists all enhancements made to the HTML and CSS of the website. The links at the beginning of each item redirect to the place where the enhancement in question is integrated.</p>
            
            <h2>Additional Elements</h2>
            <p>Various HTML and CSS elements have been incorporated outside of those taught in the lectures. These include: </p>
            <ol>
                <!-- image map -->
                <li><a href="index.php#signs-image">An image map on the 'Home' page</a>, which provides links to all other pages on the website. This makes the site more approachable to new visitors by including a large, colourful and easily readable navigation section. <br/>
                The image map is created by including an <code>img</code> element with the attribute <code>usemap</code>. This references another HTML element, <code>map</code>, which itself contains several <code>area</code> elements that provide the co-ordinates (<code>coords</code>) for the clickable area on the signs, and the pages to be redirected to when those areas are clicked (<code>href</code>).</li>
                
                <!-- code tags -->
                <li><a href="enhancements.php#enhance-block">Code tags on this page</a> that distinguish code from the other text in the paragraph. This makes the explanation sections for each enhancement much more legible, by making it clear the exact spelling and syntax of the code used. <br/>
                To create these code snippets, the <code>code</code> tag is used as an inline element inside each block of text.</li>
                
                <!-- number tags -->
                <li><a href="quiz.php#q5num">A number input on the 'Quiz' page</a> that only allows for entering a number, while limiting the range of the input. This tag is useful in both simplifying the data validation process (since range limitations are built into the input field's functionality) and by allowing for mouse-only input, which provides better accessibility to those who can't use a keyboard. <br/>
                This input field was included by setting the <code>type</code> attribute in the <code>input</code> tag to equal <code>number</code>, then including the <code>min</code> and <code>max</code> attributes to limit what values the user is allowed to enter.</li>
            </ol>
            
            <h2>CSS Bootstrap Integration</h2>
            <p>The preprocessor <u>Bootstrap</u> has been included on all pages. This provides several benefits, including quick and easy styling of key elements, as well as functionality not present in standard HTML and CSS. The following additions have been made:</p>
            <ol>
                <!-- YouTube video -->
                <li><a href="index.php#youtube-video">A responsive, embedded YouTube video on the 'Home' page</a> that allows for viewing the video on the home page itself, instead of having to use the link to visit YouTube.com (though this is still an option). This provides more convenience, as well as better availability for users with poor Internet connections, since it only requires them to load the video instead of the entirety of YouTube. Bootstrap in particular provides better responsive scaling: compared to normal responsive scaling for embedded video, where the proportions of the video player and video don't match and create a large amount of empty space, Bootstrap scales the video player to maintain the aspect ratio of the video, making for a much cleaner user experience.<br/>
                To embed the video, the <code>iframe</code> element is placed as the child of a <code>section</code> element, with the link to the video specified with the <code>src</code> attribute. The Bootstrap classes <code>embed-responsive embed-responsive-16by9</code> and <code>embed-responsive-item</code> then provide the video with proper scaling.</li>
                
                <!-- form buttons -->
                <li><a href="quiz.php#submit-button">The submit and reset buttons on the 'Quiz' page</a> have been styled using Bootstrap. This makes them easier to see, and clarifies their purpose using widely understood iconography (checkmark and trash can) and colours (green and red). <br/>
                To do this, the submit button has had the <code>btn btn-success</code> class applied to it, while the reset button has been given the <code>btn btn-danger</code> class. Glyph icons have also been applied by nesting <code>span</code> elements inside.</li>
                
                <!-- glyph icons -->
                <li>Glyph icons have been included <a href="index.php#menu">on the menu</a>, as well as <a href="quiz.php#submit-button">on the quiz buttons</a>. This makes the page much easier for those who do not fluently speak or read English to navigate, since the icons help communicate the meaning of each button. <br/>
                These icons are implemented (as per the Bootstrap documentation) by using a <code>span</code> element, with the class set to <code>glyphicon glyphicon-blank</code>, where <code>blank</code> is replaced with the name of the needed icon. The attribute <code>aria-hidden="true"</code> stops the icons from being scanned by screen readers, since this causes confusion for blind or partially blind users.</li>
            </ol>
        </section>
        
        <!-- footer with email contacts for every member -->
        <?php include 'footer.inc'; ?>
    </body>
</html>