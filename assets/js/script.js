// Show Navbar when small screen || Close Cart Items & Search Textbox
let navbar = document.querySelector('.navbar');
let cartItem = document.querySelector('.cart:not(.profile-sidebar)');
let profileBtn = document.querySelector('#profile-btn');
let profileSidebar = document.querySelector('#profile-sidebar');
let sidebarOverlay = document.querySelector('#sidebar-overlay');
let closeProfileBtn = document.querySelector('#close-profile-sidebar');
let searchForm = document.querySelector('.search-form');

document.querySelector('#menu-btn').onclick = () => {
    navbar.classList.toggle('active');
    cartItem.classList.remove('active');
    searchForm.classList.remove('active');
}
document.querySelector('#cart-btn').onclick = () => {
    cartItem.classList.toggle('active');
    profileSidebar.classList.remove('active'); // hide profile sidebar
};
profileBtn.onclick = () => {
    profileSidebar.classList.add('active');
    sidebarOverlay.style.display = 'block';
    loadUserOrders(); // Load orders when profile is opened
}

closeProfileBtn.onclick = () => {
    profileSidebar.classList.remove('active');
    sidebarOverlay.style.display = 'none';
    closeAllModals();  // Ensure this is called
};

sidebarOverlay.onclick = () => {
    profileSidebar.classList.remove('active');
    cartItem.classList.remove('active');
    sidebarOverlay.style.display = 'none';
    closeAllModals();  // Ensure this is called
};

// Toggle Profile Sidebar
document.getElementById('profile-btn').onclick = function () {
    if (profileSidebar.classList.contains('active')) {
        profileSidebar.classList.remove('active');
    } else {
        profileSidebar.classList.add('active');
        cartItem.classList.remove('active'); // hide cart sidebar
        loadUserOrders();
    }
};
document.getElementById('close-profile-sidebar').onclick = function() {
    profileSidebar.classList.remove('active');
    sidebarOverlay.style.display = 'none'; // <-- Add this line
};

// Show Search Textbox || Close Navbar & Cart Items
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
    var deliveryModal = new bootstrap.Modal(document.getElementById('deliveryAddressModal'));
    deliveryModal.show();
};
document.getElementById('close-modal').onclick = function() {
    document.getElementById('checkout-modal').style.display = 'none';
};

// Handle delivery form submission
document.getElementById('delivery-form').onsubmit = function(e) {
    e.preventDefault();
    const deliveryAddress = {
        street: document.getElementById('street').value,
        barangay: document.getElementById('barangay').value,
        city: document.getElementById('city').value,
        phone: document.getElementById('phone').value
    };
    // Hide modal
    var deliveryModalEl = document.getElementById('deliveryAddressModal');
    var modalInstance = bootstrap.Modal.getInstance(deliveryModalEl);
    modalInstance.hide();
    proceedCheckout('delivery', deliveryAddress);
};

