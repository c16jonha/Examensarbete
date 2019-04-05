//function for going back to the page's original state
function homePage(){
  var noResult = document.getElementById('noResult');
  var searchResult = document.getElementsByClassName('searchResult');
  var Article = document.getElementsByClassName('Article');

  noResult.style.display = "none";
  for (var i=0;i<searchResult.length;i+=1){
    searchResult[i].style.display = 'none';
  }
  for (var i=0;i<Article.length;i+=1){
    Article[i].style.display = 'block';
  }
}
function showText(c, index){
  var closed = false;
  var x = document.getElementsByClassName(c);
    for (var i = 0; i < x.length; i++) {
      if(x[index].style.display =="block"){
        closed = true;
      }
      x[i].style.display ="none";
    }
    if(!closed){
      x[index].style.display ="block";
    }
}
/* Will be used later
function autoPublish(){
    document.getElementById("headingInput").value = "Yo";
    document.getElementById("authorInput").value = "YOYO";
    document.getElementById("bodytextInput").value = "Ey yo yo yo yo hehehehe";

}

function autoSearch(){
    document.getElementById("headingInput").value = "Yo";
    document.getElementById("authorInput").value = "YOYO";
    document.getElementById("bodytextInput").value = "Ey yo yo yo yo hehehehe";
}
*/

//function that saves the query response time in localStorage and prints it out in the console
var TimeString ="";
function saveTime(){
  var Times = document.getElementsByClassName('entryTime');
  for(var i = 0;i < Times.length; i++){
    var AllTimes;
    if(localStorage.getItem('Time') != null){
        AllTimes = localStorage.getItem('Time') + " " + Times[i].innerHTML;
    } else {
        AllTimes = Times[i].innerHTML;
    }
    localStorage.setItem('Time', AllTimes);
    TimeString = "Times (ms): " + localStorage.getItem('Time') +",";
  }
  console.log(TimeString);
}
