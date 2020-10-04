@include("admin::components.fields.switch", ["label" => $resource->label($filter), "value" => request("filters.{$filter->name()}"), "attr" => [
    "multiple" => false,
    "name" => "filters[{$filter->name()}]",
    "required" => false,
    "disabled" => false,
    "onValue" => $filter->onValue,
    "offValue" => $filter->offValue,
]])
