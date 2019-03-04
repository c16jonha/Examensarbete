function ShowText(c, index){
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

//for publishing articles
function createArticle(){
}
/* For later
function searchFunction(){
  var articles, filter, i, txtValue, heading, contents;
  input = document.getElementsById("searchBar");
  filter = input.value.toUpperCase();
  articles = document.getElementsByClassName("Article");
  contents = document.getElementsByClassName("content");
}
*/
