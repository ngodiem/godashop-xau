<?php 
class AccountController {
	// thông tin tài khoản
	function profile() { 
		$email = $_SESSION["email"];
		$customerRepository = new CustomerRepository();
		$customer = $customerRepository->findEmail($email);
		require "view/account/profile.php";
	}

	function updateProfile() {//cập nhật thông tin tài khoản
		$email = $_SESSION["email"]; // lấy email ra
		$customerRepository = new CustomerRepository();
		$customer = $customerRepository->findEmail($email); // lấy customer dựa vào email
		$customer->setName($_POST["fullname"]);// cập nhật mới
		$customer->setMobile($_POST["mobile"]);
		if (!empty($_POST["password"])) { // nếu có nhập pw
			if (md5($_POST["old-password"]) != $customer->getPassword()) {
				$_SESSION["error"] = "Mật khẩu hiện tại không đúng";
				header("location: index.php?c=account&a=profile");
				exit;
			}
			$customer->setPassword(md5($_POST["password"]));

		}

		if ($customerRepository->update($customer)) {
			$_SESSION["success"] = "Cập nhật tài khoản thành công";
			$_SESSION["name"] =  $customer->getName();
		}
		else {
			$_SESSION["error"] = "Cập nhật tài khoản thất bậi";
		}
		header("location: index.php?c=account&a=profile");

	}

// đơn hàng của tôi
	function orders() {
		$email = $_SESSION["email"];
        $customerRepository = new CustomerRepository();
        $customer = $customerRepository->findEmail($email);
        $orderRepository = new OrderRepository();
		$orders = $orderRepository->getByCustomerId($customer->getId());//tìm được những đơn hàng của customer
		require "view/account/orders.php";
	}
//chi tiết đơn hàng
	function orderDetail() {
		$orderRepository = new OrderRepository();
		$id = $_GET["id"]; // dựa vào mã id  
		$order = $orderRepository->find($id); // lấy ra đơn hàng cụ thể
		require "view/account/orderDetail.php";
	}

	function defaultShipping() { // địa chỉ giao hàng mặc định

        $email = $_SESSION["email"];
        $customerRepository = new CustomerRepository();
        $customer = $customerRepository->findEmail($email);

        include "layout/variable_address.php";
		require "view/account/defaultShipping.php";
	}
//  cập nhật địa chỉ giao hàng mặc định
	function updateDefaultShipping() {
		$email = $_SESSION["email"]; // cập nhật dựa vào email
		$customerRepository = new CustomerRepository();
		$customer = $customerRepository->findEmail($email);// từ email tìm được customer
		$customer->setShippingName($_POST["fullname"]);
		$customer->setShippingMobile($_POST["mobile"]);
		$customer->setHousenumberStreet($_POST["address"]);
		$customer->setWardId($_POST["ward"]);

		if ($customerRepository->update($customer)) {
			$_SESSION["success"] = "Cập nhật địa chỉ giao hàng mặc định thành công";
		}
		else {
			$_SESSION["error"] = "Cập nhật địa chỉ giao hàng mặc định thất bại";
		}
		header("location: index.php?c=account&a=defaultShipping");
	}
}

 ?>