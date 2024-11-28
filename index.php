<?php
session_start();
$pageTitle = 'MA Creations';
include './init.php';
$stmt = $con->prepare("SELECT `id`, `name_product`, `description_product`, `price_product`, `currency`, `img_product`, `stock_product`, `created_at` FROM `products` ORDER BY `products`.`created_at` DESC");
$stmt->execute();
$ListProducts = $stmt->fetchAll();
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $pageTitle; ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <!-- Slider Section -->
  <div class="slider my-3">
  <style>
    .carousel-inner img {
      height: 400px; 
      width: 400px;
    }
  </style>
    <div id="productCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
      <div class="carousel-inner">
        <!-- Slider Images -->
        <?php
        $sliderImages = [
          'images/slider1.jpg',
          'images/slider2.webp',
          'images/slider3.webp',
          'images/slider4.webp',
          'images/slider5.webp',
          'images/slider6.jpg'
        ];
        foreach ($sliderImages as $index => $image) : ?>
          <div class="carousel-item <?php echo $index === 0 ? 'active' : '' ?>">
            <img src="<?php echo $image; ?>" class="d-block w-100" alt="Slide <?php echo $index + 1; ?>">
          </div>
        <?php endforeach; ?>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>



 
  
<div class="product-list my-3">
  <div class="container">
    <h1><?php echo "Our Collection" ?></h1>
    <div class="row g-3">
      <?php foreach ($ListProducts as $product) : ?>
        <div class="col-md-3">
          <div class="card">
            <img class="card-img-top" src="<?php echo $dirs . $product['img_product'] ?>" alt="<?php echo $product['name_product'] ?>">
            <div class="card-body">
              <a href="product.php?id=<?php echo $product['id'] ?>">
                <h2 class="card-title"><?php echo $product['name_product'] ?></h2>
              </a>
              <p class="card-text"><?php echo "₹ ".number_format($product['price_product'], 0) ?></p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
<?php include $tpl . 'footer.php';
