<select {!! $attr["_attr"] ?? '' !!} name="{{ $attr["name"] }}" {{ $attr["required"] ? "required" : "" }} class="block appearance-none w-full border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
    @if(isset($attr["default"]) && $attr["default"])
        <option value="" @if(is_null($value)) selected @endif>{{ $attr["default"] }}</option>
    @endif
    @foreach($attr["options"] as $optionValue => $optionName)
        <option @if((string) $value === (string) $optionValue) selected @endif value="{{ $optionValue }}">{{ $optionName }}</option>
    @endforeach
</select>
