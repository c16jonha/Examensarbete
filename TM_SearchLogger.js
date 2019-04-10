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
        var rand = Math.floor(Math.random()*6);
        if(rand == 0){
            Search = Grammar.generateRandomNoun();
        }
        else if(rand == 1){
            Search = Grammar.generateRandomAdjective();
        }
        else if(rand == 2){
            Search = Grammar.generateRandomVerb();
        }
        else if(rand == 3){
            Search = Grammar.generateRandomAdverb();
        }
        else if(rand == 4){
            Search = Grammar.generateRandomDeterminer();
        }
        else if(rand == 5){
            Search = Grammar.generateRandomConjunction();
        }
        return Search;
    }
    //function that saves the query response time in localStorage and prints it out in the console
    var TimeString ="";
    function saveTime(){
        var Times = document.getElementsByClassName('entryTime');
        for(var i = 0;i<Times.length; i++){
            var AllTimes;
            if(localStorage.getItem('Time') != null){
                AllTimes = localStorage.getItem('Time') + " " + Times[i].innerHTML +",";
            } else {
                AllTimes = Times[i].innerHTML;
            }
            localStorage.setItem('Time', AllTimes);
            TimeString = "Times (ms): " + localStorage.getItem('Time');
        }
        console.log(TimeString);
   }
   //function that automatically searches for articles for certain number of times
   function autoSearch(){
       var j = (localStorage.getItem('j') !=null) ? JSON.parse(localStorage.getItem('j')):0;
       var searchword = document.getElementById("searchBar");
       var searchbutton = document.getElementById("searchButton");
       searchword.value = generateSearch();

        if(j<50){
          j++;
          localStorage.setItem('j', j);
          searchbutton.click();
          saveTime();
        }
       else{
           console.log("stopped at search " + j);
       }
}
autoSearch();
