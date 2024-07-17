<?php
@include 'config.php';
$order_completed = false;

if (isset($_POST['order_btn'])) {
    $name = $_POST['name'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $method = $_POST['method'];
    $house_no = $_POST['house_no'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $pin_code = $_POST['pin_code'];
    $total_products = ""; // Get total products from cart
    $total_price = ""; // Get total price from cart
    
    if ($method == "cash on delivery") {
        $order_completed = true;
    }

    $insert_order = mysqli_query($conn, "INSERT INTO `order` (name, number, email, method, house_no, street, city, state, country, pin_code, total_products, total_price) VALUES ('$name', '$number', '$email', '$method', '$house_no', '$street', '$city', '$state', '$country', '$pin_code', '$total_products', '$total_price')");

    if ($insert_order) {
        $order_completed = true;
        // Redirect to index.php after a short delay
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'index.php';
                }, 3000);
              </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="style.css">
   <style>
        /* Style for the modal pop-up */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            text-align: center;
            position: relative;
        }
        .close {
            color: #aaa;
            position: absolute;
            top: 50%;
            right: 0;
            transform: translateY(-50%);
            font-size: 28px;
            font-weight: bold;
            padding: 0 20px;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .modal-content p {
            font-size: 24px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
<section class="checkout-form">
   <h1 class="heading">complete your order</h1>
   <form action="" method="post">
   <div class="display-order">
      <?php
      $select_cart = mysqli_query($conn,"SELECT * from cart");
      $grand_total = 0;
      if(mysqli_num_rows($select_cart) > 0) {
         while($fetch_cart = mysqli_fetch_assoc($select_cart)) {
            $sub_total = $fetch_cart['price'] * $fetch_cart['quantity'];
            $grand_total += $sub_total;
         }
      }
    ?>
   
      <span class="grand-total"> grand total : $<?= $grand_total; ?>/- </span>
   </div>
      <div class="flex">
         <div class="inputBox">
            <span>your name</span>
            <input type="text" placeholder="Name" name="name" required>
         </div>
         <div class="inputBox">
            <span>your number</span>
            <input type="number" placeholder="Phone Number" name="number" required>
         </div>
         <div class="inputBox">
            <span>your email</span>
            <input type="email" placeholder="Email" name="email" required>
         </div>
         <div class="inputBox">
            <span>payment method</span>
            <select name="method">
               <option value="cash on delivery" selected>cash on devlivery</option>
            </select>
         </div>
         <div class="inputBox">
            <span>House Number</span>
            <input type="text" placeholder="" name="house_no" required>
         </div>
         <div class="inputBox">
            <span>City</span>
            <input type="text" placeholder="" name="city" required>
         </div>
         <div class="inputBox">
            <span>Street</span>
            <input type="text" placeholder="" name="street" required>
         </div> <div class="inputBox">
            <span>State</span>
            <input type="text" placeholder="" name="state" required>
         </div>
         <div class="inputBox">
            <span>country</span>
            <input type="text" placeholder="" name="country" required>
         </div>
         <div class="inputBox">
            <span>pin code</span>
            <input type="text" placeholder="" name="pin_code" required>
         </div>
      </div>
      <input type="submit" value="order now" name="order_btn" class="btn">
   </form>
</section>
</div>
<!-- The Modal -->
<div id="orderModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <p>Order completed</p>
    </div>
</div>

<!-- custom js file link  -->
<script src="js/script.js"></script> 
<script>
    // Get the modal
    var modal = document.getElementById("orderModal");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // Show the modal if order is completed
    <?php if ($order_completed): ?>
    modal.style.display = "block";
    // Redirect to index.php after 3 seconds
    setTimeout(function() {
        window.location.href = 'index.php';
    }, 3000);
    <?php endif; ?>
</script>
</body>
</html>