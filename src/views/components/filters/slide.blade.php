@include("admin::components.fields.slide", ["label" => $resource->label($filter), "attr" => [
    "step" => $filter->step,
    "min" => $filter->min,
    "max" => $filter->max,
    "minName" => "filters[{$filter->name()}][min]",
    "maxName" => "filters[{$filter->name()}][max]",
    "minValue" => request("filters.{$filter->name()}.min"),
    "maxValue" => request("filters.{$filter->name()}.max"),
    "required" => false,
]])