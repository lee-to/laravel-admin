<?php

namespace Leeto\Admin\Traits;

use App\Models\OrderProduct;
use Leeto\Admin\Components\Fields\FileInterface;
use Leeto\Admin\Components\Fields\HasMany;
use Leeto\Admin\Components\Fields\Line;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Leeto\Admin\Components\Fields\SlideField;
use Leeto\Admin\Components\Fields\SubItemInterface;
use Leeto\Admin\Components\RelationInterface;
use Leeto\Admin\Models\AdminChangeLog;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * Trait HasAdminChangeLog
 * @package Leeto\Admin\Traits
 */
trait HasAdminChangeLog
{

    public static function boot()
    {
        parent::boot();

        static::created(function($row){
            $row->createLog();
        });

        static::updated(function($row){
            $row->createLog();
        });
    }

    public function createLog()
    {
        if(auth('admin')->check()) {
            $this->adminChangeLogs()
                ->create([
                    'admin_user_id' => auth('admin')->id(),
                    'states_before' => $this->getOriginal(),
                    'states_after' => $this->getChanges(),
                ]);
        }
    }

    public function adminChangeLogs()
    {
        return $this->morphMany(AdminChangeLog::class, 'changelogable')
            ->where(['admin_user_id' => auth('admin')->id()])
            ->orderByDesc('created_at');
    }
}