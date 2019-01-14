<?php

namespace DigitalCloud\Blameable\Traits;

use App\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

trait Blameable
{

    public static function bootBlameable()
    {
        static::checkBlameableColumns();

        static::creating(function ($model) {
            $createdByAttribute = Config::get('blameable.column_names.createdByAttribute', 'created_by');
            $model->$createdByAttribute = Auth::id();
        });

        static::updating(function ($model) {
            $updatedByAttribute = Config::get('blameable.column_names.updatedByAttribute', 'updated_by');
            $model->$updatedByAttribute = Auth::id();
        });
    }

    public static function checkBlameableColumns() {
        $table = (new static)->getTable();
        $createdByAttribute = Config::get('blameable.column_names.createdByAttribute', 'created_by');
        $updatedByAttribute = Config::get('blameable.column_names.updatedByAttribute', 'updated_by');
        if (!Schema::hasColumn($table, $createdByAttribute) && !Schema::hasColumn($table, $updatedByAttribute)) {
            //
        }
    }


    public static function addBlameableColumns() {
        $table = (new static)->getTable();
        $createdByAttribute = Config::get('blameable.column_names.createdByAttribute', 'created_by');
        $updatedByAttribute = Config::get('blameable.column_names.updatedByAttribute', 'updated_by');
        if (!Schema::hasColumn($table, $createdByAttribute) && !Schema::hasColumn($table, $updatedByAttribute)) {
            Schema::table($table, function (Blueprint $table) {
                $table->blameable();
            });
        }
    }

    public function creator() {
        $userModel = Config::get('blameable.models.user', User::class);
        return $this->belongsTo($userModel, 'created_by', 'id');
    }

    public function editor() {
        $userModel = Config::get('blameable.models.user', User::class);
        return $this->belongsTo($userModel, 'updated_by', 'id');
    }


}
