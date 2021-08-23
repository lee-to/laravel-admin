<?php

namespace Leeto\Admin\Traits\Resources;

use Leeto\Admin\Components\Filters\BelongsToManyFilter;
use Leeto\Admin\Components\Filters\DateFilter;
use Leeto\Admin\Components\Filters\DateRangeFilter;
use Leeto\Admin\Components\Filters\HasManyFilter;
use Leeto\Admin\Components\Filters\HasOneFilter;
use Leeto\Admin\Components\Filters\SlideFilter;
use Illuminate\Database\Eloquent\Model;

/**
 * Trait QueryTrait
 * @package Leeto\Admin\Traits\Resources
 */
trait QueryTrait {

    /**
     * @return mixed
     */
    public function query() {
        $model = $this->getModel();

        if(request()->has("search") && count($this->search())) {
            foreach($this->search() as $field) {
                $model = $model->orWhere($field, "LIKE", "%" .request("search") . "%");
            }
        }

        if(request()->has("filters") && count($this->filters())) {
            $model = $this->initFilters($model);
        }

        if(request()->has("order")) {
            $model = $model->orderBy(request("order.field"), request("order.type"));
        } elseif($this->defaultSortField) {
            $model = $model->orderBy($this->defaultSortField, $this->defaultSortType);
        }

        return $model;
    }

    /**
     * @return mixed
     */
    public function all() {
        $model = $this->query();

        return $model->get();
    }

    /**
     * @return mixed
     */
    public function paginate() {
        $model = $this->query();

        return $model->paginate($this->itemsPerPage);
    }

    /**
     * @param Model $model
     * @return Model
     */
    protected function initFilters(Model $model) {
        foreach(request("filters") as $field => $value) {
            $filter = $this->getFilter($field);

            if($filter instanceof SlideFilter) {
                if(isset($value["min"], $value["max"]) && $value["min"] && $value["max"]) {
                    $model = $model->whereBetween($field, [$value["min"], $value["max"]]);
                }
            } elseif($filter instanceof DateFilter) {
                if($value) {
                    $model = $model->whereDate($field, date("Y-m-d", strtotime($value)));
                }
            } elseif($filter instanceof DateRangeFilter) {
                if(isset($value["from"], $value["to"]) && $value["from"] && $value["from"]) {
                    $model = $model->whereBetween($field, [date("Y-m-d", strtotime($value["from"])), date("Y-m-d", strtotime($value["to"]))]);
                }
            } elseif($filter instanceof HasOneFilter) {
                if($value) {
                    $model = $model->whereHas($filter->relation(), function ($query) use ($filter, $value) {
                        $query->where("id", '=', $value);
                    });
                }
            } elseif($filter instanceof HasManyFilter) {
                if(!empty($value)) {
                    $model = $model->whereHas($filter->relation(), function ($query) use ($filter, $value) {
                        $query->whereIn("id", $value);
                    });
                }
            } elseif($filter instanceof BelongsToManyFilter) {
                if(!empty($value)) {
                    $model = $model->whereHas($filter->relation(), function ($query) use ($model, $filter, $value) {
                        $table = $model->{$filter->relation()}()->getRelated()->getTable();

                        $query->whereIn("{$table}.id", $value);
                    });
                }
            } else {
                if($value != "") {
                    $model = $model->where($field, "LIKE", "%" . $value . "%");
                }
            }

        }

        return $model;
    }
}