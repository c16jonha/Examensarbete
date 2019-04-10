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

    //Function that generates a random heading
    function generateHeading(){
        var Heading = Grammar.generateRandomAdjective() + " ";
        Heading += Grammar.generateRandomAdjective() + " ";
        Heading += Grammar.generateRandomNoun();
        return Heading;
    }

    //Function that generates a random subheading
    function generateSubheading(){
        var Subheading = Grammar.generateSentence();
        return Subheading;
    }
    //Function that generates a random bodytext
    function generateBodyText(){
        var BodyText = "";
        for(var x=0;x<60;x++){
            BodyText += " " + Grammar.generateSentence();
        }
        return BodyText;
    }
    //Function that generates a random Authorname
    function generateAuthor(){
        var Author = Grammar.generateRandomNoun() + " ";
        Author += Grammar.generateRandomNoun();
        return Author;
    }

    //Function for automatically publishing a set of articles
    function autoPublish(){
     //Creates a variable that gets its value from localStorage
     var i = (localStorage.getItem('i') != null) ? JSON.parse(localStorage.getItem('i')):0;

     //Variables for the inputfields in the publishing DIV
     var headingInput = document.getElementById("headingInput");
     var subheadingInput = document.getElementById("subheadingInput");
     var authorInput = document.getElementById("authorInput");
     var bodyInput = document.getElementById("bodytextInput");
     var publishButton = document.getElementById("Publish");

     //Inserts data into the inputs by calling the functions for generating text
     headingInput.value = generateHeading();
     subheadingInput.value = generateSubheading();
     authorInput.value = generateAuthor();
     bodyInput.value = generateBodyText();

     //Creates as many articles as the if-statements allows
     if(i<300){
         i++;
         localStorage.setItem('i',i);
         publishButton.click();
         console.log("Published article number " + i);
     }
     else{
         console.log("Stopped at article "+ i);
     }
  }
//Calls the function autoPublish()
autoPublish();
