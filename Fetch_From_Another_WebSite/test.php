<?php
/**
 * Created by IntelliJ IDEA.
 * User: yaojean-elisee
 * Date: 15/05/2018
 * Time: 22:21
 */

$web_site = file_get_contents('http://www.nouchi.com/dico/liste-des-derniers-mots/1.html');

$keywords = preg_split("<a title=\"", $web_site);

//$the_start = 'row first-row">';
//$the_end = '<div class="pagination"><div class="pagination-bg">';
////To take information of a specific part tile
//$the_start = explode($the_start, $web_site);
//$the_end = explode($the_end, $the_start[1]);
//
//$part = $the_end[0]->getElementsByTagName('a');
echo $keywords;

//$formated_website = strip_tags($main_part, "<a>");
//
//
////Load the HTML page
//// $html = file_get_contents('page.htm');
////Create a new DOM document
//$dom = new DOMDocument;
//
////Parse the HTML. The @ is used to suppress any parsing errors
////that will be thrown if the $html string isn't valid XHTML.
//@$dom->loadHTML($formated_website);
//
////Get all links. You could also use any other tag name here,
////like 'img' or 'table', to extract other tags.
//$links = $dom->getElementsByTagName('a');
//
//$title_array = array();
//
////Iterate over the extracted links and display their URLs
//foreach ($links as $link){
//    //Extract and show the "title" attribute.
//    array_push($title_array, strip_tags(utf8_decode($link->getAttribute('title'))));
//}
//
//$result = array_filter($title_array);
//$final_array = array_values($result);
