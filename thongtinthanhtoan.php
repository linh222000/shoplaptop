<?php 
    include './connect.php';  
?>
<!doctype html>
<html lang="zxx">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>SLaptop</title>
  <link rel="icon" href="img/logolaptop.png">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <!-- animate CSS -->
  <link rel="stylesheet" href="css/animate.css">
  <!-- owl carousel CSS -->
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <!-- nice select CSS -->
  <link rel="stylesheet" href="css/nice-select.css">
  <!-- font awesome CSS -->
  <link rel="stylesheet" href="css/all.css">
  <!-- flaticon CSS -->
  <link rel="stylesheet" href="css/flaticon.css">
  <link rel="stylesheet" href="css/themify-icons.css">
  <!-- font awesome CSS -->
  <link rel="stylesheet" href="css/magnific-popup.css">
  <!-- swiper CSS -->
  <link rel="stylesheet" href="css/slick.css">
  <link rel="stylesheet" href="css/price_rangs.css">
  <!-- style CSS -->
  <link rel="stylesheet" href="css/style.css">
</head>
<style>
.header_bg {
    background-color: #ecfdff;
    height: 230px;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}
.padding_top1{
    padding-top:20px;
}
.a1{
    padding-top:130px;
}
.a2{
    height: 230px;
}
</style>
<body>
    <?php include 'header.php';?>
  <!--================Home Banner Area =================-->
  <!-- breadcrumb start-->
  <section class="breadcrumb header_bg">
        <div class="container">
            <div class="row justify-content-center a2">
                <div class="col-lg-8 a2">
                        <div class="a1">
                            <h2>Thanh toán đơn hàng</h2>
                        </div>
                </div>
            </div>
        </div>
    </section>
  <!-- breadcrumb end-->
  <!--================Cart Area =================-->
  <section class="cart_area padding_top1">
    <div class="container">
        <?php
        if (isset($_COOKIE["user"])) {
            $taikhoan = $_COOKIE["user"];
            foreach (selectAll("SELECT * FROM taikhoan WHERE taikhoan='$taikhoan'") as $row) {
                $idtaikhoan = $row['id'];
                $diachitaikhoan = $row['diachi'];
            }
        ?>
            <form class="cart_inner" method="post" action="">
                <div class="table-responsive">
                    <!-- <a href="history.php" class="btn_1" style="float:right; margin-bottom:20px;">Lịch sử đặt hàng</a> -->
                        <?php
                            if (rowCount("SELECT * FROM donhang WHERE id_taikhoan=$idtaikhoan && status=0") > 0) {
                                foreach (selectAll("SELECT * FROM donhang WHERE status=0 && id_taikhoan=$id_nguoidung") as $item) {
                                    $idDh= $item['id'];
                                }
                                if (rowCount("SELECT * FROM ctdonhang WHERE id_donhang=$idDh") > 0) {
                        ?>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Sản phẩm</th>
                                <th scope="col">Giá</th>
                                <th scope="col">Số lượng</th>
                                <th scope="col">Tổng</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $tongcong =0;
                                foreach (selectAll("SELECT * FROM ctdonhang WHERE id_donhang=$idDh") as $item) {
                                    $idSp = $item['id_sanpham'];
                                    $tong = $item['soluong'] * $item['gia'];
                                    $tongcong = $tongcong + $tong;
                            ?>
                            <tr>
                                <td>
                                <?php 
                                foreach (selectAll("SELECT * FROM sanpham WHERE id={$item['id_sanpham']}") as $row) {
                                    ?>
                                <div class="media">
                                    <div class="d-flex">
                                    <img src="img/product/<?= $row['anh1'] ?>" alt="" style="width:50px; height:50px;"/>
                                    </div>
                                    <div class="media-body">
                                                <p><?= $row['ten'] ?></p>
                                            <?php
                                        }
                                    ?>
                                    </div>
                                </div>
                                </td>
                                <td>
                                <h5 style="color: red;"><?= number_format($item['gia']) ?>vnđ</h5>
                                </td>
                                <td>
                                <div class="product_count">
                                    <input class="input-number" type="number" name="soluong" value="<?= $item['soluong'] ?>" min="1" max="100"/>
                                </div>
                                </td>
                                <td>
                                <h5 style="color: red;"><?= number_format($tong) ?>vnđ</h5>
                                </td>
                                <td>
                                    <a class="genric-btn primary circle" href="?removeproduct=<?= $item['id_sanpham'] ?>">Xóa</a>
                                </td>
                            </tr>
                            <?php
                                }
                            ?>
                            <!-- <tr class="bottom_button">
                                <td>
                                <a class="btn_1" href="?updatecart=<?= $item['id_donhang'] ?>">Cập nhật</a>
                                </td>
                                <td></td>
                                <td>
                                    <h5>Tổng cộng: </h5>
                                </td>
                                <td>
                                    <h5><?= number_format($tongcong) ?>đ</h5>
                                </td>
                            </tr> -->
                            <tr>
                                <td>
                                    <div class="checkout_btn_inner">
                                        <h5>Nhập địa chỉ nhận hàng: </h5>
                                        <textarea name="diachi" id="" cols="70" rows="4" placeholder="Nhập địa chỉ nhận hàng" required> <?= $diachitaikhoan ?></textarea>
                                    </div>
                                </td>
                                <td></td>
                                <td>
                                <h5></h5>
                                </td>
                                <td>
                                <h5></h5>
                                </td>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                <div class="col-md-4 hinhthucthanhtoan">
                    <h3 style="color: red;">Hình thức thanh toán</h3>
                    <td>
                        <p>Tổng tiền cần thanh toán: <?php echo number_format($tongcong,0,',','.').'vnđ' ?></p>
                    </td>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment" id="exampleRadios1" value="tien mat" checked>
                        <label class="form-check-label" for="exampleRadios1">
                            Tiền mặt
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment" id="exampleRadios2" value="chuyen khoan">
                        <label class="form-check-label" for="exampleRadios2">
                            Chuyển khoản
                        </label>
                    </div>
                    <!-- <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment" id="exampleRadios3" value="momo">
                        <img src="img/momo.png" height="32" width="32">
                        <label class="form-check-label" for="exampleRadios3">
                            MOMO
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment" id="exampleRadios4" value="paypal">
                        <img src="img/paypal.png" height="32" width="32">
                        <label class="form-check-label" for="exampleRadios4">
                            PAYPAL
                        </label>
                    </div> -->
                    <input style="margin-bottom: 20px;" type="submit" name="checkout" value="Gửi yêu cầu thanh toán" class="btn_1">
                </div>
                
                </div>
                <?php
                    } else {
                    ?>
                        <a href="product.php" class="btn_1" style="float:right; margin:0px 20px 20px 0px;">Mua Ngay</a>
                        <h2>Giỏ hàng của bạn đang trống</h2>   
                    <?php
                    }
                    ?>
            </form>
        <?php
        } else {
        ?>
        <h2>Giỏ hàng của bạn đang trống</h2>
        <?php
        }
        if (isset($_GET['removeproduct'])) {
            selectAll("DELETE FROM ctdonhang WHERE id_donhang=$idDh && id_sanpham={$_GET['removeproduct']}");
            header('location:cart.php');
        } 
        ?>
    <?php
    }
    ?>
    <?php
        if (isset($_POST["checkout"])) {
            $diachi = $_POST["diachi"];
            selectall("UPDATE donhang SET diachi='$diachi',thoigian='$today', tongtien= $tongcong, status=1 WHERE id_taikhoan=$idtaikhoan && status=0");
            echo "<script>alert('Yêu cầu thanh toán của bạn đã thành công, chúng tối sẽ phản hồi trong thời gian sớm nhất. Cảm ơn đã sử dụng sản phẩm của chúng tôi')
                location.href='cart.php'
            </script>";
        }
    ?>
    <!-- paypal -->
    <!-- <div id="paypal-button-container" style="width: 100px; height: 100px; margin-left: 20px;"></div> -->
    
    <td>--</td>
    <!-- thanh toan momo -->
    <form class="" method="post" target="_blank" enctype="application/x-www-form-urlencoded" action="xulythanhtoanmomo.php">
        <input style="margin-left: 20px;" type="submit" name="momo1" value="Thanh toán MOMO QRcode" class="btn btn-danger">
    </form>
    
    <td>--</td>
    <form class="" method="post" target="_blank" enctype="application/x-www-form-urlencoded" action="">
        <input style="margin-bottom: 20px; margin-left: 20px;" type="submit" name="momo" value="Thanh toán MOMO ATM" class="btn btn-danger">
    </form>
    <?php
        if (isset($_POST["momo"])) {
            $diachi = $_POST["diachi"];
            selectall("UPDATE donhang SET diachi='$diachi',thoigian='$today', tongtien= $tongcong, status=1 WHERE id_taikhoan=$idtaikhoan && status=0");
            echo "<script>location.href='xulythanhtoanmomo_atm.php'</script>";
        }
    ?>
    <div class="checkout_btn_inner float-right">
        <a style="margin-bottom: 40px;" class="btn_1" href="product.php">Tiếp Tục Mua Sắm</a>
                    <!-- <input class="btn_1" type='submit' name="thanhtoan" value="Xác nhận thanh toán" style="border: none"/> -->
                    <!-- <a class="btn_1" href="thongtinthanhtoan.php">Xác nhận thanh toán</a> -->
    </div>
  </section>
  <!--================login_part end =================-->
  <?php 
        include 'footer.php';
    ?>
    <!-- paypal -->
    <!-- <script src="https://www.paypal.com/sdk/js?client-id=AWxdFjGiJbamMgvS5Y-7CYpIFRI46y9r51MmcTctUZVCCzfz5C64LKU1l_t9Lr3IZmqdRzL1FFdNIKqN&currency=USD"></script>
    <script>
      paypal.Buttons({
        style: {
            layout: 'vertical',
            color: 'blue',
            shape: 'rect',
            label: 'paypal'
        },
        // Sets up the transaction when a payment button is clicked
        createOrder: (data, actions) => {
          return actions.order.create({
            purchase_units: [{
              amount: {
                value: '77.44' // Can also reference a variable or function
              }
            }]
          });
        },
        // Finalize the transaction after payer approval
        onApprove: (data, actions) => {
          return actions.order.capture().then(function(orderData) {
            // Successful capture! For dev/demo purposes:
            console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
            const transaction = orderData.purchase_units[0].payments.captures[0];
            alert(`Transaction ${transaction.status}: ${transaction.id}\n\nSee console for all available details`);
            // When ready to go live, remove the alert and show a success message within this page. For example:
            // const element = document.getElementById('paypal-button-container');
            // element.innerHTML = '<h3>Thank you for your payment!</h3>';
            // Or go to another URL:  actions.redirect('thank_you.html');
          });
        }
      }).render('#paypal-button-container');
    </script> -->
  <!-- jquery plugins here-->
  <!-- jquery -->
  <script src="js/jquery-1.12.1.min.js"></script>
  <!-- popper js -->
  <script src="js/popper.min.js"></script>
  <!-- bootstrap js -->
  <script src="js/bootstrap.min.js"></script>
  <!-- easing js -->
  <script src="js/jquery.magnific-popup.js"></script>
  <!-- swiper js -->
  <script src="js/swiper.min.js"></script>
  <!-- swiper js -->
  <script src="js/masonry.pkgd.js"></script>
  <!-- particles js -->
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.nice-select.min.js"></script>
  <!-- slick js -->
  <script src="js/slick.min.js"></script>
  <script src="js/jquery.counterup.min.js"></script>
  <script src="js/waypoints.min.js"></script>
  <script src="js/contact.js"></script>
  <script src="js/jquery.ajaxchimp.min.js"></script>
  <script src="js/jquery.form.js"></script>
  <script src="js/jquery.validate.min.js"></script>
  <script src="js/mail-script.js"></script>
  <script src="js/stellar.js"></script>
  <script src="js/price_rangs.js"></script>
  <!-- custom js -->
  <script src="js/custom.js"></script>
</body>
</html>