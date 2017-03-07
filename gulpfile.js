const gulp = require('gulp');
const elixir = require('laravel-elixir');


/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */


/**
 * Default gulp is to run this elixir stuff
 */
elixir(function(mix) {

    mix.styles([
        '../bower/AdminLTE/bootstrap/css/bootstrap.min.css',
        '../bower/AdminLTE/dist/css/AdminLTE.min.css',
        '../bower/AdminLTE/dist/css/skins/skin-purple.min.css',
        '../bower/AdminLTE/plugins/select2/select2.min.css',
        '../bower/font-awesome/css/font-awesome.min.css',
        '../bower/Ionicons/css/ionicons.min.css',
        '../bower/bootstrap-fileinput/css/fileinput.min.css',
        'purple.css',
        'amaran.min.css',
        'my.css'
    ], 'public/css/all_bk.css');

    mix.scripts([
        '../bower/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js',
        '../bower/AdminLTE/bootstrap/js/bootstrap.min.js',
        '../bower/AdminLTE/dist/js/app.min.js',
        '../bower/AdminLTE/plugins/iCheck/icheck.min.js',
        '../bower/AdminLTE/plugins/select2/select2.min.js',
        '../bower/AdminLTE/plugins/select2/i18n/zh-CN.js',
        '../bower/bootstrap-fileinput/js/plugins/canvas-to-blob.min.js',
        '../bower/bootstrap-fileinput/js/fileinput.min.js',
        '../bower/bootstrap-fileinput/js/locales/zh.js',
        'jquery.amaran.min.js'
    ], 'public/js/all_bk.js');

    mix.version(['css/all_bk.css', 'js/all_bk.js', 'js/my.js']);

    mix.browserSync({
        files: ['app/**/*', 'public/**/*', 'resources/views/**/*', 'resources/assets/**/*'],
        proxy: 'keye.local.com'
    });
});
