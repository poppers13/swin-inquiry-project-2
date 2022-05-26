<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- import Bootstrap CSS -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
        
        <!-- site-wide stylesheet -->
        <link rel = "stylesheet" type = "text/css" href = "styles/style.css">
        
        <!-- metadata -->
        <meta charset="utf-8" />
        <meta name="description"    content="The history of cookies and sessions">
        <meta name="keywords"   content="History of Cookies and Sessions">
        <meta name="author" content="Nimash Rathnayake">
        <title>History of Cookies and Sessions</title>
    </head>

        <body id="topic1-body">
            <!-- sticky menu bar, with navigation links to other pages -->
            <?php include 'menu.inc'; ?>
    
            <!-- header contains school logo, and info relating to the page's creation -->
            <?php include 'header.inc'; ?>

            <h1>History of Cookies and Sessions</h1>
            
            <section class="content-block">
            
            <h2>Early History</h2>

                <section class="content-block">

                <!--Early history of cookies-->
                <h3>Creation of Cookies</h3>
                <p>
                    "Persistent client state objects" nicknamed by the creator as "Cookies", were first created in 1994 by Lou Montulli, 
                    a web browser programmer at Netscape, which was the most popular web browser back in the day. 
                    Lou Montulli invented cookies with the purpose in mind of making the shopping experience on online e-commerce sites much easier 
                    for customers, by allowing them to store their selected items in a virtual shopping cart. 
                    The following year, he applied for the patent for his newfound Cookie technology.
                </p>
                <figure class="img1">
                    <!--Image reference https://web30.web.cern.ch/speakers/lou-montulli.html-->
                    <img class="img1" src="images/loumontulli.png" alt="loumontulli">
                    <figcaption class="fig">https://web30.web.cern.ch/speakers/lou-montulli.html/</figcaption>
                </figure>

                
                </section>
                
                
                <h2>Public Response</h2>
                <p>
                    The public first knew about this through an article in "The Financial Times", in which the title was, 
                    "This Bug in Your PC Is a Smart Cookie". 
                    While it was interesting technology, 
                    the tracking of an individual user through new methods was alarming for some people.
                    This later became a turning point for online user privacy, which was to try to reduce the overall data collected from online users.
                </p>

                <figure class="img2">
                    <!--Image reference https://www.innovatorsunder35.com/the-list/lou-montulli/-->
                    <img class="img2" src="images/Financialtimes.png" alt="Financial Times article" >
                    <figcaption class="fig">https://www.innovatorsunder35.com/the-list/lou-montulli/</figcaption>
                </figure>
               
                
                <h2>First-party Cookies Vs Third-party Cookies</h2>

                <p>Before going any further, we should be aware of the two types of cookies which are based on who that cookies belong. 
                    These two are: First-party and Third-party cookies. The table below will make it easier to identify between the two.
                </p>    

                <table class="t1">
                    
                    <thead>
                        <tr>
                         <th class="t1" scope="col">...</th>
                         <th class="t1" scope="col">First-party</th> 
                         <th class="t1" scope="col">Third-party</th>
                        </tr>
                        </thead>
                   <tbody>
                    <tr>
                      <th scope="row" class="t1">Owner</th>
                      <td class="t1">Owner of the Website</td>
                      <td class="t1">A Third-party (Other than the owner)</td>
                    </tr>
                    <tr>
                      <th scope="row" class="t1">Main Purpose</th>
                      <td class="t1">Managing the browsing session</td>
                      <td class="t1">Tracking the activity of user </td>
                    </tr>
                    <tr>
                       <th scope="row" class="t1"> Service</th>
                       <td class="t1">Enabling a good browsing experience</td>
                       <td class="t1">Targeted Online Advertising</td>
                    </tr>
                   </tbody>
                </table>
                

                <p>As you can see, the use of third-party cookies was not optional. 
                    Due to this, two years later in 1997, Internet Engineering Task Force 
                    set a standard for cookies which was not on the supporting side of Third-party Cookies.
                </p>

                <h3>Struggle against Third-party Cookies</h3>

                <p>As you might expect, advertising companies started abusing cookie technology to gather as much user 
                    data and suggest personalized advertisements back to them. Consequently, the Internet Engineering Task 
                    Force recommended both Netscape and Internet Explorer to stop automatically accepting third party cookies,
                    however their effort was unsuccessful. The main concern was that they also gathered the users' age, location, 
                    gender, income, marital status, and health concerns rather than just analytical data about their online behaviour. 
                </p>
                <p>                    
                    Hence, 2002 laws enabled the user to accept or deny Third-party cookies by The European Union e-Privacy Directive.
                    From this point onwards began the initiation of blocking third-party cookies as much as possible, and allowing 
                    the public to surf the web a without as much restriction.
                </p>

                <!--Cookie types based on their activity-->
                <aside id="aside-history">
                    <h3 class="asideh" >Cookie types based on period of activity include:</h3>
                
                    <!--Ordered list-->
                    <ol>
                        <li>Transient Cookies</li>
                        <li>Persistent Cookies</li>
                        <li>Flash Cookies</li>
                    </ol>

                    <p class="asidep">It is important to mention that Sessions (Transient cookies) are also a type of cookie that only last one site session 
                        and these are only stored on the server, unlike cookies which are stored on both the server and client-side.
                    </p>
                </aside>
                
                <h2>Important Changes Done to Cookies Later in the Past</h2>
            
                <!--Unordered list-->
                    <ul>
                        <li>2002 Law that enables the user to accept or deny Third-party cookies (The European Union e-Privacy Directive)</li>
                        <li>2017 Third-party Cookies associated with tracking users were removed from Safari browser by Apple</li>
                        <li>2018 The General Data Protection Regulation was introduced, which need user consent to allow Third-party Cookies.</li>
                        <li>2019 Mozilla annouced the blocking of Third-party trackers in Mozilla Firefox.</li>
                    </ul>

                <!--Link to the topic 2-->
                    <a class="a" href = "topic2.php">Click here to learn more about what exactly cookies and sessions are!</a>

            </section>
			
			<!-- footer with email contacts for every member -->
            <?php include 'footer.inc'; ?>
        </body>

        <!--References
        https://newprogrammatic.com/blog/what-are-browser-cookies-in-digital-advertising/#Third-party_vs_First-party_cookies
        https://neeva.com/learn/what-are-cookies
        https://medium.com/geekculture/cookies-sessions-1cb9e4ad6f7b
        -->
</html>
