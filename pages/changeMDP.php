<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img/logo.png" type="image/x-icon">
    <title>Changement de mot de passe</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="flex items-center justify-center h-screen bg-gray-800">
        <div class=" lg:w-1/3 w-2/3 md:w-6/12 bg-gray-300 p-2 my-10 mx-auto shadow-2xl border-2 rounded-md bg-gray-300 flex flex-col drop-shadow-2x shadow-lg shadow-indigo-500/40 h-4/5">
            <div class="max-w-md my-3 opacity-90 mx-auto">
                <div class="flex justify-center max-w-md my-3 opacity-90">
                    <h1 class="text-2xl text-zinc-600 font-bold">Changement de mot de passe</h1>
                </div>
                <!-- Debut du formulaire -->
                <form class="grid place-content-center gap-4 " method="post">
                   
                    <div class="block mt-8">
                        <label class="block text-slate-700  mt-10 sm:mt-8 text-center text-2xl tracking-wide" for="password">Nouveau mot de passe</label>
                        <input class="bg-slate-50 peer appearance-none mt-1 bg-slate-50 peer appearance-none    w-full py-2 px-2 text-gray-700 leading-tight px-2 py-1 rounded border border-gray-300 focus:outline-none focus:ring focus:border-blue-500 " type="password" placeholder="******************" id="password" name="password">
                    </div>
                    <div class="block ">
                        <label class="block text-slate-700 mb-1 mt-10 sm:mt-8 text-center text-2xl tracking-wide" for="password">Répéter mot de passe</label>
                        <input class="bg-slate-50 peer appearance-none mt-1 bg-slate-50 peer appearance-none    w-full py-2  text-gray-700 leading-tight px-2  rounded border border-gray-300 focus:outline-none focus:ring focus:border-blue-500" type="password" placeholder="******************" id="password" name="password">
                    </div>
                    <div class="mt-10 sm:mt-10 flex justify-center">
                        <button class="bg-sky-500 hover:bg-blue-500 py-2 px-5 text-xl mx-auto mt-10 text-white rounded transition ease-in-out delay-150 bg-blue-600 hover:-translate-y-1 hover:scale-110 hover:bg-blue-80000 duration-300 shadow-lg shadow-blue-500/50" type="submit" value="Login">
                            Modifier
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>