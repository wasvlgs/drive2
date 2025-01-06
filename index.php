<?php

    require_once 'database.php';

    


?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drive & Loc - Car Rental</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .hero-background {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('img/1_24\ LEADING\ IDEAL\ ONE\ SUV\ Alloy\ New\ Energy\ Car\ Model\ Diecast\ Metal\ Toy\ Vehicles\ Car\ Model\ High.jpg');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto flex justify-between items-center py-4 px-6">
            <h1 class="text-3xl font-bold text-blue-600">Drive & Loc</h1>
            <nav class="hidden md:flex space-x-6">
                <a href="#home" class="text-gray-700 hover:text-blue-600 transition">Home</a>
                <a href="pages/explore.php" class="text-gray-700 hover:text-blue-600 transition">Explore</a>
                <a href="#features" class="text-gray-700 hover:text-blue-600 transition">Features</a>
                <a href="#contact" class="text-gray-700 hover:text-blue-600 transition">Contact</a>
            </nav>
            <a href="login/login.php" class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition">Login</a>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="home" class="hero-background relative h-screen flex items-center justify-center text-white">
        <div class="text-center">
            <h1 class="text-6xl font-extrabold mb-6 animate-fade-in">Your Ride, Your Way</h1>
            <p class="text-lg mb-8 max-w-2xl mx-auto">Discover the best cars tailored to your needs. Book effortlessly and enjoy exceptional service.</p>
            <a href="#explore" class="bg-blue-600 hover:bg-blue-700 text-white py-4 px-8 rounded-lg text-lg font-semibold transition">Explore Now</a>
        </div>
    </section>



    <!-- Features Section -->
    <section id="features" class="py-20 bg-white">
        <div class="container mx-auto text-center">
            <h2 class="text-4xl font-bold text-gray-800 mb-12">Why Choose Us?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="bg-gray-100 p-8 rounded-lg shadow-md hover:shadow-xl transition">
                    <i class="fa-regular fa-circle-check text-6xl text-blue-600"></i>
                    <h3 class="text-xl font-bold mb-4 text-blue-600">Wide Selection</h3>
                    <p class="text-gray-600">From luxury to economy, we have the perfect ride for every need.</p>
                </div>
                <div class="bg-gray-100 p-8 rounded-lg shadow-md hover:shadow-xl transition">
                    <i class="fa-solid fa-bolt text-6xl text-blue-600"></i>
                    <h3 class="text-xl font-bold mb-4 text-blue-600">Easy Booking</h3>
                    <p class="text-gray-600">Reserve your car in just a few clicks with our seamless interface.</p>
                </div>
                <div class="bg-gray-100 p-8 rounded-lg shadow-md hover:shadow-xl transition">
                    <i class="fa-solid fa-headset text-6xl text-blue-600"></i>
                    <h3 class="text-xl font-bold mb-4 text-blue-600">24/7 Support</h3>
                    <p class="text-gray-600">Get assistance whenever you need it, day or night.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="bg-blue-600 text-white py-16">
        <div class="container mx-auto text-center">
            <h2 class="text-4xl font-bold mb-6">Get in Touch</h2>
            <p class="text-lg mb-8">Need help? Contact us at <a href="mailto:support@driveandloc.com" class="underline">support@driveandloc.com</a>.</p>
            <form class="max-w-lg mx-auto">
                <input type="text" placeholder="Your Name" class="w-full mb-4 py-3 px-4 rounded-lg text-gray-700">
                <input type="email" placeholder="Your Email" class="w-full mb-4 py-3 px-4 rounded-lg text-gray-700">
                <textarea placeholder="Your Message" class="w-full mb-4 py-3 px-4 rounded-lg text-gray-700"></textarea>
                <button type="submit" class="bg-white text-blue-600 py-3 px-6 rounded-lg font-semibold hover:bg-gray-100 transition">Send Message</button>
            </form>
        </div>
    </section>

    <footer class="bg-gray-900 text-white py-6">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 Drive & Loc. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
