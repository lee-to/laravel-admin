@include("admin::components.fields.text", ["label" => $resource->label($filter), "value" => request("filters.{$filter->name()}"), "attr" => [
    "type" => "text",
    "name" => "filters[{$filter->name()}]",
    "required" => false,
]])