<?php include 'header.php'; ?>

<main>
    <!-- Contact Hero -->
    <section class="relative h-[60vh] flex items-center overflow-hidden bg-black">
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-gradient-to-r from-black via-black/60 to-transparent z-10"></div>
            <img src="assets/images/lifestyle_shoes.jpg" alt="Contact Us" class="w-full h-full object-cover object-center opacity-50 scale-110 animate-pulse-slow">
        </div>
        
        <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="max-w-3xl space-y-8">
                <h1 class="text-6xl md:text-8xl font-black text-white uppercase tracking-tighter leading-none">
                    Get in <br> <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-gray-500">Touch</span>
                </h1>
                <p class="text-xl text-gray-300 font-medium max-w-lg">
                    We'd love to hear from you. Send us a message and we'll get back to you soon.
                </p>
            </div>
        </div>
    </section>

    <!-- Contact Form & Info -->
    <section class="py-32 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-20">
                <!-- Contact Form -->
                <div class="space-y-8">
                    <div>
                        <h2 class="text-4xl font-black uppercase tracking-tighter mb-6">Send us a Message</h2>
                        <p class="text-gray-600 text-lg">Have a question about our products or need assistance? We're here to help.</p>
                    </div>

                    <form class="space-y-6" id="contactForm" action="process_contact.php" method="POST">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold uppercase tracking-widest text-gray-400 mb-2">Full Name</label>
                                <input type="text" name="name" required class="w-full bg-gray-50 border-none rounded-xl px-4 py-4 text-lg focus:ring-2 focus:ring-black transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-bold uppercase tracking-widest text-gray-400 mb-2">Email Address</label>
                                <input type="email" name="email" required class="w-full bg-gray-50 border-none rounded-xl px-4 py-4 text-lg focus:ring-2 focus:ring-black transition-all">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold uppercase tracking-widest text-gray-400 mb-2">Subject</label>
                            <input type="text" name="subject" required class="w-full bg-gray-50 border-none rounded-xl px-4 py-4 text-lg focus:ring-2 focus:ring-black transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-bold uppercase tracking-widest text-gray-400 mb-2">Message</label>
                            <textarea name="message" rows="6" required class="w-full bg-gray-50 border-none rounded-xl px-4 py-4 text-lg focus:ring-2 focus:ring-black transition-all resize-none"></textarea>
                        </div>
                        <button type="submit" class="bg-black text-white px-10 py-5 rounded-full font-bold text-lg hover:bg-gray-900 transition-all transform hover:scale-105">Send Message</button>
                    </form>
                </div>

                <!-- Contact Info -->
                <div class="space-y-10">
                    <div>
                        <h2 class="text-4xl font-black uppercase tracking-tighter mb-6">Contact Information</h2>
                        <p class="text-gray-600 text-lg">Reach out to us through any of these channels.</p>
                    </div>

                    <div class="space-y-8">
                        <div class="flex gap-6">
                            <div class="flex-shrink-0 w-14 h-14 bg-black text-white rounded-2xl flex items-center justify-center">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold">Email</h4>
                                <p class="text-gray-600">yankicks.support@gmail.com</p>
                            </div>
                        </div>

                        <div class="flex gap-6">
                            <div class="flex-shrink-0 w-14 h-14 bg-black text-white rounded-2xl flex items-center justify-center">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold">Phone</h4>
                                <p class="text-gray-600">+63 999 473 7196</p>
                            </div>
                        </div>

                        <div class="flex gap-6">
                            <div class="flex-shrink-0 w-14 h-14 bg-black text-white rounded-2xl flex items-center justify-center">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold">Address</h4>
                                <p class="text-gray-600">360 San Agustin Village<br>Binan, Laguna<br>Philippines</p>
                            </div>
                        </div>

                        <div class="flex gap-6">
                            <div class="flex-shrink-0 w-14 h-14 bg-black text-white rounded-2xl flex items-center justify-center">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold">Business Hours</h4>
                                <p class="text-gray-600">Monday - Friday: 9AM - 6PM<br>Saturday: 10AM - 4PM<br>Sunday: Closed</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>