<div>
    @foreach($attr["options"] as $optionValue => $optionName)
        <div>
            <input @if($value->contains("id", "=", $optionValue)) checked @endif
            id="{{ $attr["originalName"] ?? $attr["name"] }}_{{ $optionValue }}"
                   type="checkbox" name="{{ $attr["name"] }}"
                   value="{{ $optionValue }}"
            />

            @if(isset($label))
                <label class="ml-5" for="{{ $attr["name"] }}_{{ $optionValue }}">{{ $optionName }}</label>
            @endif

            @if(isset($attr['fields']))
                <div id="{{ $attr["originalName"] ?? $attr["name"] }}_{{ $optionValue }}_pivots">
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
                </div>
            @endif
        </div>

        <script>
          let input_{{ $attr["originalName"] ?? $attr["name"] }} = document.querySelector("#{{ $attr["originalName"] ?? $attr["name"] }}_{{ $optionValue }}");

          let pivotsDiv_input_{{ $attr["originalName"] ?? $attr["name"] }} = document.querySelector("#{{ $attr["originalName"] ?? $attr["name"] }}_{{ $optionValue }}_pivots");

          let inputs_{{ $attr["originalName"] ?? $attr["name"] }} = pivotsDiv_input_{{ $attr["originalName"] ?? $attr["name"] }}.querySelectorAll('input, textarea, select');

          inputs_{{ $attr["originalName"] ?? $attr["name"] }}.forEach(function(value, key) {
            value.addEventListener('input', (event) => {
              input_{{ $attr["originalName"] ?? $attr["name"] }}.checked = event.target.value;
            });
          })
        </script>
    @endforeach
</div>