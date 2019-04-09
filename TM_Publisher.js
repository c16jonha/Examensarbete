// ==UserScript==
// @name         Publisher
// @namespace    http://tampermonkey.net/
// @version      0.1
// @description  Will loop through local xml-file and post data to the database
// @author       You
// @match        http://localhost/Examensarbete/index.php
// @require      https://raw.githubusercontent.com/c16jonha/ContextFreeLib/master/js/randapp.js
// @require      https://raw.githubusercontent.com/c16jonha/ContextFreeLib/master/js/contextfreegrammar.js
// @grant        none
// ==/UserScript==

//Tampermonkey Script for generating Data
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

    function generateHeading(){
        var Heading = Grammar.generateRandomAdjective() + " ";
        Heading += Grammar.generateRandomAdjective() + " ";
        Heading += Grammar.generateRandomNoun();
        return Heading;
    }

    function generateSubheading(){
        var Subheading = Grammar.generateSentence();
        return Subheading;
    }
    function generateBodyText(){
        var BodyText = "";
        for(var x=0;x<30;x++){
            BodyText += " " + Grammar.generateSentence();
        }
        return BodyText;
    }

    function generateAuthor(){
        var Author = Grammar.generateRandomNoun() + " ";
        Author += Grammar.generateRandomNoun();
        return Author;
    }

    function autoPublish(){
     var i = (localStorage.getItem('i') != null) ? JSON.parse(localStorage.getItem('i')):0;
     var headingInput = document.getElementById("headingInput");
     var subheadingInput = document.getElementById("subheadingInput");
     var authorInput = document.getElementById("authorInput");
     var bodyInput = document.getElementById("bodytextInput");
     var publishButton = document.getElementById("Publish");
     headingInput.value = generateHeading();
     subheadingInput.value = generateSubheading();
     authorInput.value = generateAuthor();
     bodyInput.value = generateBodyText();
     if(i<50){
      i++;
      localStorage.setItem('i',i);
      publishButton.click();
      console.log("Published article number " + i);
     }
     else{
     console.log("Stopped");
     }
  }
autoPublish();