// Call this from your modal buttons, passing 'pickup' or 'delivery'
function proceedCheckout(orderType, deliveryAddress = null) {
    const payMethod = $('input[name="pay_method"]:checked').val();
    const invoiceNumber = 'INV' + Date.now();
    const orderDetails = {
        items: cart.map(item => ({
            title: item.Product_name,
            price: parseFloat(item.Price),
            quantity: item.quantity,
            subtotal_amount: parseFloat(item.Price) * item.quantity
        })),
        invoice_number: invoiceNumber,
        pay_method: payMethod,
        order_type: orderType,
        delivery_address: deliveryAddress
    };

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
        console.error(err);
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

    // Add this at the end
    const cartUpdatedEvent = new Event('cartUpdated');
    document.dispatchEvent(cartUpdatedEvent);
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

document.getElementById('close-profile-sidebar').onclick = function() {
    profileSidebar.classList.remove('active');
    sidebarOverlay.style.display = 'none'; // <-- Add this line
};

function loadUserOrders() {
    const ordersList = document.getElementById('orders-list');
    fetch('orders.php?ajax=1')
        .then(response => response.text())
        .then(html => {
            ordersList.innerHTML = html || '<div class="text-center text-muted">No orders found</div>';
        })
        .catch(() => {
            ordersList.innerHTML = '<div class="text-center text-danger">Failed to load orders</div>';
        });
}

document.getElementById('my-orders-link').addEventListener('click', function(e) {
    e.preventDefault();
    fetchOrders();
    
    // Add a small delay to ensure content is loaded before showing modal
    setTimeout(() => {
        const ordersModal = new bootstrap.Modal(document.getElementById('ordersModal'));
        ordersModal.show();
    }, 50);
});

// Add this function to your script.js
function getStatusClass(status) {
    if (status === null || status === undefined) return 'bg-secondary';
    if (typeof status !== 'string') status = String(status);
    status = status.toLowerCase();
    switch(status) {
        case 'pending': 
            return 'bg-warning text-dark';
        case 'delivered': 
            return 'bg-success';
        case 'cancelled': 
            return 'bg-danger';
        default: 
            return 'bg-secondary';
    }
}

// Add this function as well
function getProgress(status) {
    if (!status) return 0;
    
    status = status.toLowerCase();
    switch(status) {
        case 'pending': return 25;
        case 'preparing': return 50;
        case 'ready': return 75;
        default: return 0;
    }
}

// Now the orders functions
function fetchOrders(status = 'all', search = '') {
    const url = `orders.php?status=${status}&search=${encodeURIComponent(search)}`;
    
    fetch(url)
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(orders => {
            const containerId = `${status}-orders-body`;
            const container = document.getElementById(containerId);
            
            if (container) {
                renderOrders(orders, containerId);
                
                if(status === 'all') {
                    ['pending', 'delivered', 'cancelled'].forEach(s => {
                        const sContainer = document.getElementById(`${s}-orders-body`);
                        if (sContainer) {
                            const filtered = orders.filter(order => order.status === s);
                            renderOrders(filtered, `${s}-orders-body`);
                        }
                    });
                }
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            const container = document.getElementById(`${status}-orders-body`);
            if (container) {
                container.innerHTML = `
                    <tr>
                        <td colspan="7" class="text-center text-danger">
                            Failed to load orders. Please try again.
                        </td>
                    </tr>
                `;
            }
        });
}

function renderOrders(orders, containerId) {
    const container = document.getElementById(containerId);

    // Check if container exists
    if (!container) {
        console.error(`Container ${containerId} not found!`);
        return;
    }

    if (!orders || orders.length === 0) {
        container.innerHTML = `
            <tr>
                <td colspan="7" class="text-center text-muted">
                    No orders found
                </td>
            </tr>
        `;
        return;
    }

    let html = '';
    orders.forEach(order => {
        const date = new Date(order.date).toLocaleString();
        const itemCount = order.items.length;
        const statusClass = getStatusClass(order.status);

        html += `
            <tr class="order-row" data-invoice="${order.invoice}">
                <td>${order.invoice}</td>
                <td>${date}</td>
                <td>${itemCount} item${itemCount > 1 ? 's' : ''}</td>
                <td>₱${order.total.toFixed(2)}</td>
                <td><span class="badge ${statusClass}">${order.status}</span></td>
                <td>${order.type}</td>
                <td>
                    <button class="btn btn-sm btn-outline-primary view-order-details">
                        <i class="fas fa-eye"></i> Details
                    </button>
                </td>
            </tr>
        `;
    });

    container.innerHTML = html;

    // Remove any previous event listeners to avoid stacking
    const newContainer = document.getElementById(containerId);
    const viewDetailButtons = newContainer.getElementsByClassName('view-order-details');
    for (let button of viewDetailButtons) {
        button.addEventListener('click', function() {
            const invoice = this.closest('.order-row').dataset.invoice;
            viewOrderDetails(invoice);
        });
    }
}

function viewOrderDetails(invoice) {
    const detailsNumber = document.getElementById('order-details-number');
    const detailsBody = document.getElementById('order-details-body');

    if (!detailsNumber || !detailsBody) {
        console.error('Order details elements not found');
        return;
    }

    fetch(`order_details.php?invoice=${encodeURIComponent(invoice)}`)
        .then(response => response.json())
        .then(order => {
            if (order.error) {
                alert(order.error);
                return;
            }

            detailsNumber.textContent = order.invoice;

            let itemsHtml = '';
            if (order.items && Array.isArray(order.items)) {
                order.items.forEach(item => {
                    itemsHtml += `
                        <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                            <div>
                                <h6>${item.title}</h6>
                                <div class="text-muted">${item.quantity} × ₱${parseFloat(item.price).toFixed(2)}</div>
                            </div>
                            <div class="fw-bold">₱${parseFloat(item.subtotal).toFixed(2)}</div>
                        </div>
                    `;
                });
            }

            // Status display (updated for timeline)
            const statusHtml = `
                <p><strong>Status:</strong> 
                    ${order.status === 0 ? '<span class="badge bg-warning">Pending</span>' : 
                      order.status === 1 ? '<span class="badge bg-info">Processing</span>' : 
                      order.status === 2 ? '<span class="badge bg-success">Delivered</span>' : 
                      '<span class="badge bg-secondary">Unknown</span>'}
                </p>
            `;

            const detailsHtml = `
                <div class="row">
                    <div class="col-md-6">
                        <h5>Order Summary</h5>
                        <div class="card">
                            <div class="card-body">
                                ${itemsHtml}
                                <div class="d-flex justify-content-between mt-3 fw-bold">
                                    <div>Total:</div>
                                    <div>₱${order.total ? parseFloat(order.total).toFixed(2) : '0.00'}</div>
                                </div>
                            </div>
                        </div>
                        
                        <h5 class="mt-4">Payment Information</h5>
                        <div class="card">
                            <div class="card-body">
                                <p><strong>Method:</strong> ${order.payment_method || ''}</p>
                                ${statusHtml}
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <h5>${order.type === 'delivery' ? 'Delivery' : 'Pickup'} Information</h5>
                        <div class="card">
                            <div class="card-body">
                                <p><strong>Type:</strong> ${order.type || ''}</p>
                                ${order.type === 'delivery' && order.delivery_address ? `
                                    <p><strong>Address:</strong> 
                                        ${order.delivery_address.street || ''}, 
                                        ${order.delivery_address.barangay || ''}, 
                                        ${order.delivery_address.city || ''}
                                    </p>
                                    <p><strong>Contact:</strong> ${order.delivery_address.phone || ''}</p>
                                ` : '<p>Pickup at store</p>'}
                                <p><strong>Date:</strong> ${order.date ? new Date(order.date).toLocaleString() : ''}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            `;
            
            detailsBody.innerHTML = detailsHtml;

            // --- NEW LOGIC: Close Orders modal, then open Details modal ---
            const detailsModalEl = document.getElementById('orderDetailsModal');
            if (detailsModalEl) {
                const detailsModal = bootstrap.Modal.getOrCreateInstance(detailsModalEl);

                // Close the Orders modal first
                const ordersModalEl = document.getElementById('ordersModal');
                if (ordersModalEl) {
                    const ordersModal = bootstrap.Modal.getInstance(ordersModalEl);
                    if (ordersModal) {
                        ordersModal.hide();
                    }
                }

                // Then show the Details modal
                detailsModal.show();
            }
        })
        .catch(error => {
            console.error('Error loading order details:', error);
            alert('Failed to load order details. Please try again.');
        });
}

// Fetch and render user orders
function fetchUserOrders(status = 'to-pay') {
    const url = `orders.php?status=${status}`;
    
    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            // Check if we got an error response
            if (data.error) {
                throw new Error(`Server error: ${data.error}`);
            }
            renderUserOrders(data, `${status}-orders-body`);
        })
        .catch(error => {
            console.error(`Error fetching ${status} orders:`, error);
            const container = document.getElementById(`${status}-orders-body`);
            if (container) {
                container.innerHTML = `
                    <tr>
                        <td colspan="6" class="text-center text-danger">
                            Failed to load orders. Please try again.<br>
                            Error: ${error.message}
                        </td>
                    </tr>
                `;
            }
        });
}

