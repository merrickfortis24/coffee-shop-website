// Show Navbar when small screen || Close Cart Items & Search Textbox
let navbar = document.querySelector('.navbar');

document.querySelector('#menu-btn').onclick = () => {
    navbar.classList.toggle('active');
    cartItem.classList.remove('active');
    searchForm.classList.remove('active');
}

// Show Cart Items || Close Navbar & Search Textbox
let cartItem = document.querySelector('.cart');

document.querySelector('#cart-btn').onclick = () => {
    cartItem.classList.toggle('active');
    navbar.classList.remove('active');
    searchForm.classList.remove('active');
}

// Show Search Textbox || Close Navbar & Cart Items
let searchForm = document.querySelector('.search-form');

document.querySelector('#search-btn').onclick = () => {
    searchForm.classList.toggle('active');
    navbar.classList.remove('active');
    cartItem.classList.remove('active');
}

// Remove Active Icons on Scroll and Close it
window.onscroll = () => {
    navbar.classList.remove('active');
    cartItem.classList.remove('active');
    searchForm.classList.remove('active');
}

// Script for making icon as button
document.getElementById('paper-plane-icon').addEventListener('click', function() {
    // Add your desired action here, e.g. submit form, trigger AJAX request, etc.
    alert('Paper airplane clicked!');
});


//Cart Working JS
if (document.readyState == 'loading') {
    document.addEventListener("DOMContentLoaded", ready);
} else {
    ready();
}

// FUNCTIONS FOR CART
function ready() {
    //Remove Items from Cart
    var removeCartButtons = document.getElementsByClassName('cart-remove');
    console.log(removeCartButtons);
    for (var i = 0; i < removeCartButtons.length; i++){
        var button = removeCartButtons[i];
        button.addEventListener('click', removeCartItem);
    }

    // When quantity changes
    var quantityInputs = document.getElementsByClassName("cart-quantity");
    for (var i = 0; i < quantityInputs.length; i++){
        var input = quantityInputs[i];
        input.addEventListener("change", quantityChanged);
    }

    // Add to Cart
    var addCart = document.getElementsByClassName('add-cart');
    for (var i = 0; i < addCart.length; i++){
        var button = addCart[i];
        button.addEventListener("click", addCartClicked);
    }

    // Buy Button Works
    document.getElementsByClassName("btn-buy")[0].addEventListener("click", buyButtonClicked);
}

// Function for "Buy Button Works"
function buyButtonClicked() {
    if (cart.length === 0) {
        alert('Your cart is empty!');
        return;
    }
    // Show the modal to choose pickup or delivery
    document.getElementById('checkout-modal').style.display = 'flex';
}
// Modal button handlers
document.getElementById('pickup-btn').onclick = function() {
    document.getElementById('checkout-modal').style.display = 'none';
    proceedCheckout('pickup');
};
document.getElementById('delivery-btn').onclick = function() {
    document.getElementById('checkout-modal').style.display = 'none';
    proceedCheckout('delivery');
};
document.getElementById('close-modal').onclick = function() {
    document.getElementById('checkout-modal').style.display = 'none';
};

// Call this from your modal buttons, passing 'pickup' or 'delivery'
function proceedCheckout(orderType) {
    const payMethod = $('input[name="pay_method"]:checked').val();
    const invoiceNumber = 'INV' + Date.now();
    const orderDetails = cart.map(item => ({
        title: item.Product_name, // match your PHP
        price: parseFloat(item.Price),
        quantity: item.quantity,
        subtotal_amount: parseFloat(item.Price) * item.quantity,
        invoice_number: invoiceNumber,
        pay_method: payMethod,
        order_type: orderType // this will be 'pickup' or 'delivery'
    }));

    fetch('add_to_database.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(orderDetails)
    })
    .then(response => response.text())
    .then(data => {
        alert('Order placed successfully!');
        cart = [];
        renderCart();
    })
    .catch(err => {
        alert('There was an error placing your order.');
    });
}

// Function to generate invoice number
function generateInvoiceNumber() {
    // Implement your logic to generate an invoice number here
    return "INV-" + Math.floor(Math.random() * 1000000);
}

