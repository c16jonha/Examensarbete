// ==UserScript==
// @name         Searcher/Logger
// @namespace    http://tampermonkey.net/
// @version      0.1
// @description  try to take over the world!
// @author       You
// @match        http://localhost/Examensarbete/index.php
// @require      https://raw.githubusercontent.com/c16jonha/ContextFreeLib/master/js/randapp.js
// @require      https://raw.githubusercontent.com/c16jonha/ContextFreeLib/master/js/contextfreegrammar.js
// @grant        none
// ==/UserScript==

    //  Creates an instance of the included library ContextFreeLib
    var Grammar= new ContextFreeGrammar({
        "probabilityNounPhrase":0.5,
        "probabilityVerbPhrase":0.5,
        "probabilityDualAdjectives":0.5,
        "probabilityStartAdjective":0.5,
        "distributionOfNouns":"normal",
        "distributionOfVerbs":"normal",
        "distributionOfAdjectives":"normal",
        "distributionOfAdverbs":"normal",
        "distributionOfDeterminers":"normal",
        "distributionOfConjunctions":"normal",
        "distributionOfModals":"normal",
        "randomSeed":101
    });
    //function that generates a searchword
    function generateSearch(){
        var Search = "";
        //randomizer for determining the type of word
        var rand = (localStorage.getItem('rand') != null) ? JSON.parse(localStorage.getItem('rand')):0;
        if(rand == 0){
            Search = Grammar.generateRandomNoun();
            rand++;
            localStorage.setItem('rand',rand);
        }
        else if(rand == 1){
            Search = Grammar.generateRandomAdjective();
            rand++;
            localStorage.setItem('rand',rand);
        }
        else if(rand == 2){
            Search = Grammar.generateRandomVerb();
            rand++;
            localStorage.setItem('rand',rand);
        }
        else if(rand == 3){
            Search = Grammar.generateRandomAdverb();
            rand++;
            localStorage.setItem('rand',rand);
        }
        else if(rand == 4){
            Search = Grammar.generateRandomDeterminer();
            rand++;
            localStorage.setItem('rand',rand);
        }
        else if(rand == 5){
            Search = Grammar.generateRandomConjunction();
            rand=0
            localStorage.setItem('rand',rand);
        }
        return Search;
    }
   //function that automatically searches for articles for certain number of times
   function autoSearch(){
       var interval = setInterval(function() {
       var j = (localStorage.getItem('j') !=null) ? JSON.parse(localStorage.getItem('j')):0;
       var searchword = document.getElementById("searchBar");
       var searchbutton = document.getElementById("searchButton");
       searchword.value = generateSearch();
        if(j<200){
          j++;
          localStorage.setItem('j', j);
          searchbutton.click();
        }
       else{
           console.log("stopped at search " + j);
       }
      }, 500);
}
autoSearch();
