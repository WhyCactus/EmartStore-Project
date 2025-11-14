function toggleSections() {
    const singleProductSection = document.getElementById('single-product-section');
    const variantsSection = document.getElementById('variants-section');

    if (hasVariants) {
        if (singleProductSection) {
            singleProductSection.style.display = 'none';
            singleProductSection.querySelectorAll('input, select, textarea').forEach(field => {
                field.disabled = true;
            });
        }

        if (variantsSection) {
            variantsSection.style.display = 'block';
            variantsSection.querySelectorAll('input, select, textarea').forEach(field => {
                field.disabled = false;
            });
        }
    } else {
        if (singleProductSection) {
            singleProductSection.style.display = 'block';
            singleProductSection.querySelectorAll('input, select, textarea').forEach(field => {
                field.disabled = false;
            });
        }

        if (variantsSection) {
            variantsSection.style.display = 'none';
            variantsSection.querySelectorAll('input, select, textarea').forEach(field => {
                field.disabled = true;
            });
        }
    }
}

document.addEventListener('DOMContentLoaded', function () {
    toggleSections();
    attachRemoveListeners();
});

// Add Variant
document.getElementById('add-variant').addEventListener('click', function () {
    const container = document.getElementById('variants-container');
    const variantItem = document.createElement('div');
    variantItem.className = 'variant-item border p-3 mb-3';
    variantItem.innerHTML = `
                <div class="row">
                    <div class="col-md-3">
                        <label>SKU</label>
                        <input type="text" name="variants[${variantCount}][sku]" class="form-control" placeholder="SKU">
                    </div>
                    <div class="col-md-3">
                        <label>Price</label>
                        <input type="number" name="variants[${variantCount}][price]" class="form-control" step="0.01" placeholder="Price">
                    </div>
                    <div class="col-md-3">
                        <label>Quantity in Stock</label>
                        <input type="number" name="variants[${variantCount}][quantity_in_stock]" class="form-control" placeholder="Stock">
                    </div>
                    <div class="col-md-3">
                        <label>Image</label>
                        <input type="file" name="variants[${variantCount}][image]" class="form-control">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <label><strong>Attributes</strong></label>
                        <div class="attributes-container">
                            <div class="row mb-2">
                                <div class="col-md-5">
                                    <input type="text" name="variants[${variantCount}][attributes][0][name]"
                                        class="form-control" placeholder="Attribute Name (e.g., Color, Size)">
                                </div>
                                <div class="col-md-5">
                                    <input type="text" name="variants[${variantCount}][attributes][0][value]"
                                        class="form-control" placeholder="Attribute Value (e.g., Red, XL)">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger btn-sm remove-attribute">Remove</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary btn-sm add-attribute" data-variant-index="${variantCount}">
                            <i class="fas fa-plus"></i> Add Attribute
                        </button>
                    </div>
                </div>

                <div class="mt-2">
                    <button type="button" class="btn btn-danger btn-sm remove-variant">
                        <i class="fas fa-trash"></i> Remove Variant
                    </button>
                </div>
            `;
    container.appendChild(variantItem);
    attributeCount[variantCount] = 1;
    variantCount++;
    attachRemoveListeners();
});

// Add Attribute
document.addEventListener('click', function (e) {
    if (e.target.classList.contains('add-attribute') || e.target.closest('.add-attribute')) {
        const btn = e.target.classList.contains('add-attribute') ? e.target : e.target.closest('.add-attribute');
        const variantIndex = btn.getAttribute('data-variant-index');
        const attributesContainer = btn.previousElementSibling;

        if (!attributeCount[variantIndex]) {
            attributeCount[variantIndex] = attributesContainer.querySelectorAll('.row').length;
        }

        const attrRow = document.createElement('div');
        attrRow.className = 'row mb-2';
        attrRow.innerHTML = `
                    <div class="col-md-5">
                        <input type="text" name="variants[${variantIndex}][attributes][${attributeCount[variantIndex]}][name]"
                            class="form-control" placeholder="Attribute Name (e.g., Color, Size)">
                    </div>
                    <div class="col-md-5">
                        <input type="text" name="variants[${variantIndex}][attributes][${attributeCount[variantIndex]}][value]"
                            class="form-control" placeholder="Attribute Value (e.g., Red, XL)">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-sm remove-attribute">Remove</button>
                    </div>
                `;
        attributesContainer.appendChild(attrRow);
        attributeCount[variantIndex]++;
        attachRemoveListeners();
    }
});

// Remove Variant and Attribute
function attachRemoveListeners() {
    document.querySelectorAll('.remove-variant').forEach(btn => {
        btn.removeEventListener('click', removeVariant);
        btn.addEventListener('click', removeVariant);
    });

    document.querySelectorAll('.remove-attribute').forEach(btn => {
        btn.removeEventListener('click', removeAttribute);
        btn.addEventListener('click', removeAttribute);
    });
}

function removeVariant(e) {
    e.preventDefault();
    const variantItem = this.closest('.variant-item');
    if (variantItem) {
        variantItem.remove();
    }
}

function removeAttribute(e) {
    e.preventDefault();
    const attrRow = this.closest('.row.mb-2');
    if (attrRow) {
        attrRow.remove();
    }
}
