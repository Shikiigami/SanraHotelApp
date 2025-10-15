{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login | Hospitality Management PMS</title>

  <script src="{{ asset('assets/js/tailwindcss.js') }}"></script>
  <script src="{{ asset('assets/js/lucide2.js') }}"></script>

  <link rel="icon" type="image/png" href="{{ asset('assets/roomImages/psu_logo.jpg') }}">
</head>

<body class="min-h-screen flex items-center justify-center relative bg-cover bg-center bg-no-repeat"
  style="background-image: url('{{ asset('assets/roomImages/login_image.png') }}'); background-attachment: fixed;">

  <!-- Overlay for readability -->
  <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>

  <!-- Floating Login Card -->
  <div
    class="relative z-10 bg-white/95 backdrop-blur-md rounded-3xl shadow-2xl p-10 w-full max-w-md mx-4 transform transition-all duration-300 hover:scale-[1.02]">

    <!-- Logo -->
    <div class="text-center mb-8">
      <div class="flex justify-center mb-3">
        <img src="{{ asset('assets/roomImages/psu_logo.jpg') }}" alt="Logo"
          class="w-20 h-20 object-contain drop-shadow-lg rounded-full bg-white/80 p-2 ring-2 ring-orange-500/60">
      </div>

      <h2 class="text-3xl font-bold text-orange-600">Welcome!</h2>
      <p class="text-gray-600 text-sm mt-1">Hospitality Management PMS</p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
      <div class="mb-4 text-sm text-green-600 text-center font-medium">
        {{ session('status') }}
      </div>
    @endif

    <!-- Login Form -->
    <form method="POST" action="{{ route('login') }}" class="space-y-6">
      @csrf

      <!-- Email -->
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
          class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:outline-none" />
        @error('email')
          <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- Password -->
      <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <div class="relative">
          <input id="password" type="password" name="password" required autocomplete="current-password"
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:outline-none pr-10" />
          <i data-lucide="eye" class="absolute right-3 top-2.5 w-5 h-5 text-gray-400 cursor-pointer" id="togglePassword"></i>
        </div>
        @error('password')
          <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
        @enderror

        @if (Route::has('password.request'))
          <div class="text-right mt-1">
            <a href="{{ route('password.request') }}" class="text-sm text-orange-600 hover:underline">Forgot Password?</a>
          </div>
        @endif
      </div>

      <!-- Remember Me -->
      <div class="flex items-center">
        <input type="checkbox" id="remember" name="remember"
          class="rounded border-gray-300 text-orange-600 focus:ring-orange-500" />
        <label for="remember" class="ml-2 text-sm text-gray-600">Remember Me</label>
      </div>

      <!-- Submit Button -->
      <button type="submit"
        class="w-full bg-orange-600 text-white py-2 rounded-md font-semibold hover:bg-orange-500 transition duration-200 shadow-md hover:shadow-lg">
        Log in
      </button>
    </form>
  </div>

  <script>
    lucide.createIcons();

    // Toggle password visibility
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    togglePassword.addEventListener('click', () => {
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);
      togglePassword.classList.toggle('text-orange-500');
    });
  </script>
</body>
</html>
