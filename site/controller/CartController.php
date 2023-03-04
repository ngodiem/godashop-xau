<?php 
class CartController {
	protected $cartStorage;
	function __construct() {
		$this->cartStorage = new CartStorage(); // lưu trên file
	}
	function display() {
		$cart = $this->cartStorage->fetch(); // catsStorage thao tác trên file
		// bản chất cooke là file thôi
		echo json_encode($cart->convertToArray()); // lần đầu trả về array rổng, chuyển về chuổi
		// $cart->convertToArray() chuyển đối tượng sang array  biến $cart là kiểu đối tượng
	}

	function add() { // server  xl
		$product_id = $_GET["product_id"]; // server lấy product_id = 2
		$qty = $_GET["qty"]; // qty=1;
		$cart = $this->cartStorage->fetch(); // lấy giỏ hàng ra(lần đầu 0)
		// lần 2 mua->fetch();
		$cart->addProduct($product_id, $qty); // add 1 sp vào
		$this->cartStorage->store($cart);  // sau đó dùng hàm store	 để lưu ở dạng $_SESSION và setcookie(name);
		echo json_encode($cart->convertToArray());
		//json_encode  chuyển array về chuổi dạng json(key:giá trị)
		
	}

	function update() {
		$product_id = $_GET["product_id"];
		$qty = $_GET["qty"];
		$cart = $this->cartStorage->fetch(); // lấy từ trong giỏ hàng ra

		$cart->deleteProduct($product_id); // xóa đi $product_id củ
		$cart->addProduct($product_id, $qty); // cập nhật lại $product_id, $qty

		$this->cartStorage->store($cart); // lưu lại cho lần sau

		echo json_encode($cart->convertToArray()); // lưu xuống trình duyệt
	}

	function delete() {
		$product_id = $_GET["product_id"];
		$cart = $this->cartStorage->fetch();

		$cart->deleteProduct($product_id);

		$this->cartStorage->store($cart);

		echo json_encode($cart->convertToArray()); // đổ dữ liệu về cho trình duyệt
	}
	
}