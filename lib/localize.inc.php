<?php

// update with our group info
/**
 * Function to localize our site
 * @param $site The Site object
 */
return function(Game\Site $site) {
// Set the time zone
    date_default_timezone_set('America/Detroit');

    $site->setEmail('bhadang1@msu.edu');
    $site->setRoot('/~mccoyjes/project2');
    $site->dbConfigure('mysql:host=mysql-user.cse.msu.edu;dbname=bhadang1',
        'bhadang1',       // Database user
        'F00t$ball',     // Database password
        'sorry_');            // Table prefix
};