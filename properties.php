<?php

$constant = [
    "ROUTE_FILE" => "slugs.yml",
    "CONF_DB_FILE" => "config.yml",

    ///// BDD /////
    "DBDRIVER" => "pgsql"
];

foreach ($constant as $key => $value) {
    if (!defined($key))
        define($key, $value);
}

////// BDD //////
if (file_exists(CONF_DB_FILE)) {
    $db = yaml_parse_file(CONF_DB_FILE);

    $constantDb = [
        "DBHOST" => $db["configuration"]["dbhost"],
        "DBNAME" => $db["configuration"]["dbname"],
        "DBUSER" => $db["configuration"]["dbuser"],
        "DBPWD" => $db["configuration"]["dbpwd"],
        "DBPORT" => $db["configuration"]["dbport"],
        "HOST" => $db["configuration"]["host"]
    ];

    foreach ($constantDb as $key => $value) {
        if (!defined($key))
            define($key, $value);
    }
}