// Update the getOrderStatusText function to check order_status first
function getOrderStatusText(order) {
    // Check delivery status first
    if (order.status === 2) {
        return '<span class="badge bg-success">Delivered</span>';
    } else if (order.status === 1) {
        return '<span class="badge bg-info">Processing</span>';
    }
    
    // Then check payment status
    if (order.pay_status === 0) {
        return '<span class="badge bg-danger">Pending</span>';
    } else if (order.status === 0) {
        return '<span class="badge bg-warning">Pending</span>';
    }
    
    return '<span class="badge bg-secondary">Unknown</span>';
}

// Update the renderUserOrders function
function renderUserOrders(orders, containerId) {
    const container = document.getElementById(containerId);
    if (!container) {
        console.error(`Container ${containerId} not found`);
        return;
    }
    
    // Clear previous content
    container.innerHTML = '';
    
    if (!orders || orders.length === 0) {
        container.innerHTML = `
            <tr>
                <td colspan="6" class="text-center text-muted">
                    No orders found
                </td>
            </tr>
        `;
        return;
    }

    let html = '';
    orders.forEach(order => {
        const date = new Date(order.date).toLocaleString();
        const itemCount = order.items.length;
        const statusText = getOrderStatusText(order);
        
        html += `
            <tr class="order-row" data-invoice="${order.invoice}">
                <td>${order.invoice}</td>
                <td>${date}</td>
                <td>${itemCount} item${itemCount > 1 ? 's' : ''}</td>
                <td>₱${order.total.toFixed(2)}</td>
                <td>${statusText}</td>
                <td>
                    <button class="btn btn-sm btn-outline-primary view-order-details">
                        <i class="fas fa-eye"></i> Details
                    </button>
                </td>
            </tr>
        `;
    });
    
    container.innerHTML = html;
}

// Add this function to initialize the tabs
function initOrderTabs() {
    // Set default tab to active
    document.getElementById('to-pay-tab').classList.add('active');
    document.getElementById('to-pay-orders').style.display = 'block';

    // Add event listeners to tabs
    document.getElementById('to-pay-tab').addEventListener('click', () => filterUserOrders('to-pay'));
    document.getElementById('to-ship-tab').addEventListener('click', () => filterUserOrders('to-ship'));
    document.getElementById('to-receive-tab').addEventListener('click', () => filterUserOrders('to-receive'));
    document.getElementById('delivered-tab').addEventListener('click', () => filterUserOrders('delivered')); // Added delivered tab
}

// Update the filterUserOrders function
function filterUserOrders(status) {
    // Hide all order sections, including delivered
    document.querySelectorAll('.order-section').forEach(section => {
        section.style.display = 'none';
    });

    // Remove active class from all tabs, including delivered
    document.querySelectorAll('.order-tab').forEach(tab => {
        tab.classList.remove('active');
    });

    // Show selected section and activate tab (including delivered)
    const section = document.getElementById(`${status}-orders`);
    const tab = document.getElementById(`${status}-tab`);
    if (section) section.style.display = 'block';
    if (tab) tab.classList.add('active');

    // Load orders for this status
    fetchUserOrders(status);
}

// Update initOrders function to include tab initialization
function initOrders() {
    // Initialize tabs
    initOrderTabs();

    // Load orders when profile is opened
    const ordersLink = document.getElementById('my-orders-link');
    if (ordersLink) {
        ordersLink.addEventListener('click', function(e) {
            e.preventDefault();

            // Load initial orders
            fetchUserOrders('to-pay');

            // Show orders modal
            const ordersModalEl = document.getElementById('ordersModal');
            if (ordersModalEl) {
                const ordersModal = new bootstrap.Modal(ordersModalEl);
                ordersModal.show();
            }
        });
    }

    // Handle order details clicks
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('view-order-details') ||
            (e.target.closest && e.target.closest('.view-order-details'))) {
            const row = e.target.closest('.order-row');
            const invoice = row.dataset.invoice;
            viewOrderDetails(invoice);
        }
    });

    // Properly handle modal closing
    const ordersModal = document.getElementById('ordersModal');
    if (ordersModal) {
        ordersModal.addEventListener('hidden.bs.modal', function() {
            // Reset to default tab when modal is closed
            filterUserOrders('to-pay');
        });
    }
}



// Payment instructions
function setupPaymentInstructions() {
    const paymentRadios = document.querySelectorAll('input[name="pay_method"]');
    const paymentInstructions = document.getElementById('payment-instructions');
    const instructionsContent = document.getElementById('instructions-content');

    function updatePaymentInstructions() {
        const selected = document.querySelector('input[name="pay_method"]:checked');
        if (!selected) {
            paymentInstructions.style.display = 'none';
            return;
        }

        if (selected.value === 'GCash') {
            instructionsContent.innerHTML = `
                <h5 class="card-title">GCash Payment Instructions</h5>
                <p class="card-text">Please send payment to:</p>
                <ul class="list-group list-group-flush mb-3">
                    <li class="list-group-item"><strong>Account Name:</strong> KapeTann Coffee Shop</li>
                    <li class="list-group-item"><strong>Account Number:</strong> 0917-134-1422</li>
                    <li class="list-group-item"><strong>Amount:</strong> ₱<span class="total-price">0</span></li>
                    <li class="list-group-item"><strong>Reference:</strong> Use your Order ID</li>
                </ul>
                <p class="text-muted">After payment, please keep the transaction receipt as proof.</p>
            `;
            paymentInstructions.style.display = 'block';
        } else if (selected.value === 'Credit Card') {
            instructionsContent.innerHTML = `
                <h5 class="card-title">Credit Card Payment</h5>
                <p class="card-text">You'll be redirected to our secure payment gateway.</p>
                <ul class="list-group list-group-flush mb-3">
                    <li class="list-group-item">Please have your card details ready</li>
                    <li class="list-group-item">We accept Visa, Mastercard, and AMEX</li>
                    <li class="list-group-item">Amount: ₱<span class="total-price">0</span></li>
                </ul>
                <p class="text-muted">Your card will be charged immediately upon confirmation.</p>
            `;
            paymentInstructions.style.display = 'block';
        } else {
            paymentInstructions.style.display = 'none';
        }
        
        // Update total price in instructions
        const totalElements = document.querySelectorAll('#instructions-content .total-price');
        const totalPrice = document.querySelector('.total-price') ? document.querySelector('.total-price').innerText : '0';
        totalElements.forEach(el => {
            el.textContent = totalPrice.replace('₱', '');
        });
    }

    paymentRadios.forEach(radio => {
        radio.addEventListener('change', updatePaymentInstructions);
    });

    // Initialize on page load
    updatePaymentInstructions();
}

// Add this function to map status numbers to text
function mapStatus(statusCode) {
    const statusMap = {
        0: 'pending',
        2: 'processing',
        1: 'delivered'
    };
    return statusMap[statusCode] || 'unknown';
}

// Initialize when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Initialize orders system
    initOrders();
    
    // Initialize cart and other systems
    if (document.querySelector('.cart-content')) {
        ready();
    }
    
    // Initialize payment instructions
    setupPaymentInstructions();
});

// Helper function to close all Bootstrap modals and remove backdrops
function closeAllModals() {
    // Hide all Bootstrap modals
    document.querySelectorAll('.modal').forEach(modal => {
        const modalInstance = bootstrap.Modal.getInstance(modal);
        if (modalInstance) {
            modalInstance.hide();
        }
    });

    // Remove all modal backdrops
    document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
        backdrop.remove();
    });

    // Reset body styling
    document.body.classList.remove('modal-open');
    document.body.style.paddingRight = '';
    document.body.style.overflow = '';
}

// Add CSS to fix modal z-index issues
const modalFixCSS = `
    .modal-backdrop {
        z-index: 1040 !important;
    }
    .modal {
        z-index: 1050 !important;
    }
`;
document.head.insertAdjacentHTML('beforeend', `<style>${modalFixCSS}</style>`);

// Update your close handlers to always call closeAllModals
closeProfileBtn.onclick = () => {
    profileSidebar.classList.remove('active');
    sidebarOverlay.style.display = 'none';
    closeAllModals();  // Ensure this is called
};

sidebarOverlay.onclick = () => {
    profileSidebar.classList.remove('active');
    cartItem.classList.remove('active');
    sidebarOverlay.style.display = 'none';
    closeAllModals();  // Ensure this is called
};

// Also add this to handle when modal close button is clicked
document.addEventListener('click', function(e) {
    if (
        e.target.classList.contains('btn-close') ||
        (e.target.classList.contains('btn-secondary') && e.target.closest('.modal-footer'))
    ) {
        closeAllModals();
    }
});

// --- Add this event listener for when the Order Details modal is closed ---
document.addEventListener('DOMContentLoaded', function() {
    const detailsModalEl = document.getElementById('orderDetailsModal');
    if (detailsModalEl) {
        detailsModalEl.addEventListener('hidden.bs.modal', function() {
            // When details modal is closed, reopen the orders modal
            const ordersModalEl = document.getElementById('ordersModal');
            if (ordersModalEl) {
                const ordersModal = bootstrap.Modal.getOrCreateInstance(ordersModalEl);
                ordersModal.show();
            }
        });
    }
});