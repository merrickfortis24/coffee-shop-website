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
        <title>NaiTsa</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
                <img src="../assets/images/logo.png" class="img-logo" alt="KapeTann Logo">
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
                <div class="fas fa-shopping-cart" id="cart-btn">
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
<div class="cart" id="cart-sidebar" style="max-width:400px;">
    <h2 class="cart-title text-center mb-3" style="font-weight:700;">Your Cart:</h2>
    <div class="cart-content"></div>
    <hr>
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div class="total-title fw-bold">Total:</div>
        <div class="total-price fw-bold fs-4">₱0</div>
    </div>
    <form id="checkout-form">
        <div class="mb-3">
            <label class="fw-bold mb-2 d-block">Payment Method:</label>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="pay_method" id="cod" value="Cash on Delivery" checked>
                <label class="form-check-label" for="cod">Cash On Delivery</label>
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

        <!-- Add this payment instructions dropdown -->
        <div id="payment-instructions" class="mb-3" style="display: none;">
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-info-circle me-2"></i>Payment Instructions
                </div>
                <div class="card-body" id="instructions-content">
                    <!-- Instructions will be inserted here -->
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-buy w-100 btn-lg" style="background:#8B5C2A;color:#fff;">Checkout Now</button>
    </form>
</div>

<!-- PROFILE SIDEBAR -->
<div class="profile" id="profile-sidebar" style="max-width:400px;">
    <h2 class="profile-title text-center mb-3" style="font-weight:700;">My Profile</h2>
    <button id="close-profile-sidebar" class="btn-close" style="position:absolute;top:1rem;right:1rem;"></button>
    
    <div class="profile-content p-4">
        <!-- User Profile Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <!-- User Info Section -->
                <div class="d-flex align-items-center mb-4">
                    <div class="profile-avatar me-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary" 
                             style="width: 80px; height: 80px;">
                            <span class="display-6 text-white">
                                <?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?>
                            </span>
                        </div>
                    </div>
                    <div class="profile-info">
                        <h4 class="mb-1"><?php echo $_SESSION['username']; ?></h4>
                        <p class="text-muted mb-0">
                            <i class="bi bi-clock me-2"></i>
                            Member since <?php echo date('M Y'); ?>
                        </p>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <div class="profile-nav">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center" href="#" id="my-orders-link">
                                <i class="bi bi-bag me-2"></i>
                                My Orders
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center" href="edit-profile.php">
                                <i class="bi bi-person-gear me-2"></i>
                                Edit Profile
                            </a>
                        </li>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

        </header>

        


        <!-- HERO SECTION -->
        <section class="home" id="home">
            <div class="content">
                <h3>Welcome to Nai Tsa Food Hub, <?php echo $_SESSION['username']; ?>!</h3>
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
                        <div class="col-md-4">
                            <div class="box">
                                <div class="image">
                                    <img src="../assets/images/gallery6.jpg" alt="">
                                </div>
                                <div class="content">
                                    <div class="stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                    <h3 class="gallery-title">Picture 6</h3>
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
                                    <a href="https://www.facebook.com/share/1Bc1pZkk2U/" target="_blank" class="title text-decoration-none">Late-night hangout with your tropa or loved ones.</a>
                                    <span>by Nai Tsa Food Hub team</span>
                                    <p>We are now open until midnight so come enjoy late-night treats, cozy vibes, and unforgettable moments under the stars!</p>
                                    <center>
                                        <a href="https://www.facebook.com/share/1Bc1pZkk2U/" target="_blank" class="btn">Read More</a>
                                    </center>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="box">
                                <div class="image">
                                    <img src="../assets/images/barako.jpg" alt="">
                                </div>
                                <div class="content">
                                    <a href="https://www.facebook.com/share/p/16qL9Vr6y3/" target="_blank" class="title text-decoration-none">We're a GrabFood 5-Star Eats Merchant</a>
                                    <span>by GrabFood</span>
                                    <p>Your go-to for refreshing bubble teas & delicious bites. Customizable drinks, quick service, satisfying cravings day or night!</p>
                                    <center>
                                        <a href="https://www.facebook.com/share/p/16qL9Vr6y3/" target="_blank" class="btn">Read More</a>
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
                                    <a href="https://www.facebook.com/share/1ZyQgUrJRg/" target="_blank" class="title text-decoration-none">Meet Us at Barako Fest!</a>
                                    <span>by Barako Fest</span>
                                    <p>Experience rich coffee, hearty dishes, and vibrant vibes. Join the celebration of local flavors, community spirit, and unforgettable moments, see you there!</p>
                                    <center>
                                        <a href="https://www.facebook.com/share/1ZyQgUrJRg/" target="_blank" class="btn">Read More</a>
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
                <form name="contact" method="POST" action="https://formspree.io/f/xnnvvzvw">
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
                    <p>naitsa@gmail.com</p><br />
                    <i class="fas fa-phone"></i>
                    <p>+63 994-078-0881</p><br />
                    <i class="fab fa-facebook-messenger"></i>
                    <p>@naitsafoodhub</p><br />
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
                    <h2>Nai Tsa Food Hub © 2025 | All Rights Reserved.</h2>
                    <h2>Designed by <span>Kodigo ni Fortis</span> | BSIT</h2>
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

        <!-- Checkout Option Modal -->
<div id="checkout-modal" class="modal" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100vw; height:100vh; background:rgba(0,0,0,0.5); align-items:center; justify-content:center;">
  <div style="background:#fff; padding:2rem; border-radius:8px; max-width:350px; margin:auto; text-align:center;">
    <h3>Choose Order Type</h3>
    <button id="pickup-btn" class="btn btn-primary" style="margin:1rem;">Pick Up</button>
    <button id="delivery-btn" class="btn btn-primary" style="margin:1rem;">Delivery</button>
    <br>
    <button id="close-modal" class="btn btn-secondary" style="margin-top:1rem;">Cancel</button>
  </div>
