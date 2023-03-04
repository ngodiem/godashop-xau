<?php 
class CartStorage {
	function store($cart) { // lưu vào giỏ hàng
		session_id() || session_start(); // kt session đã strats chưa, nếu start rồi có mã ss
		$_SESSION["cart"] = serialize($cart); // $cart là kiểu đối tượng oject, không lưu xuống file được serialize($cart) chuyển đối tượng sang chuỗi
		setcookie("cart", serialize($cart),  time()+24*60*60);//keep one day 
	} 

	function fetch() { // lấy ra 
		session_id() || session_start();
		if (empty($_SESSION["cart"])) {
			if (empty($_COOKIE["cart"])) {
				$cart = new Cart(); // lấy cart() mới
				return $cart; // return kết thúc luôn cart mới k có gì hết
			}
			//update session;
			$_SESSION["cart"] = $_COOKIE["cart"]; // nếu có trong $_COOKIE thì chuyển nội dung sang $_SESSION để mọi thứ làm việc trên $_SESSION
		}
		$cart = unserialize($_SESSION["cart"]);
		//unserialize($_SESSION["cart"]); chuyển từ chuỗi sang đối tượng

		return $cart;
	}

	function clear() {
		session_id() || session_start();
		unset($_SESSION["cart"]);
		setcookie("cart", null,  time()-24*60*60);//keep one day
	}
}
 ?>