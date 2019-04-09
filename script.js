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
