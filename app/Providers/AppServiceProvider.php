<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use App\Helpers\Utils;
use Illuminate\Support\Facades\Validator;
use EasyWeChat;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale('zh');
        $this->extendRules();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RepositoryServiceProvider::class);
        if($this->app->environment() !== 'production') {
            //$this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
            //$this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            //$this->app->register('Iber\Generator\ModelGeneratorProvider');
        }
        $this->app->bind('channellog', 'App\Helpers\ChannelWriter');
    }

    private function extendRules()
    {
        Validator::extend('mobile', function ($attribute, $value, $parameters) {
            return Utils::isMobile($value);
        });
        Validator::extend('code', function ($attribute, $value, $parameters) {
            return strlen($value) != 6 || !preg_match("/[0-9]{6}/", $value);
        });
        Validator::extend('password', function ($attribute, $value, $parameters) {
            return preg_match("/^(?:(?!\s).){8,}$/", $value);
        });
//        Validator::extend('captcha', function ($attribute, $value, $parameters) {
//            return !Captcha::check($value);
//        });
        Validator::extend('real_name', function ($attribute, $value, $parameters) {
            $name = [];
            preg_match("/[\x{4e00}-\x{9fa5}]{2,15}/u", $value, $name);
            return $value && implode($name) == $value;
        });
        Validator::extend('id_no', function ($attribute, $value, $parameters) {
            return  preg_match("/^\d{17}(\d|X|x)$/", $value);
        });
        Validator::extend('100x', function ($attribute, $value, $parameters) {
            return  preg_match("/^[1-9][0-9]*0{2}$/", $value);
        });
        Validator::extend('nick', function ($attribute, $value, $parameters) {
            return  preg_match("/^[\u4e00-\u9fa5_a-zA-Z0-9]+$/", $value);
        });
//        $smsTime = 5;//临时变量储存剩余过期时间
//        Validator::extend('sms', function ($attribute, $value, $parameters) use(&$smsTime) {
//            $time = Sms::check_mobile_sendable($value);
//            $smsTime = $parameters['time'] = $time;
//            return !$time;
//        });
//        Validator::replacer('sms', function ($message, $attribute, $rule, $parameters) use(&$smsTime){
//            return str_replace(':time', $smsTime, $message);
//        });
    }
}
