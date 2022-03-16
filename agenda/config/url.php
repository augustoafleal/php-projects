<?php

    //$BASE_URL = "http" . (isset($_SERVER['HTTPS'])?"s":"") . "://" . dirname($_SERVER['REQUEST_URI'] . '?') . '/';

    $BASE_URL = "http://" . $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI'] . '?') . '/';

?>