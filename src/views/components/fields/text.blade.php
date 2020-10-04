<input {!! $attr["_attr"] ?? '' !!} value="{!! $value ?? '' !!}"
   id="{{ $attr["id"] ?? "field_{$attr["name"] }" }}"
   aria-label="{{ $label ?? '' }}"
   placeholder="{{ $label ?? '' }}"
   name="{{ $attr["name"] }}"
   type="{{ $attr["type"] }}"
   min="{{ $attr["min"] ?? 0 }}"
   max="{{ $attr["max"] ?? 100000 }}"
   autocomplete="{{ $attr["type"] == "password" ? "new-password" : "off" }}"
   class="{{ $attr["class"] ?? "bg-white focus:outline-none focus:shadow-outline border border-gray-300 rounded-lg py-2 px-4 block w-full appearance-none leading-normal" }}"
   {{ $attr["required"] ? "required" : "" }}
/>