<?php

namespace Leeto\Admin\Resources;


use Leeto\Admin\Components\Fields\ID;
use Leeto\Admin\Components\Fields\Text;
use Leeto\Admin\Components\Fields\Image;
use Leeto\Admin\Components\Fields\Date;
use Leeto\Admin\Components\Fields\Password;
use Leeto\Admin\Components\Filters\TextFilter;

class AdminUserResource extends Resource
{
	public static $model = 'Leeto\Admin\Models\AdminUser';

    public $title = "Администраторы";

    public function fields()
    {
        return [
            ID::make("id")->sortable()->export(),
            Text::make("name")->required()->export(),
            Image::make("avatar")->export(),
            Date::make("created_at")->form(false)->sortable()->format("d.m.Y")->index(false)->export(),
            Text::make("email")->sortable()->export()->required(),
            Password::make("password")->index(false),
            Password::make("password_repeat")->index(false),
        ];
    }

    public function rules($item) {
        return [
            "name" => "required|min:5",
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
            TextFilter::make("name"),
        ];
    }

    public function attributes() {
        return [
            "name" => "ФИО",
            "email" => "E-mail",
            "avatar" => "Фото",
            "password" => "Пароль",
            'password_repeat' => 'Подтверждение пароля',
            'created_at' => 'Дата',
        ];
    }
}
