<?php
include('layouts/header.php');
include('server/connection.php');

// Determine the current page number
$page_no = isset($_GET['page_no']) && $_GET['page_no'] != "" ? $_GET['page_no'] : 1;

// Define the number of products per page
$total_records_per_page = 8;
$offset = ($page_no - 1) * $total_records_per_page;

// Default query to fetch all products
$query = "SELECT * FROM products LIMIT $offset, $total_records_per_page";
$count_query = "SELECT COUNT(*) As total_records FROM products";

// Check if the search form was submitted
if (isset($_POST['search'])) {
    $category = isset($_POST['category']) ? $_POST['category'] : "";

    if ($category != "") {
        // If category is selected, filter products by category
        $query = "SELECT * FROM products WHERE product_category=? LIMIT $offset, $total_records_per_page";
        $count_query = "SELECT COUNT(*) As total_records FROM products WHERE product_category=?";
    }
}

// Prepare and execute the count query
$stmt1 = $conn->prepare($count_query);
if (isset($_POST['search']) && $category != "") {
    $stmt1->bind_param('s', $category);
}
$stmt1->execute();
$stmt1->bind_result($total_records);
$stmt1->store_result();
$stmt1->fetch();

// Calculate pagination values
$total_no_of_pages = ceil($total_records / $total_records_per_page);
$previous_page = $page_no - 1;
$next_page = $page_no + 1;

// Prepare and execute the product query
$stmt2 = $conn->prepare($query);
if (isset($_POST['search']) && $category != "") {
    $stmt2->bind_param('s', $category);
}
$stmt2->execute();
$products = $stmt2->get_result();
?>

<div class="search-and-featured-container">
    <!-- Search Section -->
    <section id="search" class="my-5 py-5 ms-2 col-lg-4">
        <div class="container mt-5 py-5">
            <h3>Search Products</h3>
            <hr>
        </div>
        <form action="shop.php" method="POST">
            <div class="row mx-auto container">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <p>Category</p>
                    <div class="form-check">
                        <input class="form-check-input" value="embroidery" type="radio" name="category" id="category_one" <?= isset($category) && $category == 'embroidery' ? 'checked' : '' ?>>
                        <label class="form-check-label" for="category_one">Embroidery</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" value="handpaint" type="radio" name="category" id="category_two" <?= isset($category) && $category == 'handpaint' ? 'checked' : '' ?>>
                        <label class="form-check-label" for="category_two">Hand-Painted</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" value="wedding" type="radio" name="category" id="category_three" <?= isset($category) && $category == 'wedding' ? 'checked' : '' ?>>
                        <label class="form-check-label" for="category_three">Wedding</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" value="dye" type="radio" name="category" id="category_four" <?= isset($category) && $category == 'dye' ? 'checked' : '' ?>>
                        <label class="form-check-label" for="category_four">DYE</label>
                    </div>
                </div>
            </div>
            <div class="form-group my-3 mx-3">
                <input type="submit" name="search" value="Search" class="btn btn-primary">
            </div>
        </form>
    </section>

    <!-- Shop Section -->
    <section id="shop" class="my-5 py-5">
        <div class="container mt-5 py-5">
            <h3>Our Featured Products</h3>
        </div>
        <div class="row mx-auto container-fluid">
            <?php while ($row = $products->fetch_assoc()) { ?>
                <div class="product text-center col-lg-3 col-md-4 col-sm-12">
                    <img class="img-fluid mb-5" src="assets/imgs/<?= $row['product_image'] ?>" />
                    <div class="star">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <h5 class="p-name"><?= $row['product_name'] ?></h5>
                    <h4 class="p-price">$<?= $row['product_price'] ?></h4>
                    <a class="btn buy-btn" href="single_prdt.php?product_id=<?= $row['product_id'] ?>">Buy Now</a>
                </div>
            <?php } ?>
        </div>

        


