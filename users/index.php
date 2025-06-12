<?php
    //include auth_session.php file on all user panel pages
    include("auth_session.php");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <title>Nai Tsa</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD2Hhh_14Uam62GXGaTMcXWhhVkYg0EbDY&callback=initMap" async defer></script>

        <!-- Custom CSS File Link -->
        <link rel="stylesheet" href="../assets/css/style.css">
        <link rel="stylesheet" href="../assets/css/convo.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"><!-- font awesome cdn link -->
        <link rel="icon" type="image/x-icon" href="../assets/images/favicon.ico"><!-- Favicon / Icon -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"><!-- Google font cdn link -->
    </head>
    <body>
        <!-- HEADER SECTION -->
        <header class="header">
            <a href="#" class="logo">
                <img src="../assets/images/logo.png" class="img-logo" alt="Nai Tsa Logo">
            </a>

            <!-- MAIN MENU FOR SMALLER DEVICES -->
            <nav class="navbar navbar-expand-lg">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a href="#home" class="text-decoration-none">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="#about" class="text-decoration-none">About</a>
                        </li>
                        <li class="nav-item">
                            <a href="#menu" class="text-decoration-none">Menu</a>
                        </li>
                        <li class="nav-item">
                            <a href="#gallery"class="text-decoration-none">Gallery</a>
                        </li>
                        <li class="nav-item">
                            <a href="#blogs" class="text-decoration-none">Blogs</a>
                        </li>
                        <li class="nav-item">
                            <a href="#contact" class="text-decoration-none">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a href="logout.php" class="text-decoration-none">Logout</a>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="icons">
                <div class="fas fa-search" id="search-btn"></div>
                <div class="fas fa-shopping-cart position-relative" id="cart-btn">
                    <span id="cart-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="display:none; font-size:0.8rem;">0</span>
                </div>
                <div class="fas fa-user" id="profile-btn"></div>
                <div class="fas fa-bars" id="menu-btn"></div>
            </div>

            <!-- SEARCH TEXT BOX -->
            <div class="search-form">
                <input type="search" id="search-box" class="form-control" placeholder="search here...">
                <label for="search-box" class="fas fa-search"></label>
            </div>

            <!-- CART SECTION -->
            <div class="cart">
                <h2 class="cart-title">Your Cart:</h2>
                <div class="cart-content">
                    
                </div>
                <div class="total">
                    <div class="total-title">Total: </div>
                    <div class="total-price">₱0</div>
                </div>
                <div class="mb-3">
    <label class="fw-bold mb-2">Payment Method:</label><br>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="pay_method" id="cod" value="Cash on Delivery" checked>
        <label class="form-check-label" for="cod">Cash on Delivery</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="pay_method" id="gcash" value="GCash">
        <label class="form-check-label" for="gcash">GCash</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="pay_method" id="cc" value="Credit Card">
        <label class="form-check-label" for="cc">Credit Card</label>
    </div>
</div>
                <!-- BUY BUTTON -->
                <button type="button" class="btn-buy">Checkout Now</button>
            </div>
        </header>

        <!-- HERO SECTION -->
        <section class="home" id="home">
            <div class="content">
                <h3>Welcome to Nai Tsa Bubble Tea & Food Hub, <?php echo $_SESSION['username']; ?>!</h3>
                <p>
                    <strong>We are open 4:00 PM to 9:00 PM.</strong>
                </p>
                <a href="#menu" class="btn btn-dark text-decoration-none">Order Now!</a>
            </div>
        </section>

        <!-- ABOUT US SECTION -->
        <section class="about" id="about">
            <h1 class="heading"> <span>About</span> Us</h1>
            <div class="row g-0">
                <div class="image">
                    <img src="../assets/images/about-img.png" alt="" class="img-fluid">
                </div>
                <div class="content">
                    <h3>Welcome to Nai Tsa!</h3>
                    <p>
                        At Nai Tsa, we’re passionate about blending fun, flavor, and creativity into every sip and bite. Located in the heart of the city, we’re a vibrant hub dedicated to serving delicious bubble tea, refreshing drinks, and mouthwatering food that brings people together. Our journey began with a love for bold flavors and innovative recipes, inspiring us to craft unique drinks with the freshest ingredients, chewy boba pearls, and endless customization.
                    </p>
                    <p>
                        But Nai Tsa is more than just a drink or a meal, it’s an experience. Our lively and welcoming space is designed to be a go-to spot for friends, families, and bubble tea enthusiasts to unwind, share laughs, and explore a world of flavors. Whether you’re craving a classic milk tea, a fruity explosion, or a savory snack, every visit is a chance to taste happiness in every bubble!
                    </p>
                    <a href="#" class="btn btn-dark text-decoration-none">Learn More</a>
                </div>
            </div>
        </section>

        <!-- MENU SECTION -->
        <section class="menu" id="menu">
            <h1 class="heading">Our <span>Menu</span></h1>
            <div class="box-container">
                <div class="container">
                    <div class="row" id="product-list"></div>
                </div>
            </div>
        </section>

        <!-- GALLERY SECTION -->
        <section class="gallery" id="gallery">
            <h1 class="heading">The <span>Gallery</span></h1>
            <div class="box-container">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="box">
                                <div class="image">
                                    <img src="../assets/images/gallery1.jpg" alt="">
                                </div>
                                <div class="content">
                                    <div class="stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                    <h3 class="gallery-title">Picture 1</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="box">
                                <div class="image">
                                    <img src="../assets/images/gallery2.jpg" alt="">
                                </div>
                                <div class="content">
                                    <div class="stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                    <h3 class="gallery-title">Picture 2</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="box">
                                <div class="image">
                                    <img src="../assets/images/gallery3.jpg" alt="">
                                </div>
                                <div class="content">
                                    <div class="stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                    <h3 class="gallery-title">Picture 3</h3>
                                </div>
                            </div>
                        </div>
                    </div><br />
                    <div class="row pic-to-hide">
                        <div class="col-md-4">
                            <div class="box">
                                <div class="image">
                                    <img src="../assets/images/gallery4.jpg" alt="">
                                </div>
                                <div class="content">
                                    <div class="stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                    <h3 class="gallery-title">Picture 4</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="box">
                                <div class="image">
                                    <img src="../assets/images/gallery4.jpg" alt="">
                                </div>
                                <div class="content">
                                    <div class="stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                    <h3 class="gallery-title">Picture 4</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="box">
                                <div class="image">
                                    <img src="../assets/images/gallery5.jpg" alt="">
                                </div>
                                <div class="content">
                                    <div class="stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                    <h3 class="gallery-title">Picture 5</h3>
                                </div>
                            </div>
                        </div>
                    </div><br />
                    <center>
                        <button id="showBtn" class="btn btn-dark">SHOW MORE</button>
                    </center> 
                </div> 
            </div>
        </section>

        <!-- BLOGS SECTION -->
        <section class="blogs" id="blogs">
            <h1 class="heading">Our <span>Blogs</span></h1>
            <div class="box-container">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="box">
                                <div class="image">
                                    <img src="../assets/images/pour.jpg" alt="">
                                </div>
                                <div class="content">
                                    <a href="https://www.thewaytocoffee.com/batch-brew-vs-pour-over/" target="_blank" class="title text-decoration-none">Batch Brew vs. Pour Over | The Pros and Cons Experienced by Coffee Professionals</a>
                                    <span>by The Way to Coffee</span>
                                    <p>Thinking back 15-20 years, I remember my parents going about their morning ritual of brewing coffee on weekends before burying...</p>
                                    <center>
                                        <a href="https://www.thewaytocoffee.com/batch-brew-vs-pour-over/" target="_blank" class="btn">Read More</a>
                                    </center>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="box">
                                <div class="image">
                                    <img src="../assets/images/carbon.webp" alt="">
                                </div>
                                <div class="content">
                                    <a href="https://www.taylorsofharrogate.co.uk/news/carbon-neutral-tea-and-coffee" target="_blank" class="title text-decoration-none">Carbon Neutral Tea and Coffee</a>
                                    <span>by Taylors editorial team</span>
                                    <p>All our tea and coffee is carbon neutral – but what does that actually mean? Here’s an explanation of how we’ve lowered our carbon footprint, and the three projects in Kenya, Malawi and Uganda which have reduced the emissions of our products to...</p>
                                    <center>
                                        <a href="https://www.taylorsofharrogate.co.uk/news/carbon-neutral-tea-and-coffee" target="_blank" class="btn">Read More</a>
                                    </center>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="box">
                                <div class="image">
                                    <img src="../assets/images/coffeemaker.jpg" alt="">
                                </div>
                                <div class="content">
                                    <a href="https://coffeestylish.com/best-drip-coffee-makers/" target="_blank" class="title text-decoration-none">BEST DRIP COFFEE MAKERS 2020</a>
                                    <span>by CoffeeStylish.com</span>
                                    <p>What is a good coffee maker? A good home coffee maker should have removable parts so it can be cleaned completely because you don’t want mold or buildups in your machine. It should be fast. It...</p>
                                    <center>
                                        <a href="https://coffeestylish.com/best-drip-coffee-makers/" target="_blank" class="btn">Read More</a>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </section>

        <!-- TESTIMONIALS SECTION -->
        <section class="review" id="review">
            <h1 class="heading"><span>Testimo</span>nials</h1>
            <div class="box-container">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="box">
                                <img src="../assets/images/quote-img.png" alt="" class="quote">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, 
                                    sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                </p>
                                <img src="../assets/images/pic-1.png" alt="" class="user">
                                <h3>Jane Doe</h3>
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="box">
                                <img src="../assets/images/quote-img.png" alt="" class="quote">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, 
                                    sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                </p>
                                <img src="../assets/images/pic-2.png" alt="" class="user">
                                <h3>John Doe</h3>
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="box">
                                <img src="../assets/images/quote-img.png" alt="" class="quote">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, 
                                    sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                </p>
                                <img src="../assets/images/pic-3.png" alt="" class="user">
                                <h3>Jane Doe</h3>
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
        </section>

        <!-- CONTACT US SECTION -->
        <section class="contact" id="contact">
            <h1 class="heading"><span>Contact</span> Us</h1>
            <div class="row">
                <div id="map" class="map pull-left"></div>
                <form name="contact" method="POST" action="https://formspree.io/f/xayzavgb">
                    <h3> Get in touch with us!</h3>
                    <div class="inputBox">
                        <span class="fas fa-envelope"></span>
                        <input type="email" name="email" placeholder="Email Address">
                    </div>
                    <div class="inputBox">
                        <textarea name="message" placeholder="Enter your message..."></textarea>
                    </div>
                    <button type="submit" class="btn">Contact Now</button>
                </form>
            </div>
        </section>

        <!-- FOOTER SECTION -->
        <section class="footer">
            <div class="footer-container">
                <div class="logo">
                    <img src="../assets/images/logo.png" class="img"><br />
                    <i class="fas fa-envelope"></i>
                    <p>abfiguerrez18@gmail.com</p><br />
                    <i class="fas fa-phone"></i>
                    <p>+63 917-134-1422</p><br />
                    <i class="fab fa-facebook-messenger"></i>
                    <p>@kapetanncoffee</p><br />
                </div>
                <div class="support">
                    <h2>Support</h2>
                    <br /> 
                    <a href="#">Contact Us</a>
                    <a href="#">Customer Service</a>
                    <a href="#">Chatbot Inquiry</a>
                    <a href="#">Submit a Ticket</a>
                </div>
                <div class="company">
                    <h2>Company</h2>
                    <br /> 
                    <a href="#">About Us</a>
                    <a href="#">Affiliates</a>
                    <a href="#">Resources</a>
                    <a href="#">Partnership</a>
                    <a href="#">Suppliers</a>
                </div>
                <div class="newsletters">
                    <h2>Newsletters</h2>
                    <br /> 
                    <p>Subscribe to our newsletter for news and updates!</p>
                    <div class="input-wrapper">
                        <input type="email" class="newsletter" placeholder="Your email address">
                        <i id="paper-plane-icon" class="fas fa-paper-plane"></i>
                    </div>
                </div>
                <div class="credit">
                    <hr /><br/>
                    <h2>KapeTann Brewed Coffee © 2023 | All Rights Reserved.</h2>
                    <h2>Designed by <span>Algo Filipino</span> | Teravision</h2>
                </div>
            </div>
        </section>

        <!-- CHAT BAR BLOCK -->
        <div class="chat-bar-collapsible">
            <button id="chat-button" type="button" class="collapsible">Chat with us! &nbsp;
                <i id="chat-icon" style="color: #fff;" class="fas fa-comments"></i>
            </button>
            <div class="content">
                <div class="full-chat-block">
                    <!-- Message Container -->
                    <div class="outer-container">
                        <div class="chat-container">
                            <!-- Messages -->
                            <div id="chatbox">
                                <h5 id="chat-timestamp"></h5>
                                <p id="botStarterMessage" class="botText"><span>Loading...</span></p>
                            </div>
                            <!-- User input box -->
                            <div class="chat-bar-input-block">
                                <div id="userInput">
                                    <input id="textInput" class="input-box" type="text" name="msg"
                                        placeholder="Tap 'Enter' to send a message">
                                    <p></p>
                                </div>
                                <div class="chat-bar-icons">
                                    <i id="chat-icon" style="color: #333;" class="fa fa-fw fa-paper-plane"
                                        onclick="sendButton()"></i>
                                </div>
                            </div>
                            <div id="chat-bar-bottom">
                                <p></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- JS File Link -->
        <script src="../assets/js/googleSignIn.js"></script>
        <script src="../assets/js/script.js"></script>
        <script src="../assets/js/responses.js"></script>
        <script src="../assets/js/convo.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
            let cart = []; // Place this at the top, outside of $(document).ready()

            $(document).ready(function() {
                // CODE FOR THE FORMSPREE
                window.onbeforeunload = () => {
                    for(const form of document.getElementsByTagName('form')) {
                        form.reset();
                    }
                }

                // CODE FOR THE GOOGLE MAPS API
                function initMap() {
                    var map = new google.maps.Map(document.getElementById('map'), {
                        center: {lat: 14.99367271992383, lng: 120.17629231186626},
                        zoom: 9
                    });

                    var marker = new google.maps.Marker({
                        position: {lat: 14.99367271992383, lng: 120.17629231186626},
                        map: map,
                        title: 'Your Location'
                    });
                }

                // CODE FOR THE SHOW MORE & SHOW LESS BUTTON IN MENU
                $(document).ready(function() {
                    $(".row-to-hide").hide();
                    $("#showHideBtn").text("SHOW MORE");
                    $("#showHideBtn").click(function() {
                        $(".row-to-hide").toggle();
                        if ($(".row-to-hide").is(":visible")) {
                            $(this).text("SHOW LESS");
                        } else {
                            $(this).text("SHOW MORE");
                        }
                    });
                });

                // CODE FOR THE SHOW MORE & SHOW LESS BUTTON IN GALLERY
                $(document).ready(function() {
                    $(".pic-to-hide").hide();
                    $("#showBtn").text("SHOW MORE");
                    $("#showBtn").click(function() {
                        $(".pic-to-hide").toggle();
                        if ($(".pic-to-hide").is(":visible")) {
                            $(this).text("SHOW LESS");
                        } else {
                            $(this).text("SHOW MORE");
                        }
                    });
                });

                function renderProducts(products) {
                    let html = '';
                    products.forEach(function(product, idx) {
                        let imagePath = '../admin_panel' + product.product_image.substring(1);
                        html += `
                            <div class="col-md-4">
                                <div class="box">
                                    <img src="${imagePath}" alt="" class="product-img">
                                    <h3 class="product-title">${product.Product_name}</h3>
                                    <div class="price">₱${product.Price}</div>
                                    <a class="btn add-cart" data-idx="${idx}">Add to Cart</a>
                                </div>
                            </div>
                        `;
                    });
                    $('#product-list').html(html);

                    // Attach click handler after rendering
                    $('.add-cart').click(function() {
                        const idx = $(this).data('idx');
                        addToCart(products[idx]);
                    });
                }

                function addToCart(product) {
                    // Check if already in cart
                    let found = cart.find(item => item.Product_ID === product.Product_ID);
                    if (found) {
                        found.qty += 1;
                    } else {
                        cart.push({...product, qty: 1});
                    }
                    renderCart();
                }

                function renderCart() {
                    let html = '';
                    let subtotal = 0;
                    cart.forEach(function(item, idx) {
                        let imagePath = item.product_image
                            ? ('../admin_panel' + item.product_image.substring(1))
                            : '../assets/images/cart-item-1.png';
                        let itemTotal = item.Price * item.qty;
                        subtotal += itemTotal;
                        html += `
        <div class="cart-item d-flex align-items-center mb-3 pb-2 border-bottom">
            <img src="${imagePath}" class="cart-img-thumb me-3" style="width:64px;height:64px;object-fit:cover;border-radius:8px;">
            <div class="flex-grow-1">
                <div class="cart-product-title fw-bold" style="font-size:1.1rem;">${item.Product_name}</div>
                <div class="text-muted" style="font-size:1rem;">₱${Number(item.Price).toFixed(2)}</div>
                <div class="d-flex align-items-center mt-2" style="max-width:120px;">
                    <button class="cart-minus" style="width:32px;height:32px;background:var(--main-color);color:#fff;border-radius:5px;border:none;font-size:1.5rem;display:flex;align-items:center;justify-content:center;" data-idx="${idx}">−</button>
                    <input type="text" class="cart-qty-input mx-1" value="${item.qty}" style="width:48px;height:32px;text-align:center;font-size:1.2rem;border:1px solid var(--main-color);border-radius:5px;" data-idx="${idx}" readonly>
                    <button class="cart-plus" style="width:32px;height:32px;background:var(--main-color);color:#fff;border-radius:5px;border:none;font-size:1.5rem;display:flex;align-items:center;justify-content:center;" data-idx="${idx}">+</button>
                </div>
            </div>
            <button class="cart-remove" data-idx="${idx}" title="Remove" style="background:none;border:none;padding:0;margin-left:10px;display:flex;align-items:center;justify-content:center;color:var(--main-color);font-size:2rem;">
                <i class="fa fa-trash"></i>
            </button>
        </div>
    `;
                    });
                    html += `
        <hr>
        <div class="d-flex justify-content-between align-items-center fw-bold fs-5 mb-3">
            <span>Total:</span>
            <span class="total-price">₱${subtotal.toFixed(2)}</span>
        </div>
    `;
                    $('.cart-content').html(html);

                    // Plus button
                    $('.cart-plus').click(function() {
                        const idx = $(this).data('idx');
                        cart[idx].qty += 1;
                        renderCart();
                    });
                    // Minus button
                    $('.cart-minus').click(function() {
                        const idx = $(this).data('idx');
                        if (cart[idx].qty > 1) {
                            cart[idx].qty -= 1;
                        } else {
                            cart.splice(idx, 1);
                        }
                        renderCart();
                    });
                    // Remove button
                    $('.cart-remove').click(function() {
                        const idx = $(this).data('idx');
                        cart.splice(idx, 1);
                        renderCart();
                    });
                    updateCartBadge();
                }

                function updateCartBadge() {
                    let totalQty = 0;
                    cart.forEach(item => {
                        totalQty += item.qty;
                    });
                    const badge = document.getElementById('cart-badge');
                    if (badge) {
                        badge.textContent = totalQty;
                        badge.style.display = totalQty > 0 ? 'inline-block' : 'none';
                    }
                }

                function loadProducts() {
                    $.getJSON('../ajax/get_products.php', function(products) {
                        renderProducts(products);
                    });
                }

                loadProducts();
                setInterval(loadProducts, 5000); // Auto-refresh
            });
        </script>
    </body>
</html>