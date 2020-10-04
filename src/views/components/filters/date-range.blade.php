<div class="flex justify-center items-center">
    <div class="relative max-w-xl w-full">
        <div class="flex justify-between items-center py-5">
            <div>
                @include("admin::components.fields.text", ["label" => $resource->label($filter), "value" => request("filters.{$filter->name()}.from"), "attr" => [
                    "type" => "date",
                    "name" => "filters[{$filter->name()}][from]",
                    "required" => false,
                    "class" => "px-3 py-2 border border-gray-200 rounded w-24 text-center"
                ]])
            </div>
            <div>
                @include("admin::components.fields.text", ["label" => $resource->label($filter), "value" => request("filters.{$filter->name()}.to"), "attr" => [
                    "type" => "date",
                    "name" => "filters[{$filter->name()}][to]",
                    "required" => false,
                    "class" => "px-3 py-2 border border-gray-200 rounded w-24 text-center"
                ]])
            </div>
        </div>

    </div>
</div>