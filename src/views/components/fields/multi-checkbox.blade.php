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

            @if(isset($attr['fields']))
                @foreach($attr["fields"] as $field)
                    <div class="my-4">
                        {{ $resource->component(
                        $field,
                        "fields",
                        $value->firstWhere('id', '=', $optionValue)->pivot ?? $emptyValue,
                        true)
                        }}
                    </div>
                @endforeach
            @endif
        </div>
    @endforeach
</div>
