<?php
/**
 * Created by PhpStorm.
 * User: yaojean-elisee
 * Date: 13/05/2018
 * Time: 02:22
 */
//include ('db_connect.php');
class db
{
    var $m_word_title;
    var $m_word_subtitle_type;
    var $m_word_subtitle_synonym;
    var $m_word_description;

    /**
     * @param mixed $m_word_title
     */
    public function setMWordTitle($m_word_title): void
    {
        $this->m_word_title = $m_word_title;
    }

    /**
     * @param mixed $m_word_subtitle_type
     */
    public function setMWordSubtitleType($m_word_subtitle_type): void
    {
        $this->m_word_subtitle_type = $m_word_subtitle_type;
    }

    /**
     * @param mixed $m_word_subtitle_synonym
     */
    public function setMWordSubtitleSynonym($m_word_subtitle_synonym): void
    {
        $this->m_word_subtitle_synonym = $m_word_subtitle_synonym;
    }

    /**
     * @param mixed $m_word_description
     */
    public function setMWordDescription($m_word_description): void
    {
        $this->m_word_description = $m_word_description;
    }

    /**
     * @param $connexion
     */
    public function add_data($connexion)
    {
        $date = date('Y-m-d H:i:s');

        $q = "INSERT INTO `word`(`title`, `type`, `synonym`, `description`, `time`) VALUES ('".addslashes($this->m_word_title)."','".addslashes($this->m_word_subtitle_type)."','".addslashes($this->m_word_subtitle_synonym)."','".addslashes($this->m_word_description)."','".$date."')";

//        echo $q."<br />";

        $result = mysqli_query($connexion, $q);

    }
}