</div>

<!-- Delivery Address Modal (Bootstrap 5) -->
<div class="modal fade" id="deliveryAddressModal" tabindex="-1" aria-labelledby="deliveryAddressModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="delivery-form">
        <div class="modal-header">
          <h5 class="modal-title" id="deliveryAddressModalLabel">Delivery Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="street" class="form-label">Street Address</label>
            <input type="text" class="form-control" id="street" required>
          </div>
          <div class="mb-3">
            <label for="barangay" class="form-label">Barangay</label>
            <input type="text" class="form-control" id="barangay" required>
          </div>
          <div class="mb-3">
            <label for="city" class="form-label">City</label>
            <input type="text" class="form-control" id="city" required>
          </div>
          <div class="mb-3">
            <label for="phone" class="form-label">Contact Number</label>
            <input type="tel" class="form-control" id="phone" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Confirm</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Orders Modal -->
<div class="modal fade" id="ordersModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">My Orders</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs mb-3" id="orderTabs">
                    <li class="nav-item">
                        <button class="nav-link active order-tab" id="to-pay-tab" 
                                onclick="filterUserOrders('to-pay')">To Pay</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link order-tab" id="to-ship-tab" 
                                onclick="filterUserOrders('to-ship')">To Ship</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link order-tab" id="to-receive-tab" 
                                onclick="filterUserOrders('to-receive')">To Receive</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link order-tab" id="delivered-tab" 
                                onclick="filterUserOrders('delivered')">Delivered</button>
                    </li>
                </ul>
                
                <!-- To Pay Orders -->
                <div id="to-pay-orders" class="order-section">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Date</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="to-pay-orders-body">
                                <!-- To pay orders will load here -->
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- To Ship Orders -->
                <div id="to-ship-orders" class="order-section" style="display:none;">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Date</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="to-ship-orders-body">
                                <!-- To ship orders will load here -->
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- To Receive Orders -->
                <div id="to-receive-orders" class="order-section" style="display:none;">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Date</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="to-receive-orders-body">
                                <!-- To receive orders will load here -->
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Delivered Orders -->
                <div id="delivered-orders" class="order-section" style="display:none;">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Date</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="delivered-orders-body">
                                <!-- Delivered orders will load here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Order Details Modal -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Order Details: <span id="order-details-number"></span></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="order-details-body">
                <!-- Order details will load here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

        <div id="sidebar-overlay" style="display:none;position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.2);z-index:899;"></div>

        <!-- JS File Link -->
        <script src="../assets/js/googleSignIn.js"></script>
        <script src="../assets/js/script.js"></script>
        <script src="../assets/js/responses.js"></script>
        <script src="../assets/js/convo.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

        <script>
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

function loadProducts() {
    $.getJSON('../ajax/get_products.php', function(products) {
        renderProducts(products);
    });
}

loadProducts();
setInterval(loadProducts, 5000); // Auto-refresh

// --- CART FUNCTIONALITY ---
let cart = [];

function addToCart(product) {
    // Check if product already in cart
    const found = cart.find(item => item.Product_name === product.Product_name);
    if (found) {
        found.quantity += 1;
    } else {
        cart.push({...product, quantity: 1});
    }
    renderCart();
}

function removeFromCart(productName) {
    cart = cart.filter(item => item.Product_name !== productName);
    renderCart();
}

function changeQuantity(productName, delta) {
    const item = cart.find(item => item.Product_name === productName);
    if (item) {
        item.quantity += delta;
        if (item.quantity <= 0) {
            removeFromCart(productName);
        } else {
            renderCart();
        }
    }
}

function renderCart() {
    let html = '';
    let total = 0;
    cart.forEach(item => {
        total += item.Price * item.quantity;
        html += `
            <div class="cart-item d-flex align-items-center mb-2">
                <img src="../admin_panel${item.product_image.substring(1)}" alt="" style="width:40px;height:40px;object-fit:cover;margin-right:8px;">
                <span class="me-2">${item.Product_name}</span>
                <span class="me-2">₱${item.Price}</span>
                <button class="btn btn-sm btn-outline-secondary me-1" onclick="changeQuantity('${item.Product_name}', 1)">+</button>
                <span class="me-2">x${item.quantity}</span>
                <button class="btn btn-sm btn-outline-secondary me-1" onclick="changeQuantity('${item.Product_name}', -1)">-</button>
                <button class="btn btn-sm btn-danger" onclick="removeFromCart('${item.Product_name}')">
                    <i class="fa fa-trash"></i></button>
            </div>
        `;
    });
    $('.cart-content').html(html);
    $('.total-price').text('₱' + total);
     updateCartBadge();
}

// Checkout button handler
$('.btn-buy').click(function() {
    if (cart.length === 0) {
        alert('Your cart is empty!');
        return;
    }
    document.getElementById('checkout-modal').style.display = 'flex';
});

// Make cart functions available globally for inline onclick
window.addToCart = addToCart;
window.removeFromCart = removeFromCart;
window.changeQuantity = changeQuantity;

function loadUserOrders() {
    fetch('orders.php?ajax=1')
        .then(response => response.text())
        .then(html => {
            document.getElementById('orders-list').innerHTML = html;
        })
        .catch(() => {
            document.getElementById('orders-list').innerHTML = '<div class="text-danger">Failed to load orders.</div>';
        });
}




        </script> 
    </body>
</html>