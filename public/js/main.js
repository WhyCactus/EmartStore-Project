(function ($) {
    "use strict";

    // Dropdown on mouse hover
    $(document).ready(function () {
        function toggleNavbarMethod() {
            if ($(window).width() > 768) {
                $('.navbar .dropdown').on('mouseover', function () {
                    $('.dropdown-toggle', this).trigger('click');
                }).on('mouseout', function () {
                    $('.dropdown-toggle', this).trigger('click').blur();
                });
            } else {
                $('.navbar .dropdown').off('mouseover').off('mouseout');
            }
        }
        toggleNavbarMethod();
        $(window).resize(toggleNavbarMethod);
    });


    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 1500, 'easeInOutExpo');
        return false;
    });


    // Home page slider
    $('.main-slider').slick({
        autoplay: true,
        dots: true,
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        centerMode: true,
        variableWidth: true
    });


    // Product Slider 4 Column
    $('.product-slider-4').slick({
        autoplay: true,
        infinite: true,
        dots: false,
        slidesToShow: 4,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 4,
                }
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 3,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 1,
                }
            },
        ]
    });


    // Product Slider 3 Column
    $('.product-slider-3').slick({
        autoplay: true,
        infinite: true,
        dots: false,
        slidesToShow: 3,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 3,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 1,
                }
            },
        ]
    });


    // Single Product Slider
    $('.product-slider-single').slick({
        infinite: true,
        dots: false,
        slidesToShow: 1,
        slidesToScroll: 1
    });


    // Brand Slider
    $('.brand-slider').slick({
        speed: 1000,
        autoplay: true,
        autoplaySpeed: 1000,
        infinite: true,
        arrows: false,
        dots: false,
        slidesToShow: 5,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 4,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 3,
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 300,
                settings: {
                    slidesToShow: 1,
                }
            }
        ]
    });


    // Quantity
    document.addEventListener('DOMContentLoaded', function () {
        let updateTimeout;

        function updateTotalPrice(itemId, quantity, unitPrice) {
            const totalPrice = quantity * unitPrice;
            const totalElement = document.getElementById(`total-price-${itemId}`);
            if (totalElement) {
                totalElement.textContent = '$' + totalPrice.toFixed(2);
            }

            updateCartSummary();
        }

        function updateCartSummary() {
            let newSubtotal = 0;

            const totalElements = document.querySelectorAll('.total-price');
            totalElements.forEach(element => {
                const priceText = element.textContent.replace('$', '');
                newSubtotal += parseFloat(priceText);
            });

            const shippingCost = 1;
            const newGrandTotal = newSubtotal + shippingCost;

            const subtotalElement = document.querySelector('.subtotal-amount');
            const grandtotalElement = document.querySelector('.grandtotal-amount');

            if (subtotalElement) {
                subtotalElement.textContent = '$' + newSubtotal.toFixed(2);
            }
            if (grandtotalElement) {
                grandtotalElement.textContent = '$' + newGrandTotal.toFixed(2);
            }
        }

        function autoSubmitForm(itemId) {
            const form = document.querySelector(`.update-form input[data-item-id="${itemId}"]`).closest('form');

            if (updateTimeout) {
                clearTimeout(updateTimeout);
            }

            updateTimeout = setTimeout(() => {
                form.submit();
            }, 1000);
        }

        const minusButtons = document.querySelectorAll('.btn-minus');
        minusButtons.forEach(button => {
            button.addEventListener('click', function () {
                const itemId = this.dataset.itemId;
                const unitPrice = parseFloat(this.dataset.unitPrice);
                const input = document.querySelector(`.quantity-input[data-item-id="${itemId}"]`);

                let currentValue = parseInt(input.value);
                if (currentValue > 1) {
                    input.value = currentValue - 1;
                    updateTotalPrice(itemId, input.value, unitPrice);
                    autoSubmitForm(itemId);
                }
            });
        });

        const plusButtons = document.querySelectorAll('.btn-plus');
        plusButtons.forEach(button => {
            button.addEventListener('click', function () {
                const itemId = this.dataset.itemId;
                const unitPrice = parseFloat(this.dataset.unitPrice);
                const input = document.querySelector(`.quantity-input[data-item-id="${itemId}"]`);

                let currentValue = parseInt(input.value);
                input.value = currentValue + 1;
                updateTotalPrice(itemId, input.value, unitPrice);
                autoSubmitForm(itemId);
            });
        });

        const quantityInputs = document.querySelectorAll('.quantity-input');
        quantityInputs.forEach(input => {
            input.addEventListener('input', function () {
                const itemId = this.dataset.itemId;
                const unitPrice = parseFloat(this.dataset.unitPrice);
                let quantity = parseInt(this.value) || 1;

                if (quantity < 1) {
                    quantity = 1;
                    this.value = 1;
                }

                updateTotalPrice(itemId, quantity, unitPrice);
                autoSubmitForm(itemId);
            });

            input.addEventListener('blur', function () {
                let quantity = parseInt(this.value) || 1;
                if (quantity < 1) {
                    this.value = 1;
                    updateTotalPrice(this.dataset.itemId, 1, parseFloat(this.dataset.unitPrice));
                    autoSubmitForm(this.dataset.itemId);
                }
            });
        });
    });

    // Shipping address show hide
    $('.checkout #shipto').change(function () {
        if ($(this).is(':checked')) {
            $('.checkout .shipping-address').slideDown();
        } else {
            $('.checkout .shipping-address').slideUp();
        }
    });


    // Payment methods show hide
    $('.checkout .payment-method .custom-control-input').change(function () {
        if ($(this).prop('checked')) {
            var checkbox_id = $(this).attr('id');
            $('.checkout .payment-method .payment-content').slideUp();
            $('#' + checkbox_id + '-show').slideDown();
        }
    });
})(jQuery);

// Rating stars
document.querySelectorAll('.rating-star').forEach(star => {
    star.addEventListener('click', function () {
        const rating = this.getAttribute('data-rating');
        document.getElementById('rating-value').value = rating;

        // Update star display
        document.querySelectorAll('.rating-star').forEach(s => {
            const starRating = s.getAttribute('data-rating');
            if (starRating <= rating) {
                s.classList.remove('fa-star-o');
                s.classList.add('fa-star');
            } else {
                s.classList.remove('fa-star');
                s.classList.add('fa-star-o');
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const shippingMethod = document.getElementById('shipping-method');
    const shippingCost = document.getElementById('shipping-cost');
    const grandTotal = document.getElementById('grand-total');
    const subTotal = document.getElementById('sub-total').textContent;

    // Payment method show/hide
    const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
    const paymentContents = document.querySelectorAll('.payment-content');

    function calculateTotal() {
        let cost = shippingMethod.value === 'standard' ? 20000 : 35000;
        shippingCost.textContent = cost.toLocaleString() + '₫';
        grandTotal.textContent = (subTotal + cost).toLocaleString() + '₫';
    }

    function togglePaymentContent() {
        paymentContents.forEach(content => {
            content.style.display = 'none';
        });

        const selectedPayment = document.querySelector('input[name="payment_method"]:checked');
        if (selectedPayment) {
            const contentId = selectedPayment.id + '-show';
            const contentElement = document.getElementById(contentId);
            if (contentElement) {
                contentElement.style.display = 'block';
            }
        }
    }

    // Event listeners
    shippingMethod.addEventListener('change', calculateTotal);

    paymentRadios.forEach(radio => {
        radio.addEventListener('change', togglePaymentContent);
    });

    // Initialize
    togglePaymentContent();
});
