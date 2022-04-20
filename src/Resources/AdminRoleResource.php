<?php

namespace Leeto\Admin\Resources;


use Leeto\Admin\Components\Fields\ID;
use Leeto\Admin\Components\Fields\Text;
use Leeto\Admin\Components\Fields\Image;
use Leeto\Admin\Components\Fields\Date;
use Leeto\Admin\Components\Fields\Password;
use Leeto\Admin\Components\Filters\TextFilter;
use Leeto\Admin\Models\AdminRole;

class AdminRoleResource extends Resource
{
	public static $model = AdminRole::class;

    public $title = 'Роли';

    public function can(): array
    {
        return [
            'list' => [AdminRole::$ADMIN_ROLE_ID],
            'add' => [AdminRole::$ADMIN_ROLE_ID],
            'edit' => [AdminRole::$ADMIN_ROLE_ID],
            'delete' => [AdminRole::$ADMIN_ROLE_ID],
        ];
    }

    public function fields()
    {
        return [
            ID::make('id')->sortable()->export(),
            Text::make('name')->required()->export(),
        ];
    }

    public function rules($item)
    {
        return [
            'name' => 'required|min:5',
        ];
    }

    public function search()
    {
        return ['id', 'name'];
    }

    public function filters()
    {
        return [
            TextFilter::make('name'),
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Название',
        ];
    }
}
