<div :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false" class="fixed z-20 inset-0 bg-black opacity-50 transition-opacity lg:hidden"></div>

<div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="fixed z-30 inset-y-0 left-0 w-64 transition duration-300 transform bg-gray-900 overflow-y-auto lg:translate-x-0 lg:static lg:inset-0">
    <div class="flex items-center justify-center mt-8">
        <div class="flex items-center">
            <a href="{{ route("admin.index") }}">
				@if(config("admin.logo"))
					<img class="rounded-full h-10 mb-3 mx-auto" src="{{ config("admin.logo") }}" alt="{{ config("admin.title") }}">
				@else
					{{ config("admin.logo") }}
				@endif
            </a>
        </div>
    </div>

    @section("sidebar-inner")
    @show

    <x-menu />
</div>