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
        var rand1 = (localStorage.getItem('rand1') != null) ? JSON.parse(localStorage.getItem('rand1')):0;
        var Heading = "";
        if(rand1 == 0){
            Heading = Grammar.generateRandomAdjective() + " ";
            Heading += Grammar.generateRandomAdjective() + " ";
            Heading += Grammar.generateRandomNoun();
            rand1++;
            localStorage.setItem('rand1',rand1);
        }
        else if(rand1 == 1){
            Heading = Grammar.generateRandomNoun() + " ";
            Heading += Grammar.generateRandomVerb() + " ";
            Heading += Grammar.generateRandomAdjective() + " ";
            Heading += Grammar.generateRandomNoun();
            rand1++;
            localStorage.setItem('rand1',rand1);
        }
        else if(rand1 == 2){
            Heading = Grammar.generateRandomAdjective() + " ";
            Heading += Grammar.generateRandomNoun() + " ";
            Heading += Grammar.generateRandomConjunction() + " ";
            Heading += Grammar.generateRandomAdjective() + " ";
            Heading += Grammar.generateRandomNoun();
            rand1++;
            localStorage.setItem('rand1',rand1);
        }
        else if(rand1 == 3){
            Heading = Grammar.generateRandomAdjective() + " ";
            Heading += Grammar.generateRandomNoun() + " ";
            Heading += Grammar.generateRandomAdverb() + " ";
            Heading += Grammar.generateRandomVerb() + " ";
            Heading += Grammar.generateRandomAdjective() + " ";
            Heading += Grammar.generateRandomNoun();
            rand1=0;
            localStorage.setItem('rand1',rand1);
        }
        return Heading.charAt(0).toUpperCase()+ Heading.slice(1);
    }

    //Function that generates a random subheading
    function generateSubheading(){
        var rand2 = (localStorage.getItem('rand2') != null) ? JSON.parse(localStorage.getItem('rand2')):0;
        var Subheading = "";
        if(rand2 == 0){
            Subheading = Grammar.generateSentence();
            rand2++;
            localStorage.setItem('rand2',rand2);
        }
        else if(rand2 == 1){
            Subheading = Grammar.generateSentence() + " ";
            Subheading += Grammar.generateSentence();
            rand2 = 0;
            localStorage.setItem('rand2',rand2);
        }
        return Subheading;
    }
    //Function that generates a random bodytext
    function generateBodyText(){
        var rand3 = (localStorage.getItem('rand3') != null) ? JSON.parse(localStorage.getItem('rand3')):0;
        var BodyText = "";
        var x;
        if(rand3 == 0){
            for(x=0;x<60;x++){
                BodyText += " " + Grammar.generateSentence();
            }
            rand3++;
            localStorage.setItem('rand3',rand3);
        }
        else if(rand3==1){
            for(x=0;x<45;x++){
                BodyText += " " + Grammar.generateSentence();
            }
            rand3++;
            localStorage.setItem('rand3',rand3);
        }
        else if(rand3==2){
            for(x=0;x<30;x++){
                BodyText += " " + Grammar.generateSentence();
            }
            rand3++;
            localStorage.setItem('rand3',rand3);
        }
        else if(rand3==3){
            for(x=0;x<75;x++){
                BodyText += " " + Grammar.generateSentence();
            }
            rand3 = 0;
            localStorage.setItem('rand3',rand3);
        }
        return BodyText;
    }
    //Function that generates a random Authorname
    function generateAuthor(){
        var Author = Grammar.generateRandomNoun() + " ";
        Author += Grammar.generateRandomNoun();
        return Author.charAt(0).toUpperCase()+ Author.slice(1);
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
     if(i<30){
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
