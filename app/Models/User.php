<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Hash;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use DB;
use ChannelLog as Log;
use Faker;

/**
 * App\Models\User
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property boolean $status
 * @property string $deleted_at
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{

    use Authenticatable, CanResetPassword, EntrustUserTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['uid', 'username', 'mobile', 'email', 'password', 'status'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function getStatusAttribute($value)
    {
        return $value == 1 ? '正常' : '已冻结';
    }

    /**
     * Hash the users password
     *
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        if (Hash::needsRehash($value)) {
            $this->attributes['password'] = bcrypt($value);
        } else {
            $this->attributes['password'] = $value;
        }
    }

    public function getRoleIds() {
        $userRoles = $this->roles()->select('id')->get();
        $ret = '';
        foreach($userRoles as $role) {
            $ret .= $role->id.",";
        }
        return trim($ret, ",");
    }

    function userProfile() {
        return $this->hasOne('App\Models\UserProfile');
    }

    public function roles(){
        return $this->belongsToMany('App\Models\Role');
    }

    public static function getExpdrivers() {
        return Role::find(config('custom.exp_driver_code'))->users->reject(function ($item, $key) {
            return $item->status != 1;
        });
    }
    public static function getPaidMembers() {
        return Role::find(config('custom.paid_member_code'))->users->reject(function ($item, $key) {
            return $item->status != 1;
        });
    }

    public static $registerRule = [
        'nick' => 'required|string',
        'mobile' => 'required|mobile',
        'invite_no'   => 'alpha_num',
        'mb_verify_code'   => 'required|alpha_num',
        'captcha' => 'required|captcha',
    ];

    public static function register($data) {
        if(!is_array($data))
            return false;
        try {
            $u = []; // use info
            $p = []; // profile info
            $u['uid'] = genId();
            $u['username'] = $data['nick'];
            $u['status'] = 1;
            $u['mobile'] = $data['mobile'];
            $p['invite_no'] = isset($data['invite_no']) ? $data['invite_no'] : '';

            DB::transaction(function () use ($u, $p) {
                $user = User::create($u);
                $p['user_id'] = $user->id;
                $faker = Faker\Factory::create();
                $p['avatar'] = $faker->imageUrl(50,50);
                $profile = UserProfile::create($p);
                $user->roles()->attach(config('custom.register_member_code'));
            });
            Log::write('common', 'User register success:'.http_build_query($data));
        } catch(\Exception $e) {
            Log::write('common', 'User register failed:'.$e->getMessage());
            return false;
        }
        return true;
    }

    public static function isRegisterd($data) {
        if(!is_array($data))
            return false;
        $user = User::where([
            'mobile' => $data['mobile']
        ])->first();
        return $user ? true : false;
    }

    public static function nickUsed($nick) {
        if(!$nick)
            return false;
        $user = User::where([
            'username' => $nick
        ])->first();
        return $user ? true : false;
    }
}
