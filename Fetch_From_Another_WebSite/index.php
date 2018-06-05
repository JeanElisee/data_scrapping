<?php

include('php/motExpression.php');
include('php/db.php');
include('php/compil_function.php');
include('php/db_connect.php');

//Create the connexion to the DB
$conn = createConnexion();

//Will count the number of rows added to the DB
$nombre_d_ajout = 0;

//There is 263 pages so from page 1 to 264
//for ($page = 1; $page < 264; $page++) {
//    $index = 0;
//    15 elements are there on each pages
for ($index = 0; $index < 15; $index++) {
    //Web site name, the page name will change according to the first for loop
    $web_site = "http://www.nouchi.com/dico/liste-des-derniers-mots/1.html"; //For Test purposes
//        $web_site = "http://www.nouchi.com/dico/liste-des-derniers-mots/" . $page . ".html";
    //Set from where we will start cutting the page
    $the_start = 'row first-row">';
    //Set from where we will stop cutting the page
    $the_end = '<div class="pagination"><div class="pagination-bg">';

    //Object word
    $word = new motExpression();

    //Set the different parameters for word to work
    $word->setMWebSite($web_site);
    $word->setMStart($the_start);
    $word->setMEnd($the_end);

    //Get the array containing the list of words
    $title_list = $word->wordList();

    //Initialise the different variable to empty so that they won't be messed on each itteration
    $word_title = "";
    $word_type = "";
    $word_synonym = "";
    $word_description = "";

    //Send the element we got in the array, to get details for each words
    $word->setMTitle($title_list[$index]);
//        $word->setMTitle($title_list[0]); //For Test purposes

    //The main part concern here the part of the page containing the details (title, type, synonym and description)
    $hasMainPart = $word->hasMainPart();

    //It might not be possible to check like that for each word of the website so first will check according
    //to the word if it exist a part from where we can get all the details we need to work.
    if ($hasMainPart): //Used like to skip when there is no main part found

        $main_part = $word->getMainPart(); //As thr is a main part we will store in a variable
        $word->setMMainPart($main_part); //Then send to the class to find the details

        $word_title = $word->getTitle(); //To take the title

        $word_description = $word->getDescription(); //To get the description

        $checkSub = '<p class="pos-subtitle">'; //This will help to know whether there is a part subtitle or not
        $word->setMSubtitle($checkSub); //Send to the class to check

        $hasSubtitle = $word->hasSubtitle(); //Will get if there is subtitle in a BOOLEAN

        if ($hasSubtitle):
            $value = $word->getMSubtitle(); //If there is only type or both type and synonym are available

            if ($value) {
                $word_type = $word->getMTypeSubtitle();
                $word_synonym = $word->getMSynonymSubtitle();
            } else {
                $word_type = $word->getMTypeSubtitle();
            }
        endif;
        $nombre_d_ajout += 1;

//            $db_object = new db();
//            //Blank space will replace by NULL if one variable is empty so that it won't create error in the database
//            $db_object->setMWordTitle(add_blank_space($word_title));
//            $db_object->setMWordSubtitleType(add_blank_space($word_type));
//            $db_object->setMWordSubtitleSynonym(add_blank_space($word_synonym));
//            $db_object->setMWordDescription(add_blank_space($word_description));
//            //Add the datas in the database
//            //Find a way to use the connection differently
//            $db_object->add_data($conn);
        //Delete object

        echo add_blank_space($word_title) . "<br />";
        echo add_blank_space($word_type) . "<br />";
        echo add_blank_space($word_synonym) . "<br />";
        echo add_blank_space($word_description) . "<br /><br />";
        unset($word);
//            unset($db_object);
    endif;
//    }
}

//Calculate execution time in seconde (/60) to get in minute
$time = (microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]) / 60;

//Final message to know what exactly happened
$message = "Terminer avec succès<br />";
$message .= "Nombre de mots ajoutés -> " . $nombre_d_ajout;
//$message .= "<br />Pages parcouru -> " . ($page - 1) . "<br />";
//$message .= $nombre_d_ajout . ' / ' . ($page - 1) * 15;
$message .= "<br />Temp total d'exécutation -> " . $time . " minutes.";

echo '<span style="color: blue">' . $message . '</span>';
