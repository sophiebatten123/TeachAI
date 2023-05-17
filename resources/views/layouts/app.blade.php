<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Application Title</title>
  @vite('resources/css/app.css')
</head>
<body>
    <div class="bg-blue-600 p-4">
        <h1 class="font-bold text-white text-lg">TeachAI</h1>
    </div>
    @yield('content')
</body>
</html>