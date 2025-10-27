function showAlert(icon, title, text, timer = 3000) {
    Swal.fire({
        icon: icon,
        title: title,
        text: text,
        timer: timer,
        showConfirmButton: false
    });
}

function showValidationErrors(errors) {
    let errorHtml = '';
    errors.forEach(error => {
        errorHtml += `<p>${error}</p>`;
    });

    Swal.fire({
        icon: 'error',
        title: 'Validation Error!',
        html: errorHtml,
        showConfirmButton: true
    });
}

document.addEventListener('DOMContentLoaded', function() {
    if (typeof successMessage !== 'undefined' && successMessage) {
        showAlert('success', 'Success!', successMessage);
    }

    if (typeof errorMessage !== 'undefined' && errorMessage) {
        showAlert('error', 'Error!', errorMessage, 5000);
    }
});
