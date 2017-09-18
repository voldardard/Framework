<?php

require_once(F_DIRECTORY . '/libs/php/functions/logs.php');

$logs = new logs('displayLogs');

$gotLogs = array_reverse($logs->accessToLogs());

foreach ($gotLogs as $lineNumber => $lineContent) {
    echo '<span id="' . $lineNumber . '">[' . $lineNumber, '] ', $lineContent . '</span><br/>';
}