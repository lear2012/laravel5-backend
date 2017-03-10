<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use ChannelLog as Log;
use EasyWeChat\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class WechatController extends Controller {

    const PROFILE = 'profile'; //账户概览
    const KF = 'kf'; //客服
    const ABOUT_US = 'http://mp.weixin.qq.com/s?__biz=MzI3MDEyODQ2Ng==&mid=403322342&idx=2&sn=01ee08a1a9a42acb69c977d142563c44&scene=0#wechat_redirect';
    const LOTTERY = 'http://mp.weixin.qq.com/s?__biz=MzI3MDEyODQ2Ng==&mid=403713872&idx=1&sn=0c3db1439b17d6963b4c08e99165e6fb&scene=0&previewkey=zwaX5f3SM5tf3CWoK4TFYsNS9bJajjJKzz%2F0By7ITJA%3D#wechat_redirect';
    const GUIDE = 'http://mp.weixin.qq.com/s?__biz=MzI3MDEyODQ2Ng==&mid=403322342&idx=3&sn=6b25d9b2dafa5271a08515cc1d2c1e98&scene=0&previewkey=zwaX5f3SM5tf3CWoK4TFYsNS9bJajjJKzz%2F0By7ITJA%3D#wechat_redirect';
    const ACTIVITIES = 'http://mp.weixin.qq.com/s?__biz=MzI3MDEyODQ2Ng==&mid=403650357&idx=2&sn=1ecf5d0e27d28fc15b875550630478f9#wechat_redirect';

    private $openid;
    private $menu;
    private $qrcode;

    public function __construct()
    {
        $this->menu = app('wechat')->menu;
        $this->qrcode = app('wechat')->qrcode;
    }

    public function getMenu(){
        return $this->menu->current();
    }

    public function getSetMenu(){
        if (env('APP_ENV') == 'local') {
            $buttons = [
                [
                    "type" => "view",
                    "name" => "我要投资",
                    "url"  => config('nxd.host')
                ],
                [
                    "name"       => "我的账户",
                    "sub_button" => [
                        [
                            "type" => "view",
                            "name" => "资产概览",
                            "url"  => config('nxd.host') . 'wechat/account/assets'
                        ],
                        [
                            "type" => "view",
                            "name" => "我要充值",
                            "url"  => config('nxd.host') . 'wechat/account/recharge'
                        ],
                        [
                            "type" => "view",
                            "name" => "我要提现",
                            "url"  => config('nxd.host') . 'wechat/account/withdraw'
                        ],
                    ],
                ],
                [
                    "name"       => "更多服务",
                    "sub_button" => [
                        ["type" => "view", "name" => "抽奖活动", "url" => config('nxd.host').'wechat/lottery/latest'],
                        ["type" => "view", "name" => "在线咨询", "url" => 'http://kf.nxdai.com/kchat/16784'],
                        ["type" => "view", "name" => "新手指南", "url" => env('GUIDE', self::GUIDE)],
//                        ["type" => "view", "name" => "我要借款", "url" => config('nxd.host') . 'wechat/m/loan'],
                        ["type" => "view", "name" => "关于我们", "url" => env('ABOUT_US', self::ABOUT_US)],
                    ],
                ]
            ];

            return json_encode($this->menu->add($buttons));
        } else {
            return '';
        }
    }

    public function getAuth(Auth $auth){
        $to = Input::get('to');
        if (!$to) {
            return redirect()->route('wechat.index');
        } else {
            $auth->redirect($to, 'snsapi_userinfo');
        }
    }

    public function auth() {

    }
    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve(Request $request){
        Log::write('wechat', 'request arrived.');
        $server = app('wechat')->server;
        Log::write('wechat', 'query params:'.http_build_query($request->all()));
//        $server->setMessageHandler(function($message){
//            Log::write('common', 'WeChatMessage:' . json_encode($message));
//            $this->openid = $message->FromUserName;
//            session(['openid' => $this->openid]);
//            return "欢迎关注 overtrue！";
//        });
//        Log::write('common', 'return response.');
//        return $server->serve();
    }

    public function getIndex() {

    }

    public function upload(){
        $media   = new Media('wx8e883164d9342b1f', 'e73145bd0fdef28ea54b0b3608061c33');
        $imageId = $media->image('/Users/qloog/Downloads/demo_wx.png'); // 上传并返回媒体ID

        $message = Message::make('image')->media($imageId);
        Log::info('message: ' . var_export($message, true));
    }

    public function message()
    {
        $server = new Server('wx8e883164d9342b1f', 'e73145bd0fdef28ea54b0b3608061c33');

        $server->on('event', 'subscribe', function($event){
                return  Message::make('text')->content('您好！欢迎关注 overtrue');
            });
    }

    public function news()
    {
        $news = Message::make('news')->items(function(){
                return array(
                    Message::make('news_item')->title('测试标题'),
                    Message::make('news_item')->title('测试标题2')->description('好不好？'),
                    Message::make('news_item')->title('测试标题3')->description('好不好说句话？')->url('http://baidu.com'),
                    Message::make('news_item')->title('测试标题4')->url('http://baidu.com/abc.php')->picUrl('http://mmbiz.qpic.cn/mmbiz/EWBwscfHhF9mWxDBqJSTfS3ByNEicPrQzicHS5RicGsPOSkuqib2SOxuPFEGr3wnvztCae58ps21TnQVKEJb2YBEaA/640?wx_fmt=jpeg&tp=webp&wxfrom=5'),
                );
            });
        var_dump($news);
    }

    public function url()
    {
        $url = new Url('wx8e883164d9342b1f', 'e73145bd0fdef28ea54b0b3608061c33');
        $shortUrl = $url->short('http://overtrue.me/open-source');
        var_dump($shortUrl);
    }

    public function user()
    {
//        $appid = Config::get('webchat.appid');
        $userService = new User('wx8e883164d9342b1f', 'e73145bd0fdef28ea54b0b3608061c33');
        $result = $userService->lists();
        var_dump($result);
    }
    

    public function menu()
    {
        $menu = new Menu('wx8e883164d9342b1f', 'e73145bd0fdef28ea54b0b3608061c33');
        $m = $menu->get();
        var_dump($m);exit;
        $button = new MenuItem("菜单");

        $menus = array(
            new MenuItem("今日歌曲", 'click', 'V1001_TODAY_MUSIC'),
            $button->buttons(array(
                    new MenuItem('搜索', 'view', 'http://www.soso.com/'),
                    new MenuItem('视频', 'view', 'http://v.qq.com/'),
                    new MenuItem('赞一下我们', 'click', 'V1001_GOOD'),
                )),
        );

        try {
            $menu->set($menus);// 请求微信服务器
            echo '设置成功！';
        } catch (\Exception $e) {
            echo '设置失败：' . $e->getMessage();
        }
    }

    public function profile() {
        $user = Auth::user();
        return view('frontend.profile');
    }
}
