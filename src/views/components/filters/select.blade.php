@include("admin::components.fields.select", ["label" => $resource->label($filter), "value" => request("filters.{$filter->name()}"), "attr" => [
    "multiple" => false,
    "name" => "filters[{$filter->name()}]",
    "required" => false,
    "options" => $filter->values(),
]])
