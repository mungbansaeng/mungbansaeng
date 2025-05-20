<?php 

    // 주문조회
    if ($_COOKIE['load'] == "orderList") {

        include_once dirname(__FILE__)."/front/view/layouts/header.php"; // 헤더

?>

<div class="board_container">
    <div class="flex-vc-hc-container">
        <div class="w1200">
            <ul class="board_titBox flex-vc-hsb-container">
                <li>주문/배송</li>
            </ul>

<?
        
        include_once dirname(__FILE__)."/front/view/mypage/mobileMypageHeader.php"; // 마이페이지 헤더

        include_once dirname(__FILE__)."/front/view/mypage/orderList.php";

    // 주문상세
    } else if ($_COOKIE['load'] == "orderDetail" || $_COOKIE['nonMemberorderSearch'] == "Y") {

        include_once dirname(__FILE__)."/front/view/layouts/header.php"; // 헤더

?>

<div class="board_container">
    <div class="flex-vc-hc-container">
        <div class="w1200">
            <ul class="board_titBox flex-vc-hsb-container">
                <li>주문상세내역</li>
            </ul>

<?

        if ($_COOKIE['load'] == "orderDetail") {

            include_once dirname(__FILE__)."/front/view/mypage/mobileMypageHeader.php"; // 마이페이지 헤더

        }

        include_once dirname(__FILE__)."/front/view/mypage/orderDetail.php";

    // 후기작성
    } else if ($_COOKIE['load'] == "reviewWrite") {

        include_once dirname(__FILE__)."/front/view/layouts/header.php"; // 헤더

?>

<div class="board_container">
    <div class="flex-vc-hc-container">
        <div class="w768">
            <ul class="board_titBox flex-vc-hsb-container">
                <li>후기작성</li>
            </ul>

<?

        include_once dirname(__FILE__)."/front/view/mypage/reviewWrite.php";

    // 후기작성완료
    } else if ($_COOKIE['load'] == "reviewWriteFinish") {

        include_once dirname(__FILE__)."/front/view/layouts/header.php"; // 헤더

?>

<div class="board_container">
    <div class="flex-vc-hc-container">
        <div class="w768">

<?

        include_once dirname(__FILE__)."/front/view/mypage/reviewWriteFinish.php";

    // 쿠폰 조회
    } else if ($_COOKIE['load'] == "couponList") {

        include_once dirname(__FILE__)."/front/view/layouts/header.php"; // 헤더

?>

<div class="board_container">
    <div class="flex-vc-hc-container">
        <div class="w1200">
            <ul class="board_titBox flex-vc-hsb-container">
                <li>내 쿠폰</li>
            </ul>

<?
        
        include_once dirname(__FILE__)."/front/view/mypage/mobileMypageHeader.php"; // 마이페이지 헤더

        include_once dirname(__FILE__)."/front/view/mypage/couponList.php";

    // 후기 조회
    } else if ($_COOKIE['load'] == "reviewList") {

        include_once dirname(__FILE__)."/front/view/layouts/header.php"; // 헤더

?>

<div class="board_container">
    <div class="flex-vc-hc-container">
        <div class="w1200">
            <ul class="board_titBox flex-vc-hsb-container">
                <li>후기관리</li>
            </ul>

<?
        
        include_once dirname(__FILE__)."/front/view/mypage/mobileMypageHeader.php"; // 마이페이지 헤더

        include_once dirname(__FILE__)."/front/view/mypage/reviewList.php";

    // 회원정보 수정
    } else if ($_COOKIE['load'] == "userInfoChangeView") {

        include_once dirname(__FILE__)."/front/view/layouts/header.php"; // 헤더

?>

<div class="board_container">
    <div class="flex-vc-hc-container">
        <div class="w1200">
            <ul class="board_titBox flex-vc-hsb-container">
                <li>회원정보수정</li>
            </ul>

<?
        
        include_once dirname(__FILE__)."/front/view/mypage/mobileMypageHeader.php"; // 마이페이지 헤더

        include_once dirname(__FILE__)."/front/view/mypage/userInfoChange.php";

    // 회원정보 수정
    } else if ($_COOKIE['load'] == "pointList") {

        include_once dirname(__FILE__)."/front/view/layouts/header.php"; // 헤더

?>

<div class="board_container">
    <div class="flex-vc-hc-container">
        <div class="w1200">
            <ul class="board_titBox flex-vc-hsb-container">
                <li>포인트 내역</li>
            </ul>

<?
        
        include_once dirname(__FILE__)."/front/view/mypage/mobileMypageHeader.php"; // 마이페이지 헤더

        include_once dirname(__FILE__)."/front/view/mypage/pointList.php";

    } else if ($_COOKIE['load'] == "nonMemberOrderSearch") {

        include_once dirname(__FILE__)."/front/view/layouts/header.php"; // 헤더

?>

<div class="board_container">
    <div class="flex-vc-hc-container">
        <div class="w1200">
            <ul class="board_titBox flex-vc-hsb-container">
                <li>비회원 주문조회</li>
            </ul>

<?

        include_once dirname(__FILE__)."/front/view/mypage/nonMemberOrderSearch.php";

    } else {

        include_once dirname(__FILE__)."/public/404.php";

    }
?>
        </div>
    </div>
</div>