<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Manager - Secure Your Digital Life</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 font-sans">
    <!-- Success Message -->
    @if(session('success'))
        <div id="success-message" class="fixed top-4 right-4 z-50 bg-green-600 text-white px-6 py-4 rounded-lg shadow-2xl animate-fade-in">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 mr-2 animate-bounce" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
                <button onclick="dismissMessage()" class="ml-4 hover:text-green-100 transition-transform hover:scale-110">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-40">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-2 transform hover:scale-105 transition-all duration-300">
                <svg class="w-8 h-8 text-blue-600 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                <span class="text-2xl font-bold text-gray-900">Password Manager</span>
            </div>
            <div class="flex space-x-4">
                <a href="{{ route('login') }}" class="px-4 py-2 text-gray-700 hover:text-gray-900 transition-all hover:scale-105">Login</a>
                <a href="{{ route('register') }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all transform hover:scale-110 shadow-md hover:shadow-lg">
                    Get Started
                </a>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
<section class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 overflow-hidden">
    <!-- Background animated glow circles -->
    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-[800px] h-[800px] bg-blue-300 rounded-full filter blur-3xl opacity-30 animate-blob"></div>
    <div class="absolute bottom-0 right-1/4 w-[600px] h-[600px] bg-indigo-400 rounded-full filter blur-2xl opacity-20 animate-blob animation-delay-2000"></div>

    <div class="relative text-center space-y-6">
        <!-- Headline -->
        <h1 class="text-5xl sm:text-6xl md:text-7xl font-extrabold text-gray-900 mb-6 relative z-10">
            <span class="bg-gradient-to-r from-blue-500 to-indigo-600 bg-clip-text text-transparent animate-gradient-text">
                Securely Store All Your Passwords
            </span><br>
            <span class="text-blue-600">In One Place</span>
        </h1>

        <!-- Subtitle -->
        <p class="text-xl sm:text-2xl text-gray-600 max-w-3xl mx-auto z-10 opacity-0 animate-fade-in-up-delay">
            Enterprise-grade encryption, zero-trust architecture, and military-level security for your digital credentials.
        </p>

        <!-- CTA Buttons -->
        <div class="flex justify-center space-x-3 mt-8 z-10">
            <a href="{{ route('register') }}"
               class=" m-10 px-8 py-4 bg-blue-600 text-black rounded-lg text-lg font-semibold shadow-lg transform hover:scale-110 hover:shadow-2xl transition-all relative overflow-hidden group">
                <span class="relative z-10 animate-bounce-slow">Start Free Today</span>
                <span class="absolute inset-0 bg-white opacity-10 rounded-lg blur-xl transform scale-110 group-hover:scale-125 transition-all"></span>
            </a>
            <a href="#features"
               class="px-8 py-4 bg-white text-black rounded-lg text-lg font-semibold shadow-lg hover:shadow-xl hover:bg-gray-50 transition-all">
                Learn More
            </a>
        </div>
    </div>
</section>

<style>
/* Headline gradient animation */
@keyframes gradient-text {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}
.animate-gradient-text {
    background-size: 200% 200%;
    animation: gradient-text 6s ease infinite;
}

/* Fade-in with delay */
@keyframes fade-in-up-delay {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in-up-delay {
    animation: fade-in-up-delay 1.2s ease forwards;
    animation-delay: 0.5s;
}

/* Bounce slow for buttons */
@keyframes bounce-slow {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-8%); }
}
.animate-bounce-slow { animation: bounce-slow 2s infinite; }

/* Floating blob animation */
@keyframes blob {
    0% { transform: translate(0px, 0px) scale(1); }
    33% { transform: translate(30px, -50px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
    100% { transform: translate(0px, 0px) scale(1); }
}
.animate-blob { animation: blob 8s infinite; }
.animation-delay-2000 { animation-delay: 2s; }
</style>


    <!-- Features Section -->
<section id="features" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <h2 class="text-3xl font-bold text-center text-gray-900 mb-12 animate-fade-in">Why Choose Our Password Manager?</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Feature 1 -->
        <div class="feature-card bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition-all transform hover:scale-105 animate-fade-in-up delay-100">
            <div class="icon-wrapper bg-blue-100 w-16 h-16 rounded-lg flex items-center justify-center mb-4 animate-pulse">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">AES-256 Encryption</h3>
            <p class="text-gray-600">Military-grade encryption ensures your passwords are always secure. We never store passwords in plain text.</p>
        </div>

        <!-- Feature 2 -->
        <div class="feature-card bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition-all transform hover:scale-105 animate-fade-in-up delay-200">
            <div class="icon-wrapper bg-green-100 w-16 h-16 rounded-lg flex items-center justify-center mb-4 animate-bounce">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Two-Factor Authentication</h3>
            <p class="text-gray-600">Add an extra layer of security with 2FA. Protect your vault from unauthorized access.</p>
        </div>

        <!-- Feature 3 -->
        <div class="feature-card bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition-all transform hover:scale-105 animate-fade-in-up delay-300">
            <div class="icon-wrapper bg-purple-100 w-16 h-16 rounded-lg flex items-center justify-center mb-4 animate-spin-slow">
                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Password Generator</h3>
            <p class="text-gray-600">Generate strong, unique passwords instantly. Customize length and complexity to meet any requirement.</p>
        </div>

        <!-- Feature 4 -->
        <div class="feature-card bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition-all transform hover:scale-105 animate-fade-in-up delay-400">
            <div class="icon-wrapper bg-yellow-100 w-16 h-16 rounded-lg flex items-center justify-center mb-4 animate-bounce-slow">
                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Auto-Fill Login</h3>
            <p class="text-gray-600">Seamlessly auto-fill login forms on your favorite websites, saving you time and hassle.</p>
        </div>

        <!-- Feature 5 -->
        <div class="feature-card bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition-all transform hover:scale-105 animate-fade-in-up delay-500">
            <div class="icon-wrapper bg-pink-100 w-16 h-16 rounded-lg flex items-center justify-center mb-4 animate-pulse">
                <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v4a4 4 0 004 4h10a4 4 0 004-4V7m-6 10v2m-4-2v2m-4-2v2"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Secure Cloud Backup</h3>
            <p class="text-gray-600">Never lose your passwords. Encrypted cloud backup keeps your data safe and accessible from anywhere.</p>
        </div>

        <!-- Feature 6 -->
        <div class="feature-card bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition-all transform hover:scale-105 animate-fade-in-up delay-600">
            <div class="icon-wrapper bg-indigo-100 w-16 h-16 rounded-lg flex items-center justify-center mb-4 animate-spin-slow">
                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Breach Alerts</h3>
            <p class="text-gray-600">Get instant alerts if any of your credentials appear in a data breach, so you can act immediately.</p>
        </div>
    </div>
</section>

<style>
/* Advanced Animations */
@keyframes fade-in-up {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes spin-slow {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
@keyframes bounce-slow {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-15%); }
}

.animate-fade-in-up { animation: fade-in-up 0.8s ease forwards; }
.animate-spin-slow { animation: spin-slow 5s linear infinite; }
.animate-bounce-slow { animation: bounce-slow 2s infinite; }
.animate-pulse { animation: pulse 2s infinite; }
</style>

    <!-- CTA Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl shadow-2xl p-12 text-center text-white">
            <h2 class="text-4xl font-bold mb-4">Ready to Secure Your Digital Life?</h2>
            <p class="text-xl mb-8 opacity-90">Join thousands of users who trust us with their passwords</p>
            <a href="{{ route('register') }}" class="inline-block px-8 py-4 bg-white text-blue-600 rounded-lg text-lg font-semibold hover:bg-gray-100 transition shadow-lg transform hover:scale-105">
                Create Free Account
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center text-gray-600">
                <p>&copy; 2026 Password Manager. All rights reserved.</p>
                <p class="mt-2 text-sm">Built with Laravel & Tailwind CSS</p>
            </div>
        </div>
    </footer>

    <script>
        // Make functions globally available
        window.dismissMessage = function() {
            const element = document.getElementById('success-message');
            if (element) {
                element.style.transition = 'opacity 0.3s ease-out, transform 0.3s ease-out';
                element.style.opacity = '0';
                element.style.transform = 'translateY(-20px)';
                setTimeout(() => element.remove(), 300);
            }
        };
        
        if (document.getElementById('success-message')) {
            setTimeout(dismissMessage, 5000);
        }

        // Demo Functions
        window.demoRevealPassword = function(cardNum) {
            const revealDiv = document.getElementById(`password-reveal-${cardNum}`);
            if (revealDiv) {
                if (revealDiv.classList.contains('hidden')) {
                    revealDiv.classList.remove('hidden');
                    revealDiv.style.animation = 'slideDown 0.3s ease-out';
                } else {
                    revealDiv.classList.add('hidden');
                }
            }
        };

        window.demoCopyPassword = function(cardNum) {
            const button = event.currentTarget;
            const originalHTML = button.innerHTML;
            
            // Show success feedback
            button.innerHTML = `
                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
            `;
            button.classList.add('bg-green-100');
            
            // Show toast notification
            showToast('Password copied to clipboard!');
            
            // Reset after 2 seconds
            setTimeout(() => {
                button.innerHTML = originalHTML;
                button.classList.remove('bg-green-100');
            }, 2000);
        };

        function showToast(message) {
            const toast = document.createElement('div');
            toast.className = 'fixed bottom-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg z-50';
            toast.innerHTML = `
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span>${message}</span>
                </div>
            `;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.style.transition = 'opacity 0.3s ease-out';
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }, 2000);
        }

        window.playDemo = function() {
            console.log('Play Demo clicked!');
            const button = document.getElementById('play-demo-btn');
            
            if (!button) {
                console.error('Button not found!');
                return;
            }
            
            button.disabled = true;
            button.classList.add('opacity-75', 'cursor-not-allowed');
            button.innerHTML = '<span class="flex items-center justify-center space-x-2"><span>Demo Running...</span></span>';
            
            // Reset all cards first
            for (let i = 1; i <= 3; i++) {
                const reveal = document.getElementById(`password-reveal-${i}`);
                if (reveal && !reveal.classList.contains('hidden')) {
                    reveal.classList.add('hidden');
                }
            }
            
            // Animated demo sequence
            setTimeout(() => {
                // Highlight card 1
                const card1 = document.getElementById('demo-card-1');
                card1.classList.add('ring-4', 'ring-blue-500');
                card1.scrollIntoView({ behavior: 'smooth', block: 'center' });
                
                setTimeout(() => {
                    card1.classList.remove('ring-4', 'ring-blue-500');
                    demoRevealPassword(1);
                    
                    setTimeout(() => {
                        // Highlight card 2
                        const card2 = document.getElementById('demo-card-2');
                        card2.classList.add('ring-4', 'ring-green-500');
                        
                        setTimeout(() => {
                            card2.classList.remove('ring-4', 'ring-green-500');
                            demoRevealPassword(2);
                            
                            setTimeout(() => {
                                // Highlight card 3
                                const card3 = document.getElementById('demo-card-3');
                                card3.classList.add('ring-4', 'ring-purple-500');
                                
                                setTimeout(() => {
                                    card3.classList.remove('ring-4', 'ring-purple-500');
                                    demoRevealPassword(3);
                                    
                                    setTimeout(() => {
                                        // Reset button
                                        button.disabled = false;
                                        button.classList.remove('opacity-75', 'cursor-not-allowed');
                                        button.innerHTML = `
                                            <span class="flex items-center justify-center space-x-2">
                                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span>Play Interactive Demo</span>
                                            </span>
                                        `;
                                        showToast('Demo completed! Try clicking the buttons yourself.');
                                    }, 1000);
                                }, 1000);
                            }, 1000);
                        }, 1000);
                    }, 1500);
                }, 1000);
            }, 500);
        };

        // Add slide down animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideDown {
                from {
                    opacity: 0;
                    transform: translateY(-10px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        `;
        document.head.appendChild(style);
        
        console.log('Demo functions loaded successfully');
    </script>
</body>
</html>
