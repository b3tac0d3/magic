<?php
RequireMulti( 
    "config.php",
    "scripty_stuf/db.php",
    "scripty_stuff/log.php",
    "scripty_stuff/query_record_audits.php",
    "scripty_stuff/query.php",
    "scripty_stuff/table.php"
);

function RequireMulti($files) {
    global $php;
    global $depends;
    $files = func_get_args();
    foreach($files as $file)
        require_once($php . $file . ".php");
}
?>