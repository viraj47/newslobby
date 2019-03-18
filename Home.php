<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/homestylesheet.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="scripts/login.js"></script>
  <script type="text/javascript" src="scripts/register.js"></script>
  <script type="text/javascript" src="scripts/barbapageload.js"></script>
  <script type="text/javascript" src="scripts/barba.min.js"></script>
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

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
      	<li class="active"><a href="#">Home</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
      	<li><a id="loginbtn-navbar" href="#" data-toggle="modal" data-target="#loginModal">Sign in</a></li>
        <li><a id="registerbtn-navbar" href="#" data-toggle="modal" data-target="#registerModal">Register</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
	</nav>
   <!---------------------------------------------------------navbar------------------------------------->

     <!---------------------------------------------------------GRID------------------------------------->
	<div class="grid">
	<?php
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL,"https://newsapi.org/v2/top-headlines?country=in&apiKey=f28db8ec72a149c8a276bd2a2424839b");
	$result=curl_exec($ch);
	$obj = json_decode($result);
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
	//print $obj->{'articles'}[0]->{'content'};
	foreach($obj->{'articles'} as & $value){
    	display_news($value->source->{"name"},$value->{"url"},$value->{"urlToImage"},$value->{"content"});
	}
	curl_close($ch);
	?>
	</div>
<!---------------------------------------------------------GRID------------------------------------->

 <!---------------------------------------------------------registerform------------------------------------->

 <div class="modal fade" tabindex="-1" role="dialog" id="registerModal" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('.carousel').carousel(0);clearmodel()"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Modal title</h4>
      </div>
      <div class="modal-body">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="false">
      
 
  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active">
       <form>
        <div class="form-group">
            <label for="exampleInputPassword1" required>Username</label>
            <input type="text" class="form-control" id="username" placeholder="Username" required="">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" class="form-control" id="email" placeholder="Email">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" class="form-control" id="password" placeholder="Password">
          </div>
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('.carousel').carousel(0);clearmodel()">Close</button>
        <button  id="nextbtn" type="button" class="btn btn-primary">Next</button>
      </form>
    </div>
    <div class="item">
      <div  class="profile-channel-select">
        <?php
          $servername = "localhost";
          $username = "root";
          $password = "";
          $dbname="newslobby";
          // Create connection
         $conn = mysqli_connect($servername, $username, $password, $dbname);
          // Check connection
          if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
          }
          $sql="SELECT channel_name from `news_channel`";

          $result = $conn->query($sql); 
            while($row = mysqli_fetch_assoc($result)) {
            print "<div id='".$row["channel_name"]."'>";
            print "<img id='".$row["channel_name"]."'src='images/".$row["channel_name"].".png'>";
            print "</div>";    
            }
        mysqli_close($conn);  
        ?>
         
  </div>
  <div style="margin-top: 20px;">
  <button id="backbtn" type="button" class="btn btn-default" onclick="$('.carousel').carousel('prev');">Back</button>
  <button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('.carousel').carousel(0);clearmodel()">Close</button>
  <button id="registerbtn" type="button" class="btn btn-primary">Register</button>
  </div>
     
    </div>
  </div>
</div>
        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
 <!---------------------------------------------------------registerform------------------------------------->

 <!--------------------------------------------------------loginform----------------------------------------->
 <div class="modal fade" tabindex="-1" role="dialog" id="loginModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Modal title</h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" class="form-control" id="loginemail" placeholder="Email">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" class="form-control" id="loginpassword" placeholder="Password">
          </div>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button  id="loginbtn" type="button" class="btn btn-primary">login</button>
      </form>
       </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div> 

</div>
</div> 
</body>
</html>

