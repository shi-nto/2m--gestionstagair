@include('assets.header')
<link rel="stylesheet" href="{{ asset('css/login.css') }}" />
<body>
    <section class="flex flex-1 justify-center items-center">
        <div class="sm:w-72 md:w-96 lg:w-120 xl:w-1/2 mx-auto flex flex-col items-center">
            <a href="/"> <img src="{{ asset('storage/images/2M_logo.png') }}" width="130" height="32" alt="logo"></a>

            <h2 class="text-2xl md:text-3xl font-bold pt-2 sm:pt-6 text-center text-white">
                Log in to your account
            </h2>
            <p class="text-sm md:text-base text-gray-600 mt-2 text-center">
                Welcome back! Please enter your details.
            </p>
            <form action="{{ route('login') }}" method="POST" class="mt-4 md:mt-6 w-full max-w-sm">
                @csrf
                @method('post')
                <div class="mb-4 relative">
                    <label for="email" class="block text-sm font-medium text-black-700">Username</label>
                    <input type="text" id="email" name="userName" value="{{ old('userName') }}" class="shadow-md focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 text-black py-3 px-3">
                    @error('userName')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4 relative">
                    <label for="password" class="block text-sm font-medium  dark:text-white">Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" class="shadow-md focus:ring-indigo-600 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 text-black py-3 px-3 pr-10">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                            <svg id="togglePasswordVisibility" class="h-6 w-6 text-gray-400 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path id="eyeIcon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path id="eyeSlashIcon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 19.364a2 2 0 11-2.828-2.828M4 12c0 4.418 3.582 8 8 8s8-3.582 8-8-3.582-8-8-8-8 3.582-8 8zm8-4a4 4 0 100 8 4 4 0 000-8z" />
                            </svg>
                        </div>
                    </div>
                    @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-indigo-600 dark:hover:bg-indigo-700">
                    <svg class="animate-spin h-5 w-5 mr-3 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A8.001 8.001 0 014 12H0c0 6.627 5.373 12 12 12v-4c-3.86 0-7.29-1.549-9.798-4.049l1.414-1.414zM20 12c0-6.627-5.373-12-12-12v4c3.86 0 7.29 1.549 9.798 4.049l-1.414 1.414A7.963 7.963 0 0120 12z"></path>
                    </svg>
                    Sign In
                </button>
            </form>
        </div>
        <div class="md:block xl:w-1/2 h-screen bg-no-repeat bg-cover" style="background-image: url('{{ asset('storage/images/login.png') }}');"></div>
    </section>

   
</body>
<script src="{{ asset('js/login.js') }}"></script>
</html>