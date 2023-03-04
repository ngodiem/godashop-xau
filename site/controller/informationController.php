<?php 
class informationController {
    function returnPolicy(){
        require "view/information/returnPolicy.php";
    }

    function paymentPolicy(){
        require "view/information/paymentPolicy.php";
    }

    function deliveryPolicy(){
        require "view/information/deliveryPolicy.php";
    }
}
 ?>