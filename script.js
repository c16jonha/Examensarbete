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
