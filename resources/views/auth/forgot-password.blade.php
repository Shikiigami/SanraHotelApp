{{-- resources/views/auth/forgot-password.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Forgot Password | Hospitality Management PMS</title>

  <script src="{{ asset('assets/js/tailwindcss.js') }}"></script>
  <script src="{{ asset('assets/js/lucide2.js') }}"></script>

  <link rel="icon" type="image/png" href="{{ asset('assets/roomImages/psu_logo.jpg') }}">
</head>

<body class="min-h-screen flex items-center justify-center relative bg-cover bg-center bg-no-repeat"
  style="background-image: url('{{ asset('assets/roomImages/login_image.png') }}'); background-attachment: fixed;">

  <!-- Overlay -->
  <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>

  <!-- Forgot Password Card -->
  <div
    class="relative z-10 bg-white/95 backdrop-blur-md rounded-3xl shadow-2xl p-10 w-full max-w-md mx-4 transform transition-all duration-300 hover:scale-[1.02]">

    <!-- Logo -->
    <div class="text-center mb-8">
      <div class="flex justify-center mb-3">
        <img src="{{ asset('assets/roomImages/psu_logo.jpg') }}" alt="Logo"
          class="w-20 h-20 object-contain drop-shadow-lg rounded-full bg-white/80 p-2 ring-2 ring-orange-500/60">
      </div>
      <h2 class="text-3xl font-bold text-orange-600">Forgot Password?</h2>
      <p class="text-gray-600 text-sm mt-1">No problem. Enter your email below to reset your password.</p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
      <div class="mb-4 text-sm text-green-600 text-center font-medium">
        {{ session('status') }}
      </div>
    @endif

    <!-- Forgot Password Form -->
    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
      @csrf

      <!-- Email -->
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
          class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:outline-none" />
        @error('email')
          <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- Submit Button -->
      <button type="submit"
        class="w-full bg-orange-600 text-white py-2 rounded-md font-semibold hover:bg-orange-500 transition duration-200 shadow-md hover:shadow-lg flex justify-center items-center gap-2">
        <i data-lucide="mail" class="w-5 h-5"></i>
        Email Password Reset Link
      </button>

      <!-- Back to Login -->
      <div class="text-center mt-4">
        <a href="{{ route('login') }}" class="text-sm text-orange-600 hover:underline flex items-center justify-center gap-1">
          <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to Login
        </a>
      </div>
    </form>
  </div>

  <script>
    lucide.createIcons();
  </script>
</body>
</html>
