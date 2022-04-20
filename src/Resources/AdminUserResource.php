<?php

namespace Leeto\Admin\Resources;


use Leeto\Admin\Components\Fields\HasOne;
use Leeto\Admin\Components\Fields\ID;
use Leeto\Admin\Components\Fields\Text;
use Leeto\Admin\Components\Fields\Image;
use Leeto\Admin\Components\Fields\Date;
use Leeto\Admin\Components\Fields\Password;
use Leeto\Admin\Components\Filters\TextFilter;
use Leeto\Admin\Models\AdminRole;
use Leeto\Admin\Models\AdminUser;

class AdminUserResource extends Resource
{
	public static $model = AdminUser::class;

    public $title = 'Администраторы';

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
            HasOne::make('admin_role_id', 'adminRole', 'name')->export(),
            Text::make('name')->required()->export(),
            Image::make('avatar')->export(),
            Date::make('created_at')->form(false)->sortable()->format("d.m.Y")->index(false)->export(),
            Text::make('email')->sortable()->export()->required(),
            Password::make('password')->index(false),
            Password::make('password_repeat')->index(false),
        ];
    }

    public function rules($item)
    {
        return [
            'name' => 'required|min:5',
            'admin_role_id' => 'required',
            'email' => 'sometimes|bail|required|email|unique:admin_users,email,'.$item->id,
            'password' => 'sometimes|nullable|min:6|required_with:password_repeat|same:password_repeat',
        ];
    }

    public function search()
    {
        return ["id", "name"];
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
            'name' => 'ФИО',
            'admin_role_id' => 'Роль',
            'email' => 'E-mail',
            'avatar' => 'Фото',
            'password' => 'Пароль',
            'password_repeat' => 'Подтверждение пароля',
            'created_at' => 'Дата',
        ];
    }
}
