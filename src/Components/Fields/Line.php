<?php

namespace Leeto\Admin\Components\Fields;


use Illuminate\Support\Str;

class Line extends Field
{
    public $view = "lines";

    public $columns = [];

    public $types = [];

    public $options = [];

    public function columns(array $columns) {
        $columns = collect($columns)->map(function ($value, $key) {
            $type = "Text";

            if(Str::containsAll($value, ["{", "}"])) {
                $type = Str::between($value, "{", "}");
                $value = str_replace([$type, "{", "}"], "", $value);
            }

            if(Str::containsAll($value, ["[", "]"])) {
                $options = Str::between($value, "[", "]");
                $value = str_replace([$options, "[", "]"], "", $value);
                $this->options[$key] = explode(",", str_replace("'", "", $options));
            }

            $this->types[$key] = $type;

            return $value;
        });

        $this->columns = $columns;

        return $this;
    }

    public function formatValues($values) {
        $result = [];

        foreach ($values as $fieldName => $fieldValues) {
            foreach ($fieldValues as $index => $valueField) {
                $result[$index][$fieldName] = $valueField;
            }
        }

        return $result;
    }

    public function indexView($item)
    {
        return view("admin::components.partials.table", ["columns" => $this->columns, "values" => $item->{$this->name()}]);
    }

    public function exportView($item)
    {
        return json_encode($item->{$this->name()});
    }
}