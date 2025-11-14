let variantCount = 0;

const singleProductRadio = document.getElementById('single-product');
const variantProductRadio = document.getElementById('variant-product');
const singleProductSection = document.getElementById('single-product-section');
const variantProductSection = document.getElementById('variant-product-section');
const originalPriceInput = document.getElementById('original-price');
const discountInput = document.getElementById('discount');
const discountedPriceInput = document.getElementById('discounted-price');

function calculateDiscountedPrice() {
    const originalPrice = parseFloat(originalPriceInput.value) || 0;
    const discountPercent = parseFloat(discountInput.value) || 0;

    if (originalPrice > 0 && discountPercent >= 0 && discountPercent <= 100) {
        const discountAmount = (originalPrice * discountPercent) / 100;
        const discountedPrice = originalPrice - discountAmount;
        discountedPriceInput.value = discountedPrice.toFixed(2);
        updateDiscountLabel(discountPercent);
    } else {
        discountedPriceInput.value = '';
        updateDiscountLabel(0);
    }
}

function calculateDiscountPercent() {
    const originalPrice = parseFloat(originalPriceInput.value) || 0;
    const discountedPrice = parseFloat(discountedPriceInput.value) || 0;

    if (originalPrice > 0 && discountedPrice >= 0 && discountedPrice < originalPrice) {
        const discountPercent = ((originalPrice - discountedPrice) / originalPrice) * 100;
        discountInput.value = discountPercent.toFixed(1);

        updateDiscountLabel(discountPercent);
    } else if (discountedPrice >= originalPrice) {
        discountInput.value = '0';
        discountedPriceInput.value = '';
        updateDiscountLabel(0);
    }
}

function updateDiscountLabel(discountPercent) {
    const label = document.getElementById('discount-label');
    if (label) {
        if (discountPercent > 0) {
            label.textContent = `(-${discountPercent.toFixed(0)}% OFF)`;
            label.className = 'text-danger fw-bold';
        } else {
            label.textContent = '';
        }
    }
}

if (originalPriceInput && discountInput && discountedPriceInput) {
    originalPriceInput.addEventListener('input', calculateDiscountedPrice);
    discountInput.addEventListener('input', function() {
        if (parseFloat(this.value) > 100) {
            this.value = 100;
        } else if (parseFloat(this.value) < 0) {
            this.value = 0;
        }
        calculateDiscountedPrice();
    });

    discountedPriceInput.addEventListener('input', calculateDiscountPercent);
}

singleProductRadio.addEventListener('change', function () {
    if (this.checked) {
        singleProductSection.style.display = 'block';
        variantProductSection.style.display = 'none';
    }
});

variantProductRadio.addEventListener('change', function () {
    if (this.checked) {
        singleProductSection.style.display = 'none';
        variantProductSection.style.display = 'block';
    }
});

document.getElementById('add-variant').addEventListener('click', function () {
    const container = document.getElementById('variants-container');
    const variantHTML = `
                <div class="card mb-3 variant-item" data-variant="${variantCount}">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Variant #${variantCount + 1}</span>
                        <button type="button" class="btn btn-sm btn-danger remove-variant">
                            <i class="fas fa-trash"></i> Remove
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Variant SKU</label>
                                <input type="text" name="variants[${variantCount}][sku]" class="form-control" placeholder="SKU">
                            </div>
                            <div class="col-md-6">
                                <label>Variant Price</label>
                                <input type="number" name="variants[${variantCount}][price]" class="form-control" placeholder="Price" step="0.01">
                            </div>
                            <div class="col-md-6">
                                <label>Variant Stock</label>
                                <input type="number" name="variants[${variantCount}][quantity_in_stock]" class="form-control" placeholder="Stock">
                            </div>
                            <div class="col-md-6">
                                <label>Variant Image</label>
                                <input type="file" name="variants[${variantCount}][image]" class="form-control">
                            </div>
                            <div class="col-md-12 mt-3">
                                <label>Attributes</label>
                                <button type="button" class="btn btn-sm btn-info add-attribute" data-variant="${variantCount}">
                                    <i class="fas fa-plus"></i> Add Attribute
                                </button>
                                <div class="attributes-container mt-2" data-variant="${variantCount}"></div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
    container.insertAdjacentHTML('beforeend', variantHTML);
    variantCount++;

    document.querySelector(`[data-variant="${variantCount - 1}"] .remove-variant`).addEventListener('click',
        function () {
            document.querySelector(`[data-variant="${variantCount - 1}"]`).remove();
        });

    document.querySelector(`[data-variant="${variantCount - 1}"] .add-attribute`).addEventListener('click',
        function () {
            addAttribute(variantCount - 1);
        });
});

function addAttribute(variantIndex) {
    const container = document.querySelector(`.attributes-container[data-variant="${variantIndex}"]`);
    const attributeCount = container.querySelectorAll('.attribute-item').length;
    const attributeHTML = `
                <div class="attribute-item mb-2 p-2 border rounded">
                    <div class="row">
                        <div class="col-md-5">
                            <input type="text" name="variants[${variantIndex}][attributes][${attributeCount}][name]" class="form-control" placeholder="Attribute Name (e.g., Color)">
                        </div>
                        <div class="col-md-5">
                            <input type="text" name="variants[${variantIndex}][attributes][${attributeCount}][value]" class="form-control" placeholder="Attribute Value (e.g., Red)">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-sm btn-danger remove-attribute">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
    container.insertAdjacentHTML('beforeend', attributeHTML);

    container.querySelector('.remove-attribute:last-child').addEventListener('click', function () {
        this.closest('.attribute-item').remove();
    });
}

function calculateDiscountPercentage(originalPrice, discountedPrice) {
    if (!originalPrice || originalPrice <= 0) {
        return 0;
    }

    if (!discountedPrice || discountedPrice <= 0 || discountedPrice >= originalPrice) {
        return 0;
    }

    const discount = ((originalPrice - discountedPrice) / originalPrice) * 100;
    return Math.round(discount);
}
