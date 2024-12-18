<?php
include 'init.php';
if (isset($_GET['q'])) {
  $searchQuery = strtolower($_GET['q']);
  $searchResults = $con->prepare("SELECT `id`, `name_product`, `price_product`, `img_product` FROM `products` WHERE LOWER(`name_product`) LIKE :search");
  $searchResults->bindValue(':search', '%' . $searchQuery . '%');
  $searchResults->execute();
  $products = $searchResults->fetchAll(PDO::FETCH_ASSOC);
?>
  <div class="search text-md-center">
    <div class="container">
      <?php if (count($products) > 0) : ?>
        <?php foreach ($products as $product) : ?>
          <div class="product-item my-2">
            <a class="h5 text-decoration-none d-flex align-items-center" href="./product.php?id=<?php echo $product['id']; ?>">
              <img src="<?php echo $dirs . $product['img_product']; ?>" alt="<?php echo $product['name_product']; ?>" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover; margin-right: 10px;" />
              <?php echo $product['name_product'] . ' ' . "₹ " . number_format($product['price_product'], 0); ?>
            </a>
          </div>
        <?php endforeach; ?>
      <?php else : ?>
        <div class="alert alert-warning text-center mt-5" role="alert">
          The item you searched for is not available. Please <a href="contact.php">contact us</a> for further assistance.
        </div>
      <?php endif; ?>
    </div>
  </div>
<?php
} else {
  header('Location:./index.php');
}
include $tpl . 'footer.php'; ?>
