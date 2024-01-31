<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Include the Tailwind CSS library -->
    <script src="https://cdn.tailwindcss.com"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img/logo.png" type="image/x-icon">
    <title>Register</title>
</head>

<body>
  <!-- Main container with flex layout -->
  <div class="flex items-center h-screen justify-center bg-gray-800 shadow-2xl">
    <!-- Registration form container -->
    <div class="w-full">
      <div class="mx-auto w-2/3 md:w-4/6 lg:w-5/12 flex justify-center items-center border-2 rounded-md border-gray-700 py-7 mt-5 bg-gray-300 flex flex-col drop-shadow-2x shadow-lg shadow-indigo-500/40 mx-auto">
        <div class="max-w-md my-3 opacity-90">
          <!-- Form title -->
          <div class="flex justify-center">
            <h1 class="text-3xl text-zinc-600 font-bold lg:tracking-widest">Inscription</h1>
          </div>
          <!-- PHP notification message -->
          <form class="flex flex-col items-center" action="auth.php?action=register" method="post">
            <p class="notification mt-2 peer-invalid:visible text-pink-600 text-sm" ><?php echo $notification; ?></p>
            <!-- Email input -->
            <div class="block ">
              <label class="block text-slate-700 mb-2  mt-5 text-center lg:tracking-wider text-xl" for="email_inscription">Email</label>
              <input type="email" class="peer mt-1 bg-slate-50 appearance-none w-full  text-gray-700 leading-tight px-2 py-2 rounded border border-gray-300 focus:outline-none focus:ring focus:border-blue-500 px-6 py-2" placeholder="exemple@gmail.com" id="email_inscription" name="email" required>
              <p class="mt-2 invisible peer-invalid:visible text-pink-600 text-sm">
                  Please provide a valid email address.</p>
            </div>
            <!-- Nickname input -->
            <div class="block ">
              <label class="block text-slate-700 mb-2 text-center lg:tracking-wider text-xl" for="pseudo_inscription">Nickname</label>
              <input type="text" class="peer mt-1 bg-slate-50 peer appearance-none w-full text-gray-700 leading-tight  focus:bg-white  px-2 py-2 rounded border border-gray-300 focus:outline-none focus:ring focus:border-blue-500 px-6 py-2" placeholder="Joe" id="pseudo_inscription" name="username" required>
            </div>
            <!-- Password input -->
            <div class="block ">
              <label class="block text-slate-700 mt-5 text-center lg:tracking-wider mb-2 text-xl" for="password_inscription">Password</label>
              <input class="bg-slate-50 peer appearance-none  w-full text-gray-700 leading-tight px-2 py-2 rounded border border-gray-300 focus:outline-none focus:ring focus:border-blue-500 px-6 py-2 " type="password" placeholder="******************" id="password_inscription" name="password" required>
            </div>
            <!-- Confirm password input -->
            <div class="block ">
              <label class="block text-slate-700 mb-2 text-center mt-5 lg:tracking-wider text-xl ">Confirm password</label>
              <input class="bg-slate-50 peer appearance-none border-2 border-gray-200 rounded w-full p text-gray-700 leading-tight px-2 py-2 focus:outline-none focus:ring focus:border-blue-500 px-6 py-2 mt-1  " id="pwConfirm" type="password" placeholder="******************" name="pwConfirm" required>
            </div>
            <!-- Register button -->
            <div class="mt-5 flex justify-center">
              <button type="submit" name="register" value="Register" class=" bg-blue-600 hover:bg-sky-700 py-2 px-3 text-xl  mx-auto mt-5 text-white rounded transition ease-i bg-blue-500 hover:-translate-y-1 hover:scale-110 hover:bg-blue-900 duration-300 shadow-lg shadow-blue-500/50  lg:px-10 lg:tracking-wider">
                  Register
              </button>
            </div>
            <!-- Login link -->
            <div class="mt-4 text-center">
              <a href="auth.php?action=login" class="hover:text-blue-500 hover:underline hover:underline-offset-2 hover:text-blue-500 hover:font-bold hover:decoration-2">
              <p class="lg:tracking-wider text-xl">Login</p>
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</body>

</html>
