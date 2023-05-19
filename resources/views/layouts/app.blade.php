<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Application Title</title>
  @vite('resources/css/app.css')
</head>

<body>
  <div class="bg-blue-600 p-4 flex">
    <div>
      <h1 class="font-bold text-white text-lg">TeachAI</h1>
    </div>
    <div class="ml-auto">
      @if(Auth::check())
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="bg-orange-200 rounded-full p-4">Logout</button>
      </form>
      @else
      <div class="flex">
        <div class="mr-4">
          <form action="{{ route('login') }}" method="GET">
            <button type="submit" class="bg-orange-200 rounded-full p-4">Login</button>
          </form>
        </div>
        <div>
          <form action="{{ route('register') }}" method="GET">
            <button type="submit" class="bg-orange-200 rounded-full p-4">Register</button>
          </form>
        </div>
      </div>
      @endif

    </div>
  </div>
  @yield('content')
</body>

</html>