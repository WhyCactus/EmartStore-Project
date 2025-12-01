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

const NotificationManager = {
    count: 0,
    notifications: [],
    storageKey: 'user_notifications',

    init: function () {
        const $ = window.jQuery;
        if (!$) {
            console.error('jQuery not loaded');
            return;
        }
        this.loadFromStorage();
        this.bindEvents();
        this.loadNotifications();
        this.initRealtime();
    },

    saveToStorage: function () {
        try {
            localStorage.setItem(
                this.storageKey,
                JSON.stringify({
                    notifications: this.notifications,
                    count: this.count,
                    timestamp: Date.now()
                })
            );
        } catch (e) {
            console.log('Could not save to localStorage');
        }
    },

    loadFromStorage: function () {
        try {
            const stored = localStorage.getItem(this.storageKey);
            if (stored) {
                const data = JSON.parse(stored);
                const cacheAge = Date.now() - (data.timestamp || 0);
                if (cacheAge < 24 * 60 * 60 * 1000) {
                    this.notifications = data.notifications || [];
                    this.count = data.count || 0;
                    this.updateBadge();
                    this.render();
                    console.log('Loaded notifications from cache:', this.notifications.length);
                }
            }
        } catch (e) {
            console.log('Could not load from localStorage');
        }
    },

    bindEvents: function () {
        const $ = window.jQuery;
        // Toggle dropdown
        $("#notificationBell").on("click", function (e) {
            e.preventDefault();
            e.stopPropagation();
            $(".notification-menu").toggleClass("show");
        });

        // Close dropdown when clicking outside
        $(document).on("click", function (e) {
            if (!$(e.target).closest(".notification-dropdown").length) {
                $(".notification-menu").removeClass("show");
            }
        });

        // Mark all as read
        $("#markAllRead").on("click", function (e) {
            e.preventDefault();
            NotificationManager.markAllAsRead();
        });

        // Click notification item
        $(document).on("click", ".notification-item", function () {
            const url = $(this).data("url");
            const id = $(this).data("id");

            if (id) {
                NotificationManager.markAsRead(id);
            }

            if (url) {
                window.location.href = url;
            }
        });
    },

    // Load notifications from server
    loadNotifications: function () {
        const $ = window.jQuery;
        $.ajax({
            url: "/notifications",
            method: "GET",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                if (response.success) {
                    NotificationManager.notifications = response.data || [];
                    NotificationManager.count = response.unread_count || 0;
                    NotificationManager.render();
                    NotificationManager.saveToStorage();
                    console.log('Loaded notifications from server:', NotificationManager.notifications.length);
                }
            },
            error: function () {
                console.log("Could not load notifications");
            },
        });
    },

    // Initialize real-time with Pusher/Laravel Echo
    initRealtime: function () {
        if (typeof window.Echo === "undefined") {
            console.log("Laravel Echo not configured");
            return;
        }

        const $ = window.jQuery;
        const userId = $('meta[name="user-id"]').attr("content");
        if (!userId) return;

        console.log('Subscribing to notification channels for user:', userId);

        // Listen to private channel for custom events
        window.Echo.private("user." + userId)
            .listen(".order.notification", function (data) {
                console.log('Received order.notification:', data);
                NotificationManager.handleNewNotification(data);
            })
            .listen(".general.notification", function (data) {
                console.log('Received general.notification:', data);
                NotificationManager.handleNewNotification(data);
            });

        // Listen to Laravel Notification channel (DatabaseNotification broadcasts)
        window.Echo.private("App.Models.User." + userId)
            .notification(function (notification) {
                console.log('Received Laravel notification:', notification);
                NotificationManager.handleNewNotification({
                    id: notification.id,
                    title: notification.title || 'New Notification',
                    message: notification.message || '',
                    type: notification.type || 'info',
                    url: notification.url || '#',
                    time: 'Just now'
                });
            });
    },

    // Handle incoming notification
    handleNewNotification: function (data) {
        // Add to list
        this.notifications.unshift({
            id: data.id || Date.now(),
            title: data.title || "New Notification",
            message: data.message,
            type: data.type || "order",
            time: data.time || "Just now",
            read: false,
            url: data.url || "#",
        });

        // Update count
        this.count++;
        this.updateBadge();
        this.render();

        this.saveToStorage();

        // Show toast with title and message
        this.showToast(data.title || "New Notification", data.message || "");
    },

    // Render notification list
    render: function () {
        const $ = window.jQuery;
        const $list = $("#notificationList");

        if (this.notifications.length === 0) {
            $list.html(`
                <div class="notification-empty">
                    <i class="fa fa-bell-slash"></i>
                    <p>No notifications</p>
                </div>
            `);
        } else {
            let html = "";
            this.notifications.slice(0, 10).forEach(function (item) {
                const iconClass = NotificationManager.getIconClass(item.type);
                const unreadClass = item.read ? "" : "unread";

                html += `
                    <div class="notification-item ${unreadClass}"
                        data-id="${item.id}"
                        data-url="${item.url || "#"}">
                        <div class="icon ${item.type}">
                            <i class="fa ${iconClass}"></i>
                        </div>
                        <div class="content">
                            <div class="title">${item.title}</div>
                            <div class="message">${item.message}</div>
                            <div class="time">${item.time}</div>
                        </div>
                    </div>
                `;
            });
            $list.html(html);
        }

        this.updateBadge();
    },

    // Get icon based on notification type
    getIconClass: function (type) {
        const icons = {
            order: "fa-shopping-cart",
            promo: "fa-tag",
            success: "fa-check-circle",
            warning: "fa-exclamation-triangle",
            info: "fa-info-circle",
        };
        return icons[type] || "fa-bell";
    },

    // Update badge count
    updateBadge: function () {
        const $ = window.jQuery;
        const $badge = $("#notificationCount");
        if (this.count > 0) {
            $badge.text(this.count > 99 ? "99+" : this.count).show();
        } else {
            $badge.hide();
        }
    },

    // Mark single notification as read
    markAsRead: function (id) {
        const $ = window.jQuery;
        const notification = this.notifications.find((n) => n.id == id);
        if (notification && !notification.read) {
            notification.read = true;
            this.count = Math.max(0, this.count - 1);
            this.updateBadge();
            this.saveToStorage();

            // Send to server
            $.ajax({
                url: "/notifications/" + id + "/read",
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });
        }
    },

    // Mark all as read
    markAllAsRead: function () {
        const $ = window.jQuery;
        this.notifications.forEach((n) => (n.read = true));
        this.count = 0;
        this.render();
        this.saveToStorage();

        // Send to server
        $.ajax({
            url: "/notifications/mark-all-read",
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
    },

    // Show toast notification
    showToast: function (title, message) {
        const $ = window.jQuery;
        $("#toastBody").text(message);
        $(".toast-header .me-auto").text(title);
        $("#toastTime").text("Just now");

        const toastEl = document.getElementById("notificationToast");
        if (toastEl) {
            if (typeof bootstrap !== "undefined" && bootstrap.Toast) {
                const toast = new bootstrap.Toast(toastEl, {
                    delay: 5000,
                    autohide: true
                });
                toast.show();
            } else if ($ && typeof $.fn.toast !== "undefined") {
                $("#notificationToast").toast({ delay: 5000 }).toast("show");
                // Manual fallback
                toastEl.classList.add("show");
                setTimeout(function () {
                    toastEl.classList.remove("show");
                }, 5000);
            }
        }
    },

    // Add notification manually (for testing)
    addNotification: function (title, message, type) {
        this.handleNewNotification({
            title: title,
            message: message,
            type: type || "info",
        });
    },
};

window.NotificationManager = NotificationManager;

function initNotificationManager() {
    if (typeof window.jQuery === 'undefined') {
        setTimeout(initNotificationManager, 50);
        return;
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            NotificationManager.init();
        });
    } else {
        NotificationManager.init();
    }
}

initNotificationManager();
