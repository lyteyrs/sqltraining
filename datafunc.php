<?php

function formdata($field)
{
    $_POST[$field]??='';
    return htmlspecialchars(stripslashes($_POST[$field]));
}
