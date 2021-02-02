<div x-data="{ open: {{ $menu["current"] || $menu["dropdown"]->contains('current', true)  ? 'true' : 'false' }} }">
    <button @if($menu["dropdown"]->isNotEmpty()) @click="open = !open" @else @click="window.location.href='{{ $menu["url"] }}';" @endif class="w-full flex justify-between items-center py-3 px-6 text-gray-100 cursor-pointer hover:bg-gray-700 hover:text-gray-100 focus:outline-none">
        <span class="flex items-center">
            @include("admin::partials.icons.{$menu["icon"]}", ["size" => 6, "class" => "", "color" => "blue"])

            <span class="mx-4 font-medium">{{ $menu["data"]["title"] }}</span>
        </span>

        @if($menu["dropdown"]->isNotEmpty())
            <span>
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path x-show="! open" d="M9 5L16 12L9 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: none;"></path>
                    <path x-show="open" d="M19 9L12 16L5 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </span>
        @endif
    </button>

    @if($menu["dropdown"]->isNotEmpty())
        <div x-show="open" class="bg-gray-700">
            @foreach($menu["dropdown"] as $child)
                <a class="py-2 px-16 block text-sm text-gray-100 {{ $child["current"] ? 'bg-blue-500 text-white' : 'hover:bg-blue-500 hover:text-white' }} " href="{{ $child["url"] }}">{{ $child["data"]["title"] }}</a>
            @endforeach
        </div>
    @endif
</div>