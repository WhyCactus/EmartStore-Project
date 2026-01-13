@extends('client.layouts.app')

@section('title', 'Chat with Support')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h4>Chat Support</h4>
                    </div>
                    <div class="card-body" style="height: 400px; overflow-y: auto;" id="messages">
                        <!-- Messages will load here -->
                    </div>
                    <div class="card-footer">
                        <form id="message-form">
                            <div class="input-group">
                                <input type="text" id="message-input" class="form-control"
                                    placeholder="Type your message..." autocomplete="off">
                                <button type="submit" class="btn btn-primary">Send</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.15.1/dist/echo.iife.js"></script>

    <script>
        // Configure Pusher
        Pusher.logToConsole = true;

        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: '{{ config('broadcasting.connections.pusher.key') }}',
            cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
            forceTLS: true,
            encrypted: true
        });

        document.addEventListener('DOMContentLoaded', function() {
            const messagesElement = document.getElementById('messages');
            const messageForm = document.getElementById('message-form');
            const messageInput = document.getElementById('message-input');

            // Load existing messages
            axios.get('/messages').then(response => {
                response.data.forEach(message => {
                    addMessage(message, false);
                });
                // Scroll to bottom
                messagesElement.scrollTop = messagesElement.scrollHeight;
            }).catch(error => {
                console.error('Error loading messages:', error);
            });

            // Listen for new messages in real-time
            window.Echo.channel('chat')
                .listen('MessageSent', (data) => {
                    console.log('New message:', data);
                    addMessage(data.message, true);
                    messagesElement.scrollTop = messagesElement.scrollHeight;
                });

            // Add message to UI
            function addMessage(message, isNew = false) {
                const messageElement = document.createElement('div');
                messageElement.className = 'mb-3 p-2 border-bottom';

                const isOwnMessage = message.user_id === {{ auth()->id() ?? 0 }};
                const alignment = isOwnMessage ? 'text-end' : 'text-start';
                const bgColor = isOwnMessage ? 'bg-info text-white' : 'bg-light';

                messageElement.innerHTML = `
                    <div class="${alignment}">
                        <strong>${message.user?.name || 'Unknown'}</strong>
                        <small class="text-muted">${new Date(message.created_at).toLocaleTimeString()}</small>
                    </div>
                    <div class="p-2 rounded ${bgColor} d-inline-block mt-1">
                        ${message.message}
                    </div>
                `;

                messagesElement.appendChild(messageElement);
            }

            // Send message
            messageForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const messageText = messageInput.value.trim();
                if (!messageText) return;

                axios.post('/messages', {
                    message: messageText
                }).then(response => {
                    messageInput.value = '';
                    messageInput.focus();
                }).catch(error => {
                    console.error('Error sending message:', error);
                    alert('Failed to send message');
                });
            });
        });
    </script>
@endsection
