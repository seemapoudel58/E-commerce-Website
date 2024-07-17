<?php
session_start();
@include 'config.php';

if(isset($_POST['add_to_wishlist'])){
   $product_Name=$_POST['product_name'];
   $product_Price=$_POST['product_price'];
   $product_Image=$_POST['product_image'];
   $product_Quantity=1;
   
   $select_wishlist= mysqli_query($conn,"SELECT * from wishlist WHERE name = '$product_Name'");
   if(mysqli_num_rows($select_wishlist) > 0){
      $_SESSION['message'] = "Product already added to wishlist";
   }
   else{
      $insert_products = mysqli_query($conn,"INSERT into wishlist(name,price, image, quantity) VALUES ('$product_Name','$product_Price','$product_Image','$product_Quantity')");
      if($insert_products){
         $_SESSION['message'] = "Product added to wishlist";
      } else {
         $_SESSION['message'] = "Error adding product to wishlist";
      }
   }
   header('location: ' . $_SERVER['PHP_SELF']);
   exit();
}

if(isset($_POST['add_to_cart'])){
   $product_Name=$_POST['product_name'];
   $product_Price=$_POST['product_price'];
   $product_Image=$_POST['product_image'];
   $product_Quantity=1;
   
   $select_cart = mysqli_query($conn,"SELECT * from cart WHERE name = '$product_Name'");
   if(mysqli_num_rows($select_cart) > 0){
      $_SESSION['message'] = "Product already added to cart";
   }
   else{
      $insert_products = mysqli_query($conn,"INSERT into cart(name,price, image, quantity) VALUES ('$product_Name','$product_Price','$product_Image','$product_Quantity')");
      if($insert_products){
         $_SESSION['message'] = "Product added to cart";
      } else {
         $_SESSION['message'] = "Error adding product to cart";
      }
   }
   header('location: ' . $_SERVER['PHP_SELF']);
   exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Products</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="style.css">
   <style>
      .box {
         position: relative;
         overflow: hidden;
      }
      .box .image-container {
         position: relative;
         width: 100%;
         padding-top: 100%; /* Creates a square aspect ratio */
      }
      .box img {
         position: absolute;
         top: 0;
         left: 0;
         width: 100%;
         height: 100%;
         object-fit: cover;
         object-position: center;
      }
   </style>
</head>
<body>
<div style="text-align: right; margin: 20px;">
   <a href="http://localhost/project/wishlist.php" style="display: inline-block; padding: 10px 20px; margin: 10px; background-color: #f8b400; color: white; text-decoration: none; border-radius: 5px; font-size: 16px;">Wishlist</a>
   <a href="http://localhost/project/cart.php" style="display: inline-block; padding: 10px 20px; margin: 10px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; font-size: 16px;">Cart</a>
</div>

<div class="container">
   <section class="products">
      <h1 class="heading">Glass Skin</h1>
      <div class="box-container">
         <?php
            // Static product data
            $products = [
               ['name' => 'Perfume', 'price' => 1500, 'image' => 'perfume.jpg'],
               ['name' => 'Shampoo', 'price' => 2250, 'image' => 'shampoo.jpg'],
               ['name' => 'Sunscreen', 'price' => 2350, 'image' => 'sunscreen.jpg'],
               ['name' => 'Toner', 'price' => 1450, 'image' => 'toner.jpg'],
               ['name' => 'Moisturizer', 'price' => 2550, 'image' => 'moisturizer.jpg'],
               ['name' => 'Cleanser', 'price' => 1550, 'image' => 'cleanser.jpg']

            ];

            foreach($products as $product) {
         ?>
         <form action="" method="post">
            <div class="box">
               <div class="image-container">
                  <img src="images/<?php echo $product['image']; ?>" alt="">
               </div>
               <h3><?php echo $product['name']; ?></h3>
               <div class="price">Rs.<?php echo number_format($product['price']); ?>/-</div>
               <input type="hidden" name="product_name" value="<?php echo $product['name']; ?>">
               <input type="hidden" name="product_price" value="<?php echo $product['price']; ?>">
               <input type="hidden" name="product_image" value="<?php echo $product['image']; ?>">
               <input type="submit" class="btn" value="Add to Cart" name="add_to_cart">
               <input type="submit" class="btn" value="Add to Wishlist" name="add_to_wishlist" style="background-color: #f8b400;">
            </div>
         </form>
         <?php
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
   }, 2000);
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