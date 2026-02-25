document.querySelectorAll('.product-card').forEach(card => {
    const dots = card.querySelectorAll('.dot');
    const mainImage = card.querySelector('.main-image img');
    
    dots.forEach(dot => {
        dot.addEventListener('click', () => {
            // Remove active class from all dots
            dots.forEach(d => d.classList.remove('active'));
            // Add active class to clicked dot
            dot.classList.add('active');
            // Change image source
            mainImage.src = dot.dataset.image;
        });
    });
});

// Wishlist Toggle
document.querySelectorAll('.new-wishlist-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        btn.classList.toggle('active');
        const icon = btn.querySelector('i');
        icon.classList.toggle('far');
        icon.classList.toggle('fas');
    });
});

// Add to your existing JavaScript
// document.querySelectorAll('.quickview-btn').forEach(btn => {
//     btn.addEventListener('click', () => {
//         // Add your quick view functionality here
//     });
// });

// document.querySelectorAll('.plus-btn').forEach(btn => {
//     btn.addEventListener('click', () => {
//         // Add your plus button functionality here
//     });
// });


// Add touch event handling for mobile
document.querySelectorAll('.product-box').forEach(box => {
    const dots = box.querySelectorAll('.dot');
    const mainImage = box.querySelector('.product-image img');
    
    dots.forEach(dot => {
        ['click', 'touchend'].forEach(evt => 
            dot.addEventListener(evt, (e) => {
                e.preventDefault();
                dots.forEach(d => d.classList.remove('active'));
                dot.classList.add('active');
                mainImage.src = dot.dataset.image;
            })
        );
    });
});


// Function to open the side menu for quick view
// function openMenu() {
//     document.getElementById('quickview-menu').classList.add('active');
// }

// Function to close the side menu
// function closeMenu() {
//     document.getElementById('quickview-menu').classList.remove('active');
// }


// function toggleQuickView(productId = null) {
//     const sidebar = document.getElementById('quick-view-sidebar');
//     const content = sidebar.querySelector('.quick-view-content');

//     if (productId) {
//         // Load product data
//         fetch(`/product/quick-view/${productId}`)
//             .then(response => response.text())
//             .then(html => {
//                 content.innerHTML = html;
//                 sidebar.classList.add('active');
//             });
//     } else {
//         sidebar.classList.remove('active');
//     }
// }

// // Close when clicking outside
// document.addEventListener('click', function(e) {
//     const sidebar = document.getElementById('quick-view-sidebar');
//     const quickViewBtns = document.querySelectorAll('.plus-btn');
//     let isQuickViewBtn = false;

//     quickViewBtns.forEach(btn => {
//         if (btn.contains(e.target)) isQuickViewBtn = true;
//     });

//     if (!sidebar.contains(e.target) && !isQuickViewBtn && sidebar.classList.contains('active')) {
//         toggleQuickView();
//     }
// });

// function updateQuickViewImage(src) {
//     document.getElementById('quickview-main-image').src = src;
// }

// function incrementQuantity(btn) {
//     const input = btn.previousElementSibling;
//     const currentValue = parseInt(input.value);
//     if (currentValue < parseInt(input.max)) {
//         input.value = currentValue + 1;
//     }
// }

// function decrementQuantity(btn) {
//     const input = btn.nextElementSibling;
//     const currentValue = parseInt(input.value);
//     if (currentValue > parseInt(input.min)) {
//         input.value = currentValue - 1;
//     }
// }