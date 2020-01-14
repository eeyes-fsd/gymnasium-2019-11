<?php

namespace App\Models;

class Diet extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function breakfast()
    {
        return $this->belongsTo('App\Models\Meal','breakfast_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lunch()
    {
        return $this->belongsTo('App\Models\Meal','lunch_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dinner()
    {
        return $this->belongsTo('App\Models\Meal','dinner_id');
    }
}
