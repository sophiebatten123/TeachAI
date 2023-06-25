<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Application Title</title>
  @vite('resources/css/app.css')
</head>

<body>
  <div class="bg-yellow-200 border-4 border-pink-200  p-4 flex">
    <div class="flex">
      <img class="w-12 h-auto" src="{{ asset('images/robot.png') }}" alt="Robot Logo">
      <h1 class="text-4xl pt-2 pl-4">Teach-BOT</h1>
    </div>
    <div class="ml-auto">
      @if(Auth::check())
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="bg-green-200 border-2 border-pink-200 p-4">Logout</button>
      </form>
      @else
      <div class="flex">
        <div class="mr-4">
          <form action="{{ route('login') }}" method="GET">
            <button type="submit" class="bg-green-200 border-2 border-pink-200 p-4">Login</button>
          </form>
        </div>
        <div>
          <form action="{{ route('register') }}" method="GET">
            <button type="submit" class="bg-green-200 border-2 border-pink-200 p-4">Register</button>
          </form>
        </div>
      </div>
      @endif

    </div>
  </div>
  @yield('content')
  <div class="bg-yellow-200 border-4 border-pink-200 p-4">
    <div class="flex">
      <div class="h-4 w-4 rounded-full bg-green-400 mx-auto"></div>
      <div class="h-4 w-4 rounded-full bg-green-400 mx-auto"></div>
      <div class="h-4 w-4 rounded-full bg-green-400 mx-auto"></div>
      <div class="h-4 w-4 rounded-full bg-green-400 mx-auto"></div>
    </div>
  </div>
</body>

</html>