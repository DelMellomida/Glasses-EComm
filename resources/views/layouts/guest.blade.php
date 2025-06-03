<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

        <!-- Styles -->
        @livewireStyles
        
    </head>
    <body>
        <x-notification />
        <div class="font-sans text-gray-900 antialiased bg-[url('../build/assets/images/LoginWallpaper.jpg')] bg-cover bg-center">
            {{ $slot }}
        </div>

        @livewireScripts

        @php
            $notification = session()->pull('notification');
        @endphp

        @if ($notification)
        <script>
            console.log('Notification script loaded:', @json($notification)); // Pag may error yung json(), okay lng yan
            
            let notificationCount = 0;
            
            document.addEventListener('alpine:init', () => {
                notificationCount++;
                console.log('alpine:init fired, count:', notificationCount);
                
                if (notificationCount === 1) { // Only show on first init
                    setTimeout(() => {
                        if (typeof showNotification === 'function') {
                            console.log('Showing notification:', @json($notification));
                            showNotification(
                                '{{ addslashes($notification["type"] ?? "info") }}',
                                '{{ addslashes($notification["title"] ?? "") }}',
                                '{{ addslashes($notification["message"] ?? "") }}'
                            );
                        } else {
                            console.log('showNotification function not available');
                        }
                    }, 50);
                }
            });
        </script>
        @endif

        <!-- <script>
            function notificationManager() {
                return {
                    notifications: [],
                    notificationId: 0,
                    init() {
                        window.showNotification = this.show.bind(this);
                        window.notificationManager = this;
                    },
                    show(type = 'info', title = '', message = '', options = {}) {
                        const defaultOptions = {
                            duration: 5000,
                            showProgress: true,
                            autoClose: true,
                            ...options
                        };
                        const id = ++this.notificationId;
                        const notification = {
                            id,
                            type,
                            title,
                            message,
                            show: false,
                            progress: 100,
                            showProgress: defaultOptions.showProgress
                        };
                        this.notifications.push(notification);
                        setTimeout(() => {
                            notification.show = true;
                        }, 100);
                        if (defaultOptions.autoClose) {
                            this.startAutoClose(notification, defaultOptions.duration);
                        }
                        return id;
                    },
                    startAutoClose(notification, duration) {
                        const interval = 50;
                        const decrement = (interval / duration) * 100;
                        const progressTimer = setInterval(() => {
                            notification.progress -= decrement;
                            if (notification.progress <= 0) {
                                clearInterval(progressTimer);
                                this.removeNotification(notification.id);
                            }
                        }, interval);
                    },
                    removeNotification(id) {
                        const index = this.notifications.findIndex(n => n.id === id);
                        if (index > -1) {
                            this.notifications[index].show = false;
                            setTimeout(() => {
                                this.notifications.splice(index, 1);
                            }, 300);
                        }
                    },
                    success(title, message = '', options = {}) {
                        return this.show('success', title, message, options);
                    },
                    error(title, message = '', options = {}) {
                        return this.show('error', title, message, options);
                    },
                    info(title, message = '', options = {}) {
                        return this.show('info', title, message, options);
                    },
                    warning(title, message = '', options = {}) {
                        return this.show('warning', title, message, options);
                    },
                    clear() {
                        this.notifications.forEach(notification => {
                            notification.show = false;
                        });
                        setTimeout(() => {
                            this.notifications = [];
                        }, 300);
                    }
                }
            }
        </script> -->
    </body>
</html>

