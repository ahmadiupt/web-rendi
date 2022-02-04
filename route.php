<?php
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    switch ($page) {
        case 'home':
            # code...
            break;
        
        default:
            include "partials/404.php"
            break;
    } else {
        include "partials/home.php"
    }   
}