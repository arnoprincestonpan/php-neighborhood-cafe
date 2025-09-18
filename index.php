<?php
/*
TITLE: Main Page - One Page Web Application
FILE: index.php
PURPOSE: To display the correct page based on URL. And function based on page. 
*/
$shops_data = require 'dummy_data.php';

$RATING_MIN = 0;
$RATING_MAX = 5;
$rating_selected = isset($_GET['rating']) ? $_GET['rating'] : $RATING_MAX;
$uri = strtok($_SERVER['REQUEST_URI'], '?');

$filtered_shops = array_filter($shops_data, fn($shop) =>
    ($RATING_MIN <= $shop['rating'] && $shop['rating'] <= $rating_selected)
);

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_shop'){
    $shop_to_delete_id = $_POST['shop_id'];

    $shops_data = array_filter($shops_data, fn($shop) =>
        $shop['id'] != $shop_to_delete_id
    );

    $new_shops_data = "<?php" . PHP_EOL;
    $new_shops_data .= "return " . var_export($shops_data, true) . ';';
    $new_shops_data .= PHP_EOL . "?>";

    $new_shops_data = array_values($shops_data);

    file_put_contents('dummy_data.php', $new_shops_data);

    header("Location: /admin");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php
        if($uri === '/'){
            print "Neighbourhood Cafe";
        } elseif(strpos($uri, '/admin') !== false){
            print 'Admin - Neighbourhood Cafe';
        } else {
            http_response_code(404);
            print "404 Not Found";
        }
        ?>
    </title>
</head>
<body>
    <!-- Home Page "/" -->
    <?php if($uri === '/'): ?>
        <header>
            <h2>Neighbourhood Cafe</h2>
            <p>Check out the neighbourhood's cafes. Estimated at <?=count($shops_data)?> cafe(s). </p>
        </header>
        <?php if($shops_data):?>
            <section>
                <p>Filter Section</p>
                <form action="/" type="GET">
                    <label for="rating">
                        Rating
                    </label>
                    <p><span><?=$RATING_MIN?></span> / <span id="rating_selected_display"></span></p>
                    <input id="rating" name="rating" type="range" min="<?=$RATING_MIN?>" max="<?=$RATING_MAX?>" value="<?=$rating_selected?>" step="0.01" oninput="updateRatingSelectedDisplay()"/>
                    <button type="submit">Filter</button>                
                </form>
            </section>
            <section>
                <?php if($filtered_shops):?>
                    <?php foreach($filtered_shops as $shop):?>
                        <article>
                            <h3><?=$shop['name']?></h3>
                            <p><?=$shop['neighbourhood']?></p>
                            <p><?=str_replace(',', '<br/>', $shop['address'])?></p>
                        </article>
                    <?php endforeach;?>
                <?php else:?>
                    <p>Cannot find any shops under the filtered categories.</p>
                <?php endif;?>
            </section>
        <?php else:?>
            <section>
                <p>There are no listings available. Please check server.</p>
            </section>
        <?php endif;?>
    <!-- Admin Page -->
    <?php elseif(str_starts_with($uri, '/admin')):?>
        <!-- Admin Base -->
        <?php if($uri === '/admin' || $uri === '/admin/'):?>
            <h2>Admin Portal</h2>
            <a href="/admin/add_shop" alt="Add New Shop Link">Add New Shop +</a>
            <?php if(!$shops_data):?>
                <p>There are no shops entered. Please enter some data.</p>
            <?php else:?>
                <table>
                    <thead>
                        <tr>
                            <td>Name</td>
                            <td>Address</td>
                            <td>Rating</td>
                            <td>Neighbourhood</td>
                            <td>Actions</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($shops_data as $shop):?>
                            <tr>
                                <td><?=$shop['name']?></td>
                                <td><?=$shop['address']?></td>
                                <td><?=$shop['rating']?></td>
                                <td><?=$shop['neighbourhood']?></td>
                                <td>
                                    <form action="/admin" method="POST">
                                        <input type="hidden" name="action" value="delete_shop"/>
                                        <input type="hidden" name="shop_id" value="<?=htmlspecialchars($shop['id'])?>"/>
                                        <button type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            <?php endif;?>
        <?php elseif($uri === '/admin/add_shop' || $uri === '/admin/add_shop/'):?>
        <!-- Add New Shop -->
            <h2>Add New Shop</h2>
            <a href="/admin" alt="Back to Admin Portal Link">Cancel</a>
        <?php elseif($uri === '/admin/edit_shop' || $uri === '/admin/edit_shop/'):?>
        <!-- Edit Shop -->
            <h2>Edit Shop</h2>
            <a href="/admin" alt="Back to Admin Portal Link">Cancel</a>
        <?php endif;?>
    <!-- 404 Not Found -->
    <?php else:?>
        <h1>404: Page Not Found</h1>
    <?php endif;?>
    <footer>
        <center>
            <h5>Copyright(R) Arno Pan</h5>
        </center>
    </footer>
    <script>
        const ratingInput = document.getElementById('rating');
        const ratingSelectedDisplay = document.getElementById('rating_selected_display');

        ratingSelectedDisplay.textContent = parseFloat(ratingInput.max).toFixed(2);

        const updateRatingSelectedDisplay = () => {
            ratingSelectedDisplay.textContent = parseFloat(ratingInput.value).toFixed(2);
        };
    </script>
</body>
</html>