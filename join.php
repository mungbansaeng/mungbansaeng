<?php

    if (!$_GET['cert'] || $_GET['cert'] == "N") {

        include_once dirname(__FILE__)."/front/view/member/joinTerm.php";

    } else {

        include_once dirname(__FILE__)."/front/view/member/join.php";

    }

?>