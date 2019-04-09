// ==UserScript==
// @name         Searcher/Logger
// @namespace    http://tampermonkey.net/
// @version      0.1
// @description  try to take over the world!
// @author       You
// @match        http://localhost/Examensarbete/
// @grant        none
// ==/UserScript==

//tampermonkey script for automatically search for data and log the query response time
(function() {
    'use strict';

    // Your code here...
    function autoSearch(){
        var searchword = document.getElementById("searchBar");
    }
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
})();
