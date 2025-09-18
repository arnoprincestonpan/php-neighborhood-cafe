<?php
/*
TITLE: Main Page - One Page Web Application
FILE: index.php
PURPOSE: To display the correct page based on URL. And function based on page. 
*/
$shops_data = [
    [
        'id' => 1,
        'name' => 'The Daily Grind',
        'address' => '123 Coffee St., SomeCity State POSTAL',
        'rating' => 4.5,
        'hours_open' => '8 AM - 6 PM',
        'food_availability' => 'Baked goods, sandwiches, salads',
        'image_link' => 'uploads/images/the-daily-grind.jpg',
        'neighbourhood' => 'Downtown'
    ],
    [
        'id' => 2,
        'name' => 'Books & Brews',
        'address' => '45 Reading Blvd., SomeCity State POSTAL',
        'rating' => 4.8,
        'hours_open' => '9 AM - 9 PM',
        'food_availability' => 'Coffee, tea, and light snacks',
        'image_link' => 'uploads/images/books-and-brews.jpg',
        'neighbourhood' => 'Arts District'
    ],
    [
        'id' => 3,
        'name' => 'Urban Eatery',
        'address' => '789 Main Ave., SomeCity State POSTAL',
        'rating' => 4.2,
        'hours_open' => '11 AM - 10 PM',
        'food_availability' => 'Burgers, fries, shakes',
        'image_link' => 'uploads/images/urban-eatery.jpg',
        'neighbourhood' => 'Midtown'
    ],
    [
        'id' => 4,
        'name' => 'Garden Grill',
        'address' => '10 Farm Rd., SomeCity State POSTAL',
        'rating' => 3.9,
        'hours_open' => '12 PM - 8 PM',
        'food_availability' => 'Vegan and vegetarian options',
        'image_link' => 'uploads/images/garden-grill.jpg',
        'neighbourhood' => 'The Meadows'
    ],
    [
        'id' => 5,
        'name' => 'Sweet Surrender',
        'address' => '321 Dessert St., SomeCity State POSTAL',
        'rating' => 5.0,
        'hours_open' => '10 AM - 7 PM',
        'food_availability' => 'Cupcakes, macarons, pastries',
        'image_link' => 'uploads/images/sweet-surrender.jpg',
        'neighbourhood' => 'Old Town'
    ]
];

$RATING_MIN = 0;
$RATING_MAX = 5;
$rating_selected = isset($_GET['rating']) ? $_GET['rating'] : $RATING_MAX;
$uri = strtok($_SERVER['REQUEST_URI'], '?');

$filtered_shops = array_filter($shops_data, fn($shop) =>
    ($RATING_MIN <= $shop['rating'] && $shop['rating'] <= $rating_selected)
);

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
                <?php foreach($filtered_shops as $shop):?>
                    <article>
                        <h3><?=$shop['name']?></h3>
                        <p><?=$shop['neighbourhood']?></p>
                        <p><?=str_replace(',', '<br/>', $shop['address'])?></p>
                    </article>
                <?php endforeach;?>
            </section>
        <?php else:?>
            <section>
                <p>There are no listings available. Please check server.</p>
            </section>
        <?php endif;?>
    <!-- Admin Page -->
    <?php elseif($uri === '/admin'):?>
        <h2>Admin Portal</h2>
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