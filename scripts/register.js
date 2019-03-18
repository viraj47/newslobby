
 var listOfchannels=["abc-news","bbc-news","bbc-sports","bloomberg","business-insider","cnn","espn","financial-post","focus",
                      "fox-news","google-news-in","hacker-news","ign","national-geographic","tech-crunch","techradar",
                      "the-hindu","the-economist","the-next-web","the-verge","the-times-of-india","the-wall-street-journal","wired"];
  var selected_channels=[]; 
  var username="";
  var email="";
  var password=""; 
  var xhttp = new XMLHttpRequest();
  $("#registerbtn-navbar").click(function(){
    document.getElementsByClassName("profile-channel-select")[0].addEventListener('click',function(event){
    for(let i=0;i<listOfchannels.length;i++)
    {
    if(event.target.id==listOfchannels[i])
      {
        if(!selected_channels.includes(listOfchannels[i]))
        {
        selected_channels.push(event.target.id);
        document.getElementById(listOfchannels[i]).style.outline="2px solid black";
        }
        else
        {
          document.getElementById(listOfchannels[i]).style.outline="none";
          selected_channels.splice(selected_channels.indexOf(listOfchannels[i]),1);
        } 
      }
    }
  });
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      if(this.responseText=="already registered")
      {
        document.getElementById("email").value="";
        $(".modal").addClass("invalid-data");
        $("#email").addClass("alert alert-danger");
        document.getElementById("email").placeholder="already registered";
      }
      else
      {
        $('.carousel').carousel('next');
      }
    }
  };
  $("#nextbtn").click(function(){
  ifvalidated(function(){
  email=document.getElementById("email").value;
  xhttp.open("POST", "register.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("checkemail="+email);
  });
  
  });
});  

 $("#registerbtn").click(function(){
  email=document.getElementById("email").value;
  username=document.getElementById("username").value;
  password=document.getElementById("password").value;
  sel_chan=JSON.stringify(selected_channels);
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      if(this.responseText=="sucesss")
          $('#registerModal').modal('hide');
    }
  };
  xhttp.open("POST", "register.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("username="+username+"&password="+password+"&email="+email+"&selected_channels="+sel_chan);
 });

 function clearmodel()
 {
  for(let i=0;i<listOfchannels.length;i++)
  {
        document.getElementById(listOfchannels[i]).style.outline="none";
  }
   $(".modal").removeClass("invalid-data");
   $("#username").removeClass("alert alert-info");
   $("#email").removeClass("alert alert-info");
   $("#password").removeClass("alert alert-info");
   $("#email").removeClass("alert alert-danger");
   document.getElementById("email").placeholder="email";
   document.getElementById("password").value="";
   document.getElementById("password").placeholder="password";
   document.getElementById("username").placeholder="username";
   selected_channels=[];
 }
 function ifvalidated(nextstep)
 {
  email=document.getElementById("email").value.trim();
  username=document.getElementById("username").value.trim();
  password=document.getElementById("password").value.trim();
  if(username=="")
  {
    $("#username").addClass("alert alert-info"); 
    document.getElementById("username").placeholder="please enter some data";
    document.getElementById("username").value="";
  } 
  if(email=="")
  {
    $("#email").addClass("alert alert-info"); 
    document.getElementById("email").placeholder="please enter some data";
    document.getElementById("email").value="";
  } 
  if(!(/^\w+@([a-zA-Z_])+(\.[a-zA-Z]+)+$/.test(email)))
  {
    $("#email").addClass("alert alert-info"); 
    document.getElementById("email").placeholder="enter valid email";
    document.getElementById("email").value="";
  }
  if(password=="")
  {
    $("#password").addClass("alert alert-info");
    document.getElementById("password").placeholder="please enter some data";
    document.getElementById("password").value="";
  }
  if(email!="" && username!="" && password!="")
  {
    $("#username").removeClass("alert alert-info"); 
    document.getElementById("username").placeholder="username";
    $("#email").removeClass("alert alert-info"); 
    document.getElementById("email").placeholder="email";
    $("#password").removeClass("alert alert-info"); 
    document.getElementById("password").placeholder="password";
    nextstep();
  }
  else
  {
    $(".carousel").carousel(0);
  }
}
