<?php

    include_once dirname(dirname(dirname(__FILE__)))."/front/service/productService.php";

    $orderStatisticsService = new OrderStatisticsService();

    $result = array("success");

    try {

        if ($_POST["act"] == "insert") {

            // 일별
            $orderStatisticsService = $orderStatisticsService -> orderStatisticsDayInsert();

            array_push($result, $orderStatisticsService);

        }

    } catch (Exception $errorMsg) {

        echo $errorMsg;

        exit;

    }

    echo json_encode($result);

?>