<?php
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

$uri = $_SERVER['REQUEST_URI'];

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
            </section>
            <section>
                <?php foreach($shops_data as $shop):?>
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
    <?php endif;?>
</body>
</html>