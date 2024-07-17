<?php 
session_start();
@include 'config.php';

if (isset($_POST['add_to_cart'])) {
   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = 1;

   $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name'");
   if (mysqli_num_rows($select_cart) > 0) {
      $_SESSION['message'] = 'Product already added to cart';
   } else {
      $insert_product = mysqli_query($conn, "INSERT INTO `cart`(name, price, image, quantity) VALUES('$product_name', '$product_price', '$product_image', '$product_quantity')");
      if($insert_product) {
         $_SESSION['message'] = 'Product added to cart successfully';
      } else {
         $_SESSION['message'] = 'Could not add the product to cart';
      }
   }
   header('location: wishlist.php');
   exit();
}

if(isset($_GET['remove'])){
   $remove_id = $_GET['remove'];
   mysqli_query($conn, "DELETE FROM wishlist WHERE id='$remove_id'");
   $_SESSION['message'] = 'Item removed from wishlist';
   header('location: wishlist.php');
   exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Wishlist</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="style.css">
   <style>
      .box {
         position: relative;
         overflow: hidden;
      }
      .box img {
         width: 100%;
         height: 200px;
         object-fit: cover;
         object-position: center;
      }
   </style>
</head>
<body>
   <div class="container">
      <div style="text-align: right; margin: 20px;">
         <a href="http://localhost/project" style="display: inline-block; padding: 10px 20px; margin: 10px; background-color: green; color: white; text-decoration: none; border-radius: 5px; font-size: 16px;">Add product</a>
         <a href="http://localhost/project/cart.php" style="display: inline-block; padding: 10px 20px; margin: 10px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; font-size: 16px;">Cart</a>
      </div>
      <section class="products">
         <h1 class="heading">Wishlist</h1>
         <div class="box-container">
            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM wishlist");
            if (mysqli_num_rows($select_products) > 0) {
               while ($fetch_product = mysqli_fetch_assoc($select_products)) {
            ?>
               <form action="" method="post">
                  <div class="box">
                     <img src="images/<?php echo $fetch_product['image']; ?>" alt="<?php echo $fetch_product['name']; ?>">
                     <h3><?php echo $fetch_product['name']; ?></h3>
                     <div class="price">Rs.<?php echo number_format($fetch_product['price']); ?>/-</div>
                     <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                     <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                     <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                     <input type="submit" class="btn" value="Add to Cart" name="add_to_cart">
                     <a href="wishlist.php?remove=<?php echo $fetch_product['id']; ?>" onclick="return confirm('Remove item from wishlist?')" class="delete-btn"><i class="fas fa-trash"></i> Remove</a>
                  </div>
               </form>
            <?php
               }
            } else {
               echo "<p>Your wishlist is empty.</p>";
            }
            ?>
         </div>
      </section>
   </div>

   <script>
   function showNotification(message) {
      var notification = document.createElement('div');
      notification.textContent = message;
      notification.style.position = 'fixed';
      notification.style.top = '20px';
      notification.style.left = '50%';
      notification.style.transform = 'translateX(-50%)';
      notification.style.backgroundColor = '#4CAF50';
      notification.style.color = 'white';
      notification.style.padding = '20px';
      notification.style.borderRadius = '8px';
      notification.style.zIndex = '1000';
      notification.style.fontSize = '18px';
      notification.style.fontWeight = 'bold';
      notification.style.boxShadow = '0 4px 8px rgba(0,0,0,0.1)';
      document.body.appendChild(notification);

      setTimeout(function() {
         notification.style.display = 'none';
      }, 3000);
   }
   </script>

   <?php
   if(isset($_SESSION['message'])) {
      echo "<script>showNotification('" . $_SESSION['message'] . "');</script>";
      unset($_SESSION['message']);
   }
   ?>

</body>
</html>