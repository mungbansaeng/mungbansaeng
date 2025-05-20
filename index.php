<?php

    if ($_GET['error'] == "404") {

        include_once dirname(__FILE__)."/public/404.php";

    } else if ($_GET['error'] == "401") {

        include_once dirname(__FILE__)."/public/401.php";

    } else {

        include_once dirname(__FILE__)."/front/view/main/index.php";

    }

?>	