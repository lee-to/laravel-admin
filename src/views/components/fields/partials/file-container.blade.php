<div @if($attr["multiple"]) x-data="" @endif>
    @if($value)
        @if($attr["multiple"])
            <input name="sync_{{ $attr["name"] }}" type="hidden" value="1" />

            <div class="{{ $class }}">
                @foreach($value as $index => $file)
                    @include("admin::components.partials.{$itemView}", ["type" => "multiple", "value" => $file, "attr" => $attr, "index" => $index])
                @endforeach
            </div>
        @else
            @include("admin::components.partials.{$itemView}", ["type" => "single", "value" => $value, "attr" => $attr])
        @endif
    @endif

    @php
        $attr["name"] .= $attr["multiple"] ? "[]" : "";
        $attr["class"] = "mt-5 appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 sm:text-sm sm:leading-5";
    @endphp

    @include("admin::components.fields.text", ["value" => "", "label" => $label, "attr" => $attr])
</div>
