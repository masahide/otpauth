<?php
  //checks to make sure user is authenticated 
  require_once('lib.php');

  $uid = get_user_id();
  $username = get_user_name();
  $articles = get_recent_articles($uid);

  print "<h1>Welcome, $username</h1>";

  print "<h3>Your recent articles</h3>";

  print "<hr size=1 noshade>";

  foreach ($articles as $key => $article) {
    print "<b>".$article['title']."</b>";
    print "<div>".$article['text']."</b>";
  }


?>
