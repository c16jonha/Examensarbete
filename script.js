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

//function for filtering out the irrelevant content, not the final function for search
function searchFilter(){
  var input = document.getElementById("searchBar");
  var filter = input.value.toLowerCase();
  var nodes = document.getElementsByClassName('content');
//removes the highlight if the searchbar is empty
  if(filter == "") {
    for (i = 0; i < nodes.length; i++) {
      nodes[i].style = "background-color: #ffffff";
      nodes[i].style.display = "none";
    }
  }
  else{
    for (i = 0; i < nodes.length; i++) {
      if(nodes[i].innerText.toLowerCase().includes(filter)) {
          nodes[i].style = "background-color: yellow";
          nodes[i].style.display = "block";
      }
      else {
        nodes[i].style.display = "none";
      }
    }
  }
}
