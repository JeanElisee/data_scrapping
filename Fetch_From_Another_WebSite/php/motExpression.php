<?php

//include ('compil_function.php');
/**
 * Created by PhpStorm.
 * User: yaojean-elisee
 * Date: 12/05/2018
 * Time: 21:57
 */

class motExpression
{
    /**
     * @var
     */
    var $mWebSite;
    /**
     * @var
     */
    var $mStart;
    /**
     * @var
     */
    var $mEnd;
    /**
     * @var
     */
    var $mTitle;
    /**
     * @var
     */
    var $mMainPart;

    /**
     * @var
     */
    var $mSubtitle;
    /**
     * @var
     */
    var $mTypeSubtitle;
    /**
     * @var
     */
    var $mSynonymSubtitle;

    function hasMainPart() {
        $web_site_des = file_get_contents($this->mWebSite);

        $title_format = str_replacement(strtolower(str_replace(" ","-", str_replacement($this->mTitle))));
        $tagToBeChecked = '<a title="'.$this->mTitle.'" href="/dico/liste-des-derniers-mots/item/'.$title_format.'.html">';

        if (strpos($web_site_des, $tagToBeChecked) == TRUE) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * @return mixed
     */
    function getMainPart(){
        $web_site_des = file_get_contents($this->mWebSite);

        $title_format = str_replacement(strtolower(str_replace(" ","-", str_replacement($this->mTitle))));

        $the_start = explode('<h2 class="pos-title">
	 <a title="'.$this->mTitle.'" href="/dico/liste-des-derniers-mots/item/'.$title_format.'.html">', $web_site_des);
        $the_end = explode('data-url="http://www.nouchi.com/dico/liste-des-derniers-mots/item/'.$title_format.'.html"', $the_start[1]);

        $main_part = explode('<div class="element element-rating">', $the_end[0]);
        $main = $main_part[0];
        return $main;
    }

    /**
     * @param $main_part
     * @return string
     */
    function getTitle() {
        //Recuperer le mot ici appeler title, nous travaillons ici avec la partie retenu du site web. Tout ce qui est contenu dans main_part avant <p class="pos-subtitle">
        //0 signifi avant
        //1 apres le tag
        $partOfThePageContainingTheTitle = explode('</a> </h2>', $this->mMainPart);
        //To check if thr is a subtitle
        $tileToBeSaved = $partOfThePageContainingTheTitle[0];
        //Tire final qui doit etre sauvegarder
        $tileToBeSaved = trim(strip_tags($tileToBeSaved));
        return $tileToBeSaved;
    }

    public function hasSubtitle()
    {
        if (strpos($this->mMainPart, $this->mSubtitle) == TRUE) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * @return mixed
     */
    public function getMSubtitle()
    {
        $checkSynonyme = "Synonyme";

        $start = explode('<p class="pos-subtitle">', $this->mMainPart);
        if (strpos($this->mMainPart, $this->mSubtitle) == TRUE && strpos($this->mMainPart, $checkSynonyme) == FALSE) {
            //Tout ce qui ce situe apres la description
            $partOfThePageContainingTheSubtitleType = explode('<div class="pos-description">', $start[1]);

            $typeSubtitleToBeSaved = "";
            $typeSubtitleToBeSaved = $partOfThePageContainingTheSubtitleType[0];
//            $typeSubtitleToBeSaved = strip_tags($typeSubtitleToBeSaved);
            $this->mTypeSubtitle = trim(strip_tags($typeSubtitleToBeSaved));
            return false;
        }
        elseif (strpos($this->mMainPart, $this->mSubtitle) == TRUE && strpos($this->mMainPart, $checkSynonyme) == TRUE) {
            //De <p class="pos-subtitle"> jusqu'a <span class="element element-text last">
            $partOfThePageContainingTheSubtitleType = explode('<span class="element element-text last">', $start[1]);
            $typeSubtitleToBeSaved = $partOfThePageContainingTheSubtitleType[0];

            $partOfThePageContainingTheSubtitleSynonyme = explode('<div class="pos-description">', $partOfThePageContainingTheSubtitleType[1]);
            $synonymSubtitleToBeSaved = $partOfThePageContainingTheSubtitleSynonyme[0];
            $this->mTypeSubtitle = trim(strip_tags($typeSubtitleToBeSaved));
            $this->mSynonymSubtitle = trim(strip_tags($synonymSubtitleToBeSaved));
            return true;
        }
    }

    /**
     * @return mixed|string
     */
    function getDescription() {
        $partOfThePageContainingTheDescription = explode('<div class="pos-description">', $this->mMainPart);

        $descriptionToBeSaved = "";
        $descriptionToBeSaved = $partOfThePageContainingTheDescription[1];
        //Garder seulement de tag <p>
        $descriptionToBeSaved = strip_tags($descriptionToBeSaved, "<p>");
        //Remplacer tous les </p> avec <br />
        $descriptionToBeSaved = str_replace("</p>", "<br />", $descriptionToBeSaved);

        $descriptionToBeSaved = str_replace("<p>", "", $descriptionToBeSaved);
        //Ne garder que le text et les tags <br />
        $descriptionToBeSaved = trim($descriptionToBeSaved);
        return $descriptionToBeSaved;
    }

    /**
     * @return array
     */
    function wordList() {
        $web_site = file_get_contents($this->mWebSite);

        //To take information of a specific part tile
        $the_start = explode($this->mStart, $web_site);
        $the_end = explode($this->mEnd, $the_start[1]);
        $main_part = $the_end[0];

        $formated_website = strip_tags($main_part, "<a>");


        //Load the HTML page
        // $html = file_get_contents('page.htm');
        //Create a new DOM document
        $dom = new DOMDocument;

        //Parse the HTML. The @ is used to suppress any parsing errors
        //that will be thrown if the $html string isn't valid XHTML.
        @$dom->loadHTML($formated_website);

        //Get all links. You could also use any other tag name here,
        //like 'img' or 'table', to extract other tags.
        $links = $dom->getElementsByTagName('a');

        $title_array = array();

        //Iterate over the extracted links and display their URLs
        foreach ($links as $link){
            //Extract and show the "title" attribute.
            array_push($title_array, strip_tags(utf8_decode($link->getAttribute('title'))));
        }

        $result = array_filter($title_array);
        $final_array = array_values($result);

        return $final_array;
    }

    /**
     * @param mixed $mWebSite
     */
    public function setMWebSite($mWebSite): void
    {
        $this->mWebSite = $mWebSite;
    }

    /**
     * @param mixed $mStart
     */
    public function setMStart($mStart): void
    {
        $this->mStart = $mStart;
    }

    /**
     * @param mixed $mEnd
     */
    public function setMEnd($mEnd): void
    {
        $this->mEnd = $mEnd;
    }

    /**
     * @param mixed $mTitle
     */
    public function setMTitle($mTitle): void
    {
        $this->mTitle = $mTitle;
    }

    /**
     * @param mixed $mMainPart
     */
    public function setMMainPart($mMainPart): void
    {
        $this->mMainPart = $mMainPart;
    }

    /**
     * @param mixed $mSubtitle
     */
    public function setMSubtitle($mSubtitle): void
    {
        $this->mSubtitle = $mSubtitle;
    }
    /**
     * @param mixed $mTypeSubtitle
     */
    public function setMTypeSubtitle($mTypeSubtitle): void
    {
        $this->mTypeSubtitle = $mTypeSubtitle;
    }

    /**
     * @param mixed $mSynonymSubtitle
     */
    public function setMSynonymSubtitle($mSynonymSubtitle): void
    {
        $this->mSynonymSubtitle = $mSynonymSubtitle;
    }

    public function getMTypeSubtitle()
    {
        return $this->mTypeSubtitle;
    }

    /**
     * @return mixed
     */
    public function getMSynonymSubtitle()
    {
        return $this->mSynonymSubtitle;
    }
}