<?php

// update with our group info
/**
 * Function to localize our site
 * @param $site The Site object
 */
return function(Game\Site $site) {
// Set the time zone
    date_default_timezone_set('America/Detroit');

    $site->setEmail('');
    $site->setRoot(''); // set
    $site->dbConfigure('', // setup
        '',       // Database user
        '',     // Database password -- fill out
        'sorry_');            // Table prefix
};
