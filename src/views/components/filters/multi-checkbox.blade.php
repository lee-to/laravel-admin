@php
    $value = [];
    if(request("filters.{$filter->name()}")) {
        foreach (request("filters.{$filter->name()}") as $valueFilter) {
            $value[] = ["id" => $valueFilter[0]];
        }
    }
@endphp

@include("admin::components.fields.multi-checkbox", ["label" => $resource->label($filter), "value" => collect($value), "attr" => [
    "multiple" => true,
    "name" => "filters[{$filter->name()}][]",
    "required" => false,
    "options" => $filter->values(),
]])
