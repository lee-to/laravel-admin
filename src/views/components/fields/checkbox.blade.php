<div>
    <input id="{{ $attr["name"] }}_{{ $value }}" type="checkbox" name="{{ $attr["name"] }}" value="{{ $value }}" />
    @if(isset($label))
        <label class="ml-5" for="{{ $attr["name"] }}_{{ $value }}">{{ $label }}</label>
    @endif
</div>
