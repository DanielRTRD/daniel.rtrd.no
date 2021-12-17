<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="h-screen min-h-full {{ env('APP_DEBUG') ? 'debug-screens' : '' }}">
        <div class="min-h-full px-4 pb-8 font-sans antialiased text-gray-900 bg-white dark:bg-gray-900">
            <nav x-data="{ open: false }" class="px-4 bg-white md:px-8 dark:bg-gray-900">
                <div class="max-w-4xl mx-auto">
                    <div class="flex items-center justify-between w-full h-16">
                        <div class="flex items-center">
                            <a class="flex" href="{{ route('home') }}">
                                <div class="flex items-center font-semibold tracking-wider text-gray-900 uppercase transition-colors dark:text-white hover:text-orange-400 focus:text-orange-400 focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-orange-500 focus-visible:ring-opacity-60 focus-visible:outline-none focus:outline-none">{{ config('app.name') }}</div>
                            </a>
                        </div>
                        <div class="hidden sm:block">
                            <div class="flex items-baseline ml-auto space-x-3">
                                <x-nav-link-front href="{{ route('blog.index') }}">Blog</x-nav-link-front>
                                <x-nav-link-front href="{{ route('register') }}">CV</x-nav-link-front>
                            </div>
                        </div>
                        <div class="flex -mr-2 sm:hidden">
                            <button @click="open = !open"
                                class="inline-flex items-center justify-center p-2 text-gray-800 rounded-md dark:text-white hover:text-orange-400 focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
                    <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                        <x-nav-link-responsive-front href="{{ route('blog.index') }}">Blog</x-nav-link-responsive-front>
                        <x-nav-link-responsive-front href="{{ route('register') }}">CV</x-nav-link-responsive-front>
                    </div>
                </div>
            </nav>
            <main class="max-w-4xl mx-auto mt-8 antialiased sm:px-4 sm:mt-16 lg:px-0">
                {{ $slot }}
            </main>
            <div class="pb-6 mt-12 sm:mt-24">
                <div class="max-w-4xl mx-auto text-xs text-gray-400 sm:px-4 lg:px-0">
                    <div class="pb-4 mb-2 border-t border-gray-100 dark:border-gray-800"></div>
                    <div class="flex flex-row justify-between">
                        <div class="space-x-4 space-y-2 font-medium">
                            @foreach (\App\Models\Social::all() as $social)
                                <a href="{{$social->link}}" class="transition-colors rounded hover:text-orange-500 focus:text-orange-500 focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-orange-500 focus-visible:ring-opacity-60 focus-visible:outline-none focus:outline-none" target="_blank"><i class="{{$social->icon}} text-sm mr-1"></i>{{$social->name}}</a>
                            @endforeach
                        </div>
                    </div>
                    <div class="justify-center mx-auto my-4">
                        <a href="https://github.com/DanielRTRD/daniel.rtrd.no" class="text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400">Built with Laravel and Tailwind, check it out on <i class="fab fa-github"></i> Github</a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
