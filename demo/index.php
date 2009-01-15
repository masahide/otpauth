<?php
    //checks to make sure user is authenticated
    require_once('lib.php');
     
    $uid = get_user_id();
    $username = get_user_name();
    $articles = get_recent_articles($uid);
     
    print "<h1>Welcome, $username, to the demo article page</h1>";
    print " (<a href='logout.php'>logout</a> | <a href='settings.php'>account settings</a>)";
     
    print "<h3>Your recent articles</h3>";
     
    print "<hr size=1 noshade>";
     
    foreach ($articles as $key => $article) {
        print "<b>".$article['title']."</b>";
        print "<div>".$article['text']."</b>";
    }
     
     
?>
