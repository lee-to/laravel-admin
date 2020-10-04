<style>
    /* CHECKBOX TOGGLE SWITCH */
    /* @apply rules for documentation, these do not work as inline style */
    .toggle-checkbox:checked {
        @apply: right-0 border-green-400;
        right: 0;
        border-color: #68D391;
    }
    .toggle-checkbox:checked + .toggle-label {
        @apply: bg-green-400;
        background-color: #68D391;
    }
</style>

<div x-data='{checked : {{ $attr["onValue"] == $value ? 'true' : 'false'}}}' class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
    <input type="hidden" name="{{ $attr["name"] }}" :value="checked ? '{{ $attr["onValue"] }}' : '{{ $attr["offValue"] }}'" value="{{ $attr["onValue"] == $value ? '1' : '0'}}">

    <input @change='checked=!checked'
           {{ $attr["disabled"] ? 'disabled' : ''}}
           {{ $attr["onValue"] == $value ? 'checked' : ''}}
           :value="checked ? '{{ $attr["onValue"] }}' : '{{ $attr["offValue"] }}'"
           value="{{ $attr["onValue"] }}"
           type="checkbox"
           name="fake_{{ $attr["name"] }}"
           id="switch_field_{{ $attr["name"] }}"
           class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"
    />

    <label for="switch_field_{{ $attr["name"] }}" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
</div>