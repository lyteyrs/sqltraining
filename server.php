<?php

//making connection to the database
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=zuriboard', 'root', '');

//if connection not successfull
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