// Function for "Remove Items from Cart"
function removeCartItem(event) {
    var buttonClicked = event.target;
    var title = buttonClicked.parentElement.getElementsByClassName("cart-product-title")[0].innerText;
    cart = cart.filter(item => item.title !== title);
    buttonClicked.parentElement.remove();
    updateTotal();
    updateCartBadge();
}

// Function for "When quantity changes"
function quantityChanged(event) {
    var input = event.target;
    if (isNaN(input.value) || input.value <= 0) {
        input.value = 1;
    }
    // Update the cart array
    var title = input.parentElement.getElementsByClassName("cart-product-title")[0].innerText;
    let found = cart.find(item => item.title === title);
    if (found) {
        found.quantity = parseInt(input.value);
    }
    updateTotal();
    updateCartBadge();
}

//Add to Cart
function addCartClicked(event) {
    var button = event.target;
    var shopProducts = button.parentElement;
    var title = shopProducts.getElementsByClassName("product-title")[0].innerText;
    var price = shopProducts.getElementsByClassName("price")[0].innerText;
    var productImg = shopProducts.getElementsByClassName("product-img")[0].src;

    // Check if already in cart
    let found = cart.find(item => item.title === title);
    if (found) {
        found.quantity += 1;
    } else {
        cart.push({ title: title, price: price, productImg: productImg, quantity: 1 });
    }
}


function addProductToCart(title, price, productImg) {
    var cartShopBox = document.createElement("div");
    cartShopBox.classList.add("cart-box");
    var cartItems = document.getElementsByClassName("cart-content")[0];
    var cartItemsNames = cartItems.getElementsByClassName("cart-product-title");
    for (var i = 0; i < cartItemsNames.length; i++) {
        if (cartItemsNames[i].innerText == title) {
            alert("You have already added this item to cart!")
            return;
        }
    }
    var cartBoxContent = `
                    <img src="${productImg}" alt="" class="cart-img">
                    <div class="detail-box">
                        <div class="cart-product-title">${title}</div>
                        <div class="cart-price">${price}</div>
                        <input type="number" value="1" min="1" class="cart-quantity">
                    </div>
                    <!-- REMOVE BUTTON -->
                    <i class="fas fa-trash cart-remove"></i>`;
    cartShopBox.innerHTML = cartBoxContent;
    cartItems.append(cartShopBox);
    cartShopBox
        .getElementsByClassName("cart-remove")[0]
        .addEventListener('click', removeCartItem);
    cartShopBox
        .getElementsByClassName("cart-quantity")[0]
        .addEventListener('change', quantityChanged);

    updateCartBadge();
}

// Update Total
function updateTotal() {
    var cartContent = document.getElementsByClassName("cart-content")[0];
    var cartBoxes = cartContent.getElementsByClassName("cart-box");
    var total = 0;
    for (var i = 0; i < cartBoxes.length; i++) {
        var cartBox = cartBoxes[i];
        var priceElement = cartBox.getElementsByClassName("cart-price")[0];
        var quantityElement = cartBox.getElementsByClassName("cart-quantity")[0];
        var price = parseFloat(priceElement.innerText.replace("₱", ""));
        var quantity = quantityElement.value;
        total = total + (price * quantity);
    }
        total = Math.round(total * 100) / 100;
        
        document.getElementsByClassName("total-price")[0].innerText = "₱" + total;
}

// Update Cart Badge
function updateCartBadge() {
    let totalQty = 0;
    cart.forEach(item => {
        totalQty += item.quantity;
    });
    const badge = document.getElementById('cart-badge');
    if (badge) {
        badge.textContent = totalQty;
        badge.style.display = totalQty > 0 ? 'inline-block' : 'none';
    }
}

// Toggle profile sidebar on icon click
document.getElementById('profile-btn').onclick = function() {
    const sidebar = document.getElementById('profile-sidebar');
    if (sidebar.classList.contains('active')) {
        sidebar.classList.remove('active');
    } else {
        sidebar.classList.add('active');
        loadUserOrders();
    }
};

// Close button still hides the sidebar
document.getElementById('close-profile-sidebar').onclick = function() {
    document.getElementById('profile-sidebar').classList.remove('active');
};

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