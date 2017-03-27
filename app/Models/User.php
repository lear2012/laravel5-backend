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
use App\Helpers\Utils;
use Auth;

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
    protected $fillable = ['uid', 'username', 'mobile', 'email', 'password', 'is_front', 'status'];

    protected $appends = ['vehicle'];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public static $userColors = [
        1 => 'red',
        2 => 'green',
        3 => 'yellow',
        4 => 'light-blue',
    ];

    public function getStatusAttribute($value)
    {
        return $value == 1 ? '正常' : '已冻结';
    }

    public function getVehicleAttribute()
    {
        if(!is_null($this->profile))
            return $this->profile->brand.''.$this->profile->series.' '.$this->profile->year;
        return '';
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

    function profile() {
        return $this->hasOne('App\Models\UserProfile');
    }

    public function roles(){
        return $this->belongsToMany('App\Models\Role');
    }

    public static function getExpdrivers() {
        return Role::find(config('custom.exp_driver_code'))->users->reject(function ($item, $key) {
            return $item->getOriginal('status') != 1 || $item->is_front == 0;
        });
    }
    public static function getPaidMembers() {
        return Role::find(config('custom.paid_member_code'))->users->reject(function ($item, $key) {
            return $item->getOriginal('status') != 1;
        });
    }

    public static $registerRule = [
        'nick' => 'required|string',
        'mobile' => 'required|mobile',
        //'password' => 'required|confirmed',
        //'password_confirmation' => 'required',
        'invite_no'   => 'alpha_num',
        'mb_verify_code'   => 'required|alpha_num',
        'captcha' => 'required|captcha',
    ];

    public static function register($data) {
        if(!is_array($data))
            return false;
        $user = null;
        $wechatUser = session('wechat.oauth_user'); // 拿到授权用户资料
        try {
            $u = []; // use info
            $p = []; // profile info
            $u['uid'] = genId();
            $u['username'] = $data['nick'];
            $u['status'] = 1;
	        $u['is_front'] = 0;
            $u['mobile'] = $data['mobile'];
            //$u['password'] = \Hash::make($data['password']);
            $p['invite_no'] = isset($data['invite_no']) ? $data['invite_no'] : '';
            $p['wechat_id'] = $wechatUser->id;
            $p['wechat_no'] = $wechatUser->nickname;
            $p['avatar'] = $wechatUser->avatar;
            $wechatInfo = $wechatUser->getOriginal();
            $p['sex'] = $wechatInfo['sex'];
            $user = DB::transaction(function () use ($u, $p, $data) {
                $user = User::create($u);
                $p['user_id'] = $user->id;
                //$faker = Faker\Factory::create();
                //$p['avatar'] = $faker->imageUrl(50,50);
                $profile = UserProfile::create($p);
                $user->roles()->attach(config('custom.register_member_code'));
		Log::write('common', 'User register success:'.http_build_query($data));
		return $user;
            });
        } catch(\Exception $e) {
            Log::write('common', 'User register failed:'.$e->getMessage());
            return false;
        }
        return $user;
    }

    public static function isRegisterd($data) {
        if(!is_array($data))
            return false;
        $wechatUser = session('wechat.oauth_user'); // 拿到授权用户资料
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

    public static function setRegisterOrder(){
        $wechatUser = session('wechat.oauth_user'); // 拿到授权用户资料
        if(!$wechatUser)
            return false;
        $order = Utils::getStaticOrderInfo('register');
        $order['openid'] = $wechatUser->id;
        // check if the user has already got an register order
        $orderCheck = \App\Models\Order::where([
            'wechat_openid' => $order['openid'],
            'order_type' => 1
        ])->first();
        if($orderCheck) {
            // 如果有未支付的订单，直接返回订单
            $order['out_trade_no'] = $orderCheck->oid;
            return $order;
        }
        // save info into db
        $dbOrder = new Order();
        $oid = genId();
        $dbOrder->oid = $oid;
        $dbOrder->title = $order['body'];
        $dbOrder->detail = $order['detail'];
        $dbOrder->wechat_openid = $order['openid'];
        $dbOrder->wechat_no = $wechatUser->nickname;
        $dbOrder->amount = $order['total_fee'];
        $dbOrder->order_type = 1;
        $dbOrder->status = 1;
        if($dbOrder->save()) {
            $order['out_trade_no'] = $oid;
            Log::write('wechat', '订单生成成功for who:'.$wechatUser->nickname);
        } else {
            Log::writeLog('wechat', 'error', '订单生成失败for who:'.$wechatUser->nickname);
            return [];
        }
        return $order;
    }

    public static function isWechatRegisterUser() {
        $wechatUser = session('wechat.oauth_user'); // 拿到授权用户资料
        if(!isset($wechatUser) || empty($wechatUser))
            return false;
        Log::write('common', 'Wechat User:'.$wechatUser->nickname.', openid:'.$wechatUser->id.' access register page');
        $profile = UserProfile::where([
            'wechat_id' => $wechatUser->id
        ])->first();
        if($profile) {
            Log::write('common', 'Wechat User:'.$wechatUser->nickname.', openid:'.$wechatUser->id.' already registered, redirect to member list');
            $user = User::find($profile->user_id);
            Auth::login($user);
            return $user;
        }
        return false;
    }


}
