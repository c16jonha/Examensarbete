//not finished yet
function homePage(){
    var noResult = document.getElementById("noResult");
    var searchResult = document.getElementsByClassName("searchResult");
    var Article = document.getElementsByClassName("Article");

    if(noResult || searchResult != null){
      console.log("not null");
      noResult.style = "display: 'none'";
      searchResult.style = "display: 'none'";
      Article.style = "display: 'block'";
      location.reload();
    }
    else{
      location.reload();
      console.log("null");
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
*/
