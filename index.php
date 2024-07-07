<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Listing</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Product Listing</h1>
        <form method="GET" action="" class="filter-form">
            <div class="form-group">
                <label for="price_min">Min Price:</label>
                <input type="number" name="price_min" id="price_min">
            </div>
            <div class="form-group">
                <label for="price_max">Max Price:</label>
                <input type="number" name="price_max" id="price_max">
            </div>
            <div class="form-group">
                <label for="category">Category:</label>
                <input type="text" name="category" id="category">
            </div>
            <div class="form-group">
                <label for="sale_status">Sale Status:</label>
                <select name="sale_status" id="sale_status">
                    <option value="">All</option>
                    <option value="on_sale">On Sale</option>
                    <option value="not_on_sale">Not on Sale</option>
                </select>
            </div>
            <button type="submit">Filter</button>
        </form>

        <div id="product-list" class="product-list">
            <?php include 'fetch_products.php'; ?>
        </div>

        <div id="pagination" class="pagination">
            <?php include 'pagination.php'; ?>
        </div>
    </div>
</body>
</html>
