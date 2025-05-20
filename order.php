<?php 

    if ($_COOKIE['load'] == "cart") {

        include_once dirname(__FILE__)."/front/view/order/cart.php";

    } else if ($_COOKIE['load'] == "wish") {

        include_once dirname(__FILE__)."/front/view/order/wish.php";

    } else if ($_COOKIE['load'] == "orderSheet") {

        include_once dirname(__FILE__)."/front/view/order/orderSheet.php";

    } else if ($_COOKIE['load'] == "orderFinish") {

        include_once dirname(__FILE__)."/front/view/order/orderFinish.php";

    } else {

        include_once dirname(__FILE__)."/public/404.php";

    }

?>