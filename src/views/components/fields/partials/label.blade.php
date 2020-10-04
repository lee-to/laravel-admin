<label for="{{ $field->name() }}">
    {{ $resource->label($field)  }} {!! isset($field->required) && $field->required ? "<span class='text-red-400'>*</span>" : ""  !!}
</label>