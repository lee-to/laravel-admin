<div>
    @foreach($attr["options"] as $optionValue => $optionName)
        <div>
            <input @if($value->contains("id", "=", $optionValue)) checked @endif
                id="{{ $attr["name"] }}_{{ $optionValue }}"
                type="checkbox" name="{{ $attr["name"] }}"
                value="{{ $optionValue }}"
            />
            @if(isset($label))
                <label class="ml-5" for="{{ $attr["name"] }}_{{ $optionValue }}">{{ $optionName }}</label>
            @endif
        </div>
    @endforeach
</div>
