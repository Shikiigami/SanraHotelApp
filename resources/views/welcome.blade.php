<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PSU - Sanrafael Hotel PMS</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="relative h-screen w-screen">

  <!-- Background Image with Gradient Overlay -->
  <div class="absolute inset-0">
    <img src="{{ asset('assets/roomImages/login_image.png') }}" 
         alt="Hotel Background" 
         class="w-full h-full object-cover">
    <div class="absolute inset-0 bg-gradient-to-b from-black/60 to-black/60"></div>
  </div>

  <!-- Content -->
  <div class="relative z-10 flex flex-col justify-center items-center h-full text-center px-4">
    <h1 class="text-white text-4xl md:text-6xl font-bold mb-4">Welcome to PSU - Sanrafael Hotel</h1>
    <p class="text-white text-xl md:text-2xl">Hospitality Management Hostel PMS</p>
    <a href="{{ route('login')}}" class="mt-8 px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg transition duration-300">
      Get Started
    </a>
  </div>
</body>
</html>
