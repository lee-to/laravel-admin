@if($type == "avatar")
    <img class="h-10 w-10 rounded-full" src="{{ Storage::url($value) }}" />
@elseif($type == "multiple")
    <div @if($attr["removeable"]) x-data="{}" x-ref="hidden_{{ $attr["name"] }}_parent" @endif class="relative bg-white p-3 m-2 border-1 border-dashed border-gray-100 shadow-md rounded-lg overflow-hidden">
        <input x-ref="hidden_{{ $attr["name"] }}" type="hidden" name="hidden_{{ $attr["name"] }}[]" value="{{ $value }}" />

        <img class="w-full object-cover object-center rounded" src="{{ Storage::url($value) }}" />

        @if($attr["removeable"])
        <div class="p-4 absolute top-0 right-0">
            <div class="text-center">
                <a href="#" @click="$refs.hidden_{{ $attr["name"] }}_parent.remove();" class="px-4 py-2 bg-red-500 shadow-lg border rounded-lg text-white uppercase font-semibold tracking-wider focus:outline-none focus:shadow-outline hover:bg-red-400 active:bg-red-400">
                    {{ trans("admin.delete") }}
                </a>
            </div>
        </div>
        @endif
    </div>
@else
    <div class="max-w-sm rounded overflow-hidden shadow-lg mt-5">
        <img  class="w-full" src="{{ Storage::url($value) }}" />
    </div>
@endif
