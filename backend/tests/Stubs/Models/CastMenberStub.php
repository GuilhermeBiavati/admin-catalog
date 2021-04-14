<?php

namespace Tests\Stubs\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CastMemberStub extends Model
{
    protected $table = 'cast_Members_stubs';
    protected $fillable = [
        'name', 'type'
    ];

    public static function createTable()
    {
        Schema::create('cast_Members_stubs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->smallInteger('type');
            $table->timestamps();
        });
    }

    public static function dropTable()
    {
        Schema::dropIfExists('cast_Members_stubs');
    }
}
