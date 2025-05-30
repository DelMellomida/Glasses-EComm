<script>
    function notificationManager() {
        return {
            notifications: [],
            notificationId: 0,

            init() {
                // Make this globally accessible
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

                // Fix: Use proper reference handling
                setTimeout(() => {
                    // Find the notification in the array to ensure we have the right reference
                    const currentNotification = this.notifications.find(n => n.id === id);
                    if (currentNotification) {
                        currentNotification.show = true;
                        if (defaultOptions.autoClose) {
                            this.startAutoClose(currentNotification, defaultOptions.duration);
                        }
                    }
                }, 10);

                return id;
            },

            startAutoClose(notification, duration) {
                const interval = 50;
                const decrement = (interval / duration) * 100;

                const progressTimer = setInterval(() => {
                    // Find current notification to ensure we have the right reference
                    const currentNotification = this.notifications.find(n => n.id === notification.id);
                    if (currentNotification) {
                        currentNotification.progress -= decrement;
                        if (currentNotification.progress <= 0) {
                            clearInterval(progressTimer);
                            this.removeNotification(notification.id);
                        }
                    } else {
                        // Notification was removed, clear the timer
                        clearInterval(progressTimer);
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

            // Convenience methods
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
</script>

<div x-data="notificationManager()" x-init="init()" class="fixed top-4 right-4 space-y-4" style="z-index:9999;">
    <template x-for="notification in notifications" :key="notification.id">
        <div x-show="notification.show" 
             x-transition:enter="transform ease-out duration-300 transition"
             x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
             x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="max-w-xs w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
            
            <div class="p-4 flex items-start">
                <!-- Icon -->
                <div class="flex-shrink-0 mt-1">
                    <div :class="{
                        'bg-green-100': notification.type === 'success',
                        'bg-red-100': notification.type === 'error',
                        'bg-blue-100': notification.type === 'info',
                        'bg-yellow-100': notification.type === 'warning'
                    }" class="w-8 h-8 rounded-full flex items-center justify-center">
                        <!-- Icons as before -->
                        <template x-if="notification.type === 'success'">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </template>
                        <template x-if="notification.type === 'error'">
                            <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </template>
                        <template x-if="notification.type === 'info'">
                            <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                        </template>
                        <template x-if="notification.type === 'warning'">
                            <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        </template>
                    </div>
                </div>
                <!-- Content -->
                <div class="ml-3 flex-1">
                    <p class="text-sm font-semibold text-gray-900 break-words" x-text="notification.title"></p>
                    <p class="mt-1 text-sm text-gray-600 break-words" x-text="notification.message" x-show="notification.message"></p>
                </div>
                <!-- Close Button -->
                <div class="ml-4 flex-shrink-0 flex">
                    <button @click="removeNotification(notification.id)" 
                            class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <span class="sr-only">Close</span>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <!-- Progress Bar -->
            <div x-show="notification.showProgress" class="bg-gray-50 px-4 py-2">
                <div class="w-full bg-gray-200 rounded-full h-1">
                    <div :class="{
                        'bg-green-500': notification.type === 'success',
                        'bg-red-500': notification.type === 'error', 
                        'bg-blue-500': notification.type === 'info',
                        'bg-yellow-500': notification.type === 'warning'
                    }" 
                    class="h-1 rounded-full transition-all duration-100 ease-linear" 
                    :style="`width: ${notification.progress}%`"></div>
                </div>
            </div>
        </div>
    </template>
</div>