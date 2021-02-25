<?php

namespace Leeto\Admin\Components\Fields;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Leeto\Admin\Components\RelationInterface;

class CheckboxTree extends Field implements RelationInterface
{
    public $view = "checkbox-tree";

    public $html;

    public $plain;

    public $parentColumn = "parent_id";

    public $ids = [];

    public $liClass = "mb-3 bg-blue-200 py-4 px-4 rounded-md";

    public function build($parentColumn, $data) {
        $this->parentColumn = $parentColumn;

        $this->htmlView($data, true);

        return $this;
    }

    public function indexView(Model $item)
    {
        $data = $item->{$this->relation()};

        $this->htmlView($data, false);

        return $this->html;
    }

    public function exportView(Model $item)
    {
        $data = $item->{$this->relation()};

        $this->htmlView($data, false);

        return $this->plain;
    }

    protected function formattedData($data) {
        $formatted = [];

        foreach ($data as $item) {
            $parent = is_null($item->{$this->parentColumn}) ? 0 : $item->{$this->parentColumn};

            $formatted[$parent][$item->id] = $item;
        }

        return $formatted;
    }

    protected function htmlView($data, $editable = true) {
        $this->html = "";
        $this->plain = "";
        $this->tree($this->formattedData($data), $editable);
        $this->html = Str::of($this->html)->prepend("<ul>")->append("</ul>");
    }

    protected function tree($data, $editable, $parent_id = 0, $offset = 0)
    {
        if(isset($data[$parent_id])) {
            foreach($data[$parent_id] as $item)
            {
                $this->ids[] = $item->id;

                $margin = $offset*50;

                $element = $item->{$this->relationViewField()};

                if($editable) {
                    $element = view("admin::components.fields.checkbox", ["label" => $item->{$this->relationViewField()}, "value" => $item->id, "attr" => ["name" => $this->name() . "[]"]]);
                } else {
                    $this->plain .= str_repeat("-", $offset);
                    $this->plain .= $item->{$this->relationViewField()} . "\n";
                }

                $this->html .= Str::of($element)->prepend("<li x-ref='item_{$item->id}' style='margin-left: {$margin}px' class='{$this->liClass}'>")->append("</li>");

                $this->tree($data, $editable, $item->id, $offset + 1);
            }
        }
    }
}