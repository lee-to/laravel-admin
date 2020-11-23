<?php

namespace Leeto\Admin\Components;


use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Leeto\Admin\Components\Fields\Date;
use Leeto\Admin\Components\Fields\Editor;
use Leeto\Admin\Components\Fields\ID;
use Leeto\Admin\Components\Fields\Number;
use Leeto\Admin\Components\Fields\Text;

class TableFields
{

    protected $table;

    public function __construct($table)
    {
        $this->setTable($table);
    }

    public function generate($only = []) {
        $fields = [];
        $tableData = DB::select("DESCRIBE {$this->getTable()}");
        
        foreach ($tableData as $data) {
            if(!empty($only) && !in_array($data->Field, $only)) {
                continue;
            }

            $classField = $this->typeFields($data);

            if($classField) {
                $classField = $classField::make($data->Field);

                if($data->Default) {
                    $classField->default($data->Default);
                }

                if($data->Null == "NO") {
                    $classField->required();
                }

                $fields[] = $classField;
            }
        }

        return $fields;
    }

    protected function typeFields($data) {
        $type = Str::before($data->Type, "(");

        if($data->Key == "PRI") {
            return ID::class;
        }

        $types = [
            Number::class => ["bigint", "int", "double"],
            Text::class => ["varchar", "text"],
            Editor::class => ["longtext"],
            Date::class => ["timestamp", "date", "datetime"],
        ];

        return Arr::first(array_keys(Arr::where($types, function ($item) use($type) {
            return in_array($type, $item);
        })));
    }

    /**
     * @return mixed
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param mixed $table
     */
    public function setTable($table): void
    {
        $this->table = $table;
    }


}