<?php

namespace Leeto\Admin\Components\Fields;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Leeto\Admin\Components\RelationInterface;
use Leeto\Admin\Resources\Resource;

class HasManyExtend extends Field implements RelationInterface, SubItemInterface
{
    public $view = 'has-many-extend';

    public $fields;

    public $subItem = false;

    public function jsonValues(Resource $resource = null)
    {
        $json = [];

        if ($resource) {
            $resourceValues = $resource->getSubItemData();

            if($this->parentRelation()) {
                $resourceValues = $resourceValues[$this->parentRelation() . '.' . $this->originalName()] ?? [];

                foreach ($resourceValues as $parentId => $values) {
                    foreach ($values as $index => $data) {
                        $json[$parentId][$index]['id'] = $data->id;

                        foreach ($this->getFields() as $field) {
                            $json[$parentId][$index][$field->originalName()] = $data->{$field->originalName()};
                            //$json[$parentId][$index]["input_name_" . $field->originalName()] = str_replace(":index", $parentId, str_replace(":sub_index", $data->id, $field->name()));
                            $json[$parentId][$index]['input_name_' . $field->originalName()] = $field->name();
                        }
                    }
                }
            } else {
                $resourceValues = $resourceValues[$this->originalName()] ?? [];

                foreach ($resourceValues as $index => $data) {
                    $json[$index]['id'] = $data->id;

                    foreach ($this->getFields() as $field) {
                        $json[$index][$field->originalName()] = $data->{$field->originalName()};
                        //$json[$index]["input_name_" . $field->originalName()] = str_replace(":index", $data->id, $field->name());
                        $json[$index]['input_name_' . $field->originalName()] = $field->name();
                    }
                }
            }
        } else {
            $json['id'] = '';

            foreach ($this->getFields() as $field) {
                $json[$field->originalName()] = '';
                $json['input_name_' . $field->originalName()] = $field->name();
            }
        }

        return $json;
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function fields(array $fields)
    {
        $this->fields = $fields;

        foreach ($fields as $field) {
            $field->xModel($this->relation());

            if($field instanceof HasManyExtend) {
                $field->subItem = true;
            }

        }

        return $this;
    }

    public function getSubFields()
    {
        $fields = [];

        foreach ($this->getFields() as $field) {
            if($field instanceof HasManyExtend) {
                $fields[] = $field;
            }
        }

        return $fields;
    }

    public function indexView($item)
    {
        return collect($item->{$this->relation()})->map(function ($item) {
            return str_replace("\"", "'", view('admin::components.partials.badge', [
                'color' => 'purple',
                'value' => $item->{$this->relationViewField()}
            ]));
        })->implode('');
    }

    public function exportView($item)
    {
        return collect($item->{$this->relation()})->map(function ($item) {
            return $item->{$this->relationViewField()};
        })->implode(';');
    }
}