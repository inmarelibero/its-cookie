<?php

class TemplateHelper
{
    /**
     * @return void
     */
    function printHead($metaTitle = 'My website')
    {
        require_once(__DIR__ . '/../../templates/_head.php');
    }
}