<?php
  session_start();
  if(!isset(($_SESSION["useremail"])))
  {
    header("Location:http://localhost/oep/home.php");
    exit;
  }
  if(isset($_POST["logout"]))
  {

    if($_POST["logout"]=="true")
    {
      session_unset();
      session_destroy();
    }
  }
?>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/afterloginstylesheet.css">
  <link rel="stylesheet" href="css/profile.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="scripts/barba.min.js"></script>
  <script type="text/javascript" src="scripts/logout.js"></script>
  <script type="text/javascript" src="scripts/barbapageload.js"></script>
</head>
<body>
  <!---------------------------------------------------------navbar------------------------------------->
<div id="barba-wrapper" class="wrapper">
          <div class="barba-container">
  <nav class="navbar navbar-default navbar-fixed-top" style="background-color: #ffffff">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">News Lobby</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Home</a></li>
        <li><a href="#">Filter<span class="sr-only">(current)</span></a></li>
        <li><a href="profile.php">Profile</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a data-toggle="modal" data-target="#myModal">Logout</a></li>
      </ul>
    </div>
  </div>
  </nav>  
<!--------------------------------------------------------navbar--------------------------------------->


<!--------------------------------------------------------grid----------------------------------------->
<div class="grid">
<?php
 $servername = "localhost";
 $username = "root";
 $password = "";
 $dbname="newslobby";

 // Create connection
 $conn = mysqli_connect($servername, $username, $password, $dbname);
 $get_subscription=$conn->prepare("SELECT channel_name from user_to_channel WHERE user_email=?");
 $get_subscription->bind_param("s",$_SESSION["useremail"]);
 $get_subscription->execute();
 $get_subscription->bind_result($subscription);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  while($get_subscription->fetch())
  {

    curl_setopt($ch, CURLOPT_URL,"https://newsapi.org/v2/top-headlines?sources=".$subscription."&apiKey=f28db8ec72a149c8a276bd2a2424839b");
    $result=curl_exec($ch);
    $obj = json_decode($result);
    foreach($obj->{'articles'} as & $value){
    display_news($value->source->{"name"},$value->{"url"},$value->{"urlToImage"},$value->{"content"});
   
    }
  }
  function display_news($channel_name,$link_to_article,$thumbnail,$description)
    {
      $html_div='<div class="news-container">'. 
        '<div class="thumbnail">'.
          '<div class="caption" style="border-bottom-style: solid;border-bottom-width:thick;margin-top: 0px"></div>'.
          '<div class="caption channel-name">'.$channel_name.'</div>'.
          '<object class="headline-image" data="'.$thumbnail.'">'.
          '<img class="headline-image" src="http://www.sclance.com/pngs/news-paper-png/news_paper_png_929170.png">'.
          '</object>'.
        '<div class="caption">'.
          $description. 
        '</div>'. 
      '</div>'.
      '</div>';
      print $html_div;
    }
  curl_close($ch);
  ?>
  </div>

<!--------------------------------------------------------grid----------------------------------------->


<!--------------------------------------------------------logout modal-----------------------------------------> 
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        <div>Are you sure you want to logout?</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="logout" class="btn btn-primary">Logout</button>
      </div>
    </div>
  </div>
</div>
<!--------------------------------------------------------logout modal----------------------------------------->

</div>
</div>
</body>
</html>