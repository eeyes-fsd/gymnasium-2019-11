<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
    /** @var array 无法批量赋值的字段 */
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
