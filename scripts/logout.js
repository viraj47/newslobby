  Barba.Dispatcher.on('newPageReady', function(currentStatus, oldStatus, container) {

  var xhttp = new XMLHttpRequest();  
  $("#logout").click(function(){
  xhttp.open("POST", "afterlogin.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("logout=true");
  console.log("sent");
  });
  
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        window.location.assign("http://localhost/oep/home.php");
    }
  };
});