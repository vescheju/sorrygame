<?php

/**
 * Function to localize our site
 * @param $site The Site object
 */
return function(Game\Site $site) {
// Set the time zone
    date_default_timezone_set('America/Detroit');

    $site->setEmail('zhang717@msu.edu');
    $site->setRoot('/~zhang717/project1');
    $site->dbConfigure('mysql:host=mysql-user.cse.msu.edu;dbname=bhadang1',
        'bhadang1',       // Database user
        'F00t$ball',     // Database password
        'test_sorry_');            // Table prefix
};
