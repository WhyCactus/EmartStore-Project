// Listen for real-time notifications
document.addEventListener('DOMContentLoaded', function () {
    // Check if user is authenticated
    const userId = document.querySelector('meta[name="user-id"]')?.content;

    if (!userId || !window.Echo) {
        console.log('User not authenticated or Echo not initialized');
        return;
    }

    // Subscribe to private channel for user notifications
    window.Echo.private(`user.${userId}`)
        .listen('.order.notification', (data) => {
            console.log('Order notification received:', data);

            // Display notification
            showNotification(data);

            updateOrderBadge();
        });
});

function showNotification(data) {
    // Create a notification element
    const notification = document.createElement('div');
    notification.className = 'alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3';
    notification.style.zIndex = '9999';
    notification.innerHTML = `
        <strong>${data.title || 'Notification'}</strong>
        <p class="mb-0">${data.message || 'You have a new notification'}</p>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    document.body.appendChild(notification);

    // Auto remove after 5 seconds
    setTimeout(() => {
        notification.remove();
    }, 5000);

    // Show browser notification if supported and permitted
    if ('Notification' in window && Notification.permission === 'granted') {
        new Notification(data.title || 'New Notification', {
            body: data.message || 'You have a new notification',
            icon: '/img/logo.png' // Update with your logo path
        });
    }
}

function updateOrderBadge() {
    // Update badge count if you have one
    const badge = document.querySelector('.order-badge');
    if (badge) {
        const currentCount = parseInt(badge.textContent) || 0;
        badge.textContent = currentCount + 1;
    }
}

// Request notification permission on page load
if ('Notification' in window && Notification.permission === 'default') {
    Notification.requestPermission();
}
