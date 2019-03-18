$('document').ready(function(){
var loginemail;
var loginpassword;
 var xhttp = new XMLHttpRequest();
  $("#loginbtn").click(function(){  
  loginvalidate(function(){  
  loginemail=document.getElementById("loginemail").value;
  loginpassword=document.getElementById("loginpassword").value;  
  xhttp.open("POST", "login.php", true);
  xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xhttp.send("loginemail="+loginemail+"&loginpassword="+loginpassword);
  });  
});

   xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      if(this.responseText=="success")
      {
        window.location.assign("http://localhost/oep/afterlogin.php");
      }
      else
      {
        $(".modal").addClass("invalid-data");
        $("#loginemail").addClass("alert alert-danger");
        document.getElementById("loginemail").value="";
        document.getElementById("loginemail").placeholder="invalid data";
        $("#loginpassword").addClass("alert alert-danger");
        document.getElementById("loginpassword").placeholder="invalid data";
        document.getElementById("loginpassword").value="";
      }
    }
  };
  function loginvalidate(login)
  {
    loginemail=document.getElementById("loginemail").value.trim();
    loginpassword=document.getElementById("loginpassword").value.trim();
    if(loginemail=="")
    {
      $("#loginemail").addClass("alert alert-info"); 
      document.getElementById("loginemail").placeholder="please enter some data";
      document.getElementById("loginemail").value="";
    }
    if(loginpassword=="")
    {
      $("#loginpassword").addClass("alert alert-info");
      document.getElementById("loginpassword").placeholder="please enter some data";
      document.getElementById("loginpassword").value="";
    }
    if(loginemail!="" && loginpassword!="")
    {
      $("#loginemail").removeClass("alert alert-info"); 
      document.getElementById("loginemail").placeholder="email";
      $("#loginpassword").removeClass("alert alert-info"); 
      document.getElementById("loginpassword").placeholder="password";
      login();
    }
  }
});


