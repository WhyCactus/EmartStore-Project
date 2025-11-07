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

document.addEventListener('DOMContentLoaded', function () {
    setTimeout(function () {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function (alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
});

let variantCount = 0;

// Toggle between variant and non-variant
function toggleVariantType() {
    const hasVariant = document.getElementById('has_variant').checked;
    const variantsSection = document.getElementById('variantsSection');
    const singleProductFields = document.getElementById('singleProductFields');

    if (hasVariant) {
        // Show variants section, hide single product fields
        variantsSection.classList.remove('d-none');
        singleProductFields.classList.add('d-none');

        // Disable single product fields
        document.getElementById('single-sku').disabled = true;
        document.getElementById('single-quantity').disabled = true;

        // Add first variant if none exists
        if (variantCount === 0) {
            addVariant();
        }
    } else {
        // Hide variants section, show single product fields
        variantsSection.classList.add('d-none');
        singleProductFields.classList.remove('d-none');

        // Enable single product fields
        document.getElementById('single-sku').disabled = false;
        document.getElementById('single-quantity').disabled = false;

        // Auto-generate SKU for single product
        const productCode = document.getElementById('product-code').value;
        const skuInput = document.getElementById('single-sku');
        if (productCode && !skuInput.value) {
            skuInput.value = productCode;
        }
    }
}

// Image preview function
function previewImage(input) {
    const preview = document.getElementById('imagePreview');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }

        reader.readAsDataURL(input.files[0]);
    } else {
        preview.style.display = 'none';
    }
}

// Calculate discounted price
function calculateDiscountedPrice() {
    const originalPrice = parseFloat(document.getElementById('original-price').value) || 0;
    const discountPercent = parseFloat(document.getElementById('discount').value) || 0;

    if (originalPrice > 0 && discountPercent > 0) {
        const discountedPrice = originalPrice * (1 - discountPercent / 100);
        document.getElementById('discounted-price').value = discountedPrice.toFixed(2);
    } else {
        document.getElementById('discounted-price').value = '';
    }
}

// Add variant
function addVariant() {
    const template = document.getElementById('variantTemplate');
    const variantElement = template.content.cloneNode(true);
    const variantItem = variantElement.querySelector('.variant-item');

    // Update all inputs with current variant count
    const inputs = variantItem.querySelectorAll('input, select');
    inputs.forEach(input => {
        if (input.name) {
            input.name = input.name.replace('[0]', `[${variantCount}]`);
        }
    });

    // Update variant number
    variantItem.querySelector('.variant-number').textContent = variantCount + 1;

    // Auto-generate SKU
    const productCode = document.getElementById('product-code').value;
    const skuInput = variantItem.querySelector('.variant-sku');
    if (productCode) {
        skuInput.value = `${productCode}-V${variantCount + 1}`;
    }

    // Set variant price from main product price
    const mainPrice = parseFloat(document.getElementById('original-price').value);
    if (mainPrice > 0) {
        variantItem.querySelector('.variant-price').value = mainPrice;
    }

    document.getElementById('variantsContainer').appendChild(variantItem);
    variantCount++;
}

// Remove variant
function removeVariant(button) {
    const variantItem = button.closest('.variant-item');
    variantItem.remove();
    updateVariantNumbers();
}

// Update variant numbers after removal
function updateVariantNumbers() {
    const variants = document.querySelectorAll('.variant-item');
    variants.forEach((variant, index) => {
        variant.querySelector('.variant-number').textContent = index + 1;
    });
}

// Auto-generate SKU when product code changes
document.getElementById('product-code').addEventListener('input', function () {
    const productCode = this.value;
    const hasVariant = document.getElementById('has_variant').checked;

    if (!hasVariant) {
        // For single products
        const skuInput = document.getElementById('single-sku');
        if (productCode && !skuInput.value) {
            skuInput.value = productCode;
        }
    } else {
        // For variant products
        const skuInputs = document.querySelectorAll('.variant-sku');
        skuInputs.forEach((input, index) => {
            if (productCode && (!input.value || input.value.startsWith(productCode + '-'))) {
                input.value = `${productCode}-V${index + 1}`;
            }
        });
    }
});

// Auto-update variant prices when main price changes
document.getElementById('original-price').addEventListener('input', function () {
    const mainPrice = parseFloat(this.value) || 0;
    const priceInputs = document.querySelectorAll('.variant-price');

    priceInputs.forEach(input => {
        if (mainPrice > 0 && !input.value) {
            input.value = mainPrice;
        }
    });
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function () {
    toggleVariantType(); // Set initial state

    // Auto-generate SKU for single product
    const productCode = document.getElementById('product-code').value;
    const skuInput = document.getElementById('single-sku');
    if (productCode && !skuInput.value) {
        skuInput.value = productCode;
    }

    // Calculate initial discounted price
    calculateDiscountedPrice();
});
