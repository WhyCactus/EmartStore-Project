window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
            document.body.classList.toggle('sb-sidenav-toggled');
        }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

});

document.addEventListener('DOMContentLoaded', () => {
    const originalPriceInput = document.getElementById('original-price');
    const discountInput = document.getElementById('discount');
    const discountedPriceInput = document.getElementById('discounted-price');

    function calculateDiscountPercentage(originalPrice, discountedPrice) {
        if (originalPrice && discountedPrice && originalPrice > discountedPrice) {
            return ((originalPrice - discountedPrice) / originalPrice) * 100;
        }
        return 0;
    }

    function calculateDiscountedPrice(originalPrice, discount) {
        return originalPrice * (1 - discount / 100);
    }

    function validateAndCalculate() {
        const originalPrice = parseFloat(originalPriceInput.value);
        const discount = parseFloat(discountInput.value);

        originalPriceInput.classList.remove('is-invalid', 'is-valid');
        discountInput.classList.remove('is-invalid', 'is-valid');
        discountedPriceInput.classList.remove('is-invalid', 'is-valid');

        let isValid = true;

        if (!originalPrice || originalPrice <= 0) {
            originalPriceInput.classList.add('is-invalid');
            isValid = false;
        } else {
            originalPriceInput.classList.add('is-valid');
        }

        if (isNaN(discount)) {
            discountInput.classList.add('is-invalid');
            isValid = false;
        } else if (discount < 0) {
            discountInput.classList.add('is-invalid');
            isValid = false;
        } else if (discount > 100) {
            discountInput.classList.add('is-invalid');
            isValid = false;
        } else {
            discountInput.classList.add('is-valid');
        }

        if (isValid) {
            const discountedPrice = calculateDiscountedPrice(originalPrice, discount);
            discountedPriceInput.value = Math.round(discountedPrice);
            discountedPriceInput.classList.add('is-valid');
        } else {
            discountedPriceInput.value = '';
            discountedPriceInput.classList.remove('is-valid');
        }
    }

    function calculateFromDiscountedPrice() {
        const originalPrice = parseFloat(originalPriceInput.value);
        const discountedPrice = parseFloat(discountedPriceInput.value);

        originalPriceInput.classList.remove('is-invalid', 'is-valid');
        discountInput.classList.remove('is-invalid', 'is-valid');
        discountedPriceInput.classList.remove('is-invalid', 'is-valid');

        let isValid = true;

        if (!originalPrice || originalPrice <= 0) {
            originalPriceInput.classList.add('is-invalid');
            isValid = false;
        } else {
            originalPriceInput.classList.add('is-valid');
        }

        if (isNaN(discountedPrice) || discountedPrice < 0) {
            discountedPriceInput.classList.add('is-invalid');
            isValid = false;
        } else if (discountedPrice > originalPrice) {
            discountedPriceInput.classList.add('is-invalid');
            isValid = false;
        } else {
            discountedPriceInput.classList.add('is-valid');
        }

        if (isValid) {
            const discountPercentage = calculateDiscountPercentage(originalPrice, discountedPrice);
            discountInput.value = discountPercentage.toFixed(1);
            discountInput.classList.add('is-valid');
        } else {
            discountInput.value = '';
            discountInput.classList.remove('is-valid');
        }
    }

    originalPriceInput.addEventListener('input', validateAndCalculate);
    discountInput.addEventListener('input', validateAndCalculate);

    discountedPriceInput.addEventListener('input', calculateFromDiscountedPrice);

    if (originalPriceInput.value && discountedPriceInput.value) {
        calculateFromDiscountedPrice();
    }
});
