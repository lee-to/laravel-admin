<header class="flex justify-between items-center py-4 px-6 bg-white border-b-2 border-gray-200 shadow-md">
    <div class="flex items-center">
        <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                      stroke-linejoin="round"></path>
            </svg>
        </button>
    </div>

    <div class="items-center">
        @section("header-inner")

        @show

        <x-header-buttons />
    </div>

    <div class="flex items-center">
        <div x-data="{ dropdownOpen: false }" class="relative">
            <button @click="dropdownOpen = ! dropdownOpen"
                    class="relative block h-8 w-8 rounded-full overflow-hidden shadow focus:outline-none">
                <img class="h-full w-full object-cover"
                     src="/storage/{{ auth("admin")->user()->avatar }}"
                     alt="{{ auth("admin")->user()->name }}">
            </button>

            <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 h-full w-full z-10"
                 style="display: none;"></div>

            <div x-show="dropdownOpen"
                 class="absolute right-0 mt-2 w-48 bg-white rounded-md overflow-hidden shadow-xl z-10"
                 style="display: none;">
                <a href="{{ route("admin.logout") }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white">{{ trans("admin.login.logout") }}</a>
            </div>
        </div>
    </div>
</header>