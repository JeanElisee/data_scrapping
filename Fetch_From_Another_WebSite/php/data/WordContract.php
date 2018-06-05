<?php
/**
 * Created by PhpStorm.
 * User: yaojean-elisee
 * Date: 04/06/2018
 * Time: 20:18
 */

class WordContract
{
    /**
     *
     */
    static final function WordEntry()
    {

        define('TABLE_NAME', 'word');

        define('COLUMN_ID', 'id');

        define('COLUMN_TITLE', 'word_title');

        define('COLUMN_SYNONYM', 'word_synonym');

        define('COLUMN_TYPE', 'word_synonym');

        define('COLUMN_DESCRIPTION', 'word_description');
    }
}