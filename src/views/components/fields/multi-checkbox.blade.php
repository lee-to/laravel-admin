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

            @if(isset($attr['pivotField']) && $attr['pivotField'] != '')
                <input type="text"
                       required
                       name="{{ $attr['originalName'] }}_{{ $attr['pivotField'] }}[]"
                       class="bg-white focus:outline-none focus:shadow-outline border border-gray-300 rounded-lg py-2 px-4  ml-2 appearance-none leading-normal"
                       value="{{ $value->firstWhere('id', '=', $optionValue)->pivot->{$attr['pivotField']} ?? '' }}"
                />
            @endif
        </div>
    @endforeach
</div>
