<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('pre')) {

    function pre($array) {
        echo "<pre>";
        print_r($array);
        echo "</pre>";
    }

}

if (!function_exists('page_alert_box')) {

    function page_alert_box($type = '', $title = '', $message = '') {
        $_SESSION['page_alert_box_type'] = $type;
        $_SESSION['page_alert_box_title'] = $title;
        $_SESSION['page_alert_box_message'] = $message;
    }

}