<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property string $wx_openid
 * @property string $wx_session_key
 * @property string $share_id
 * @property Address $address
 * @property Health $health
 * @property Collection $recipes
 * @property Collection $orders
 * @property Collection $topics
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @method static static find(int $id)
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses()
    {
        return $this->hasMany('App\Models\Address', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function health()
    {
        return $this->hasOne('App\Models\Health', 'user_id');
    }

    /**
     * @return Collection
     */
    public function reference()
    {
        $users_id = DB::table('shares')->where('share_id', $this->share_id)->get();

        $users = new Collection();
        foreach ($users_id as $id)
        {
            $users->add(self::find($id->user_id));
        }

        return $users;
    }

    /**
     * @return User
     */
    public function referee()
    {
        if (!$referee_id = DB::table('shares')->where('user_id', $this->id)->first()) return null;
        return self::where('share_id', $referee_id->share_id)->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function recipes()
    {
        return $this->belongsToMany('App\Models\Recipe')->withTimestamps()->withPivot(['id']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function topics()
    {
        return $this->hasMany('App\Models\Topic', 'user_id');
    }

    /**
     * @param Recipe $recipe
     * @return bool
     */
    public function has_recipe(Recipe $recipe)
    {
        return DB::table('recipe_user')
            ->where('user_id', $this->id)
            ->where('recipe_id', $recipe->id)
            ->exists();
    }
}
