const gulp = require('gulp');
const elixir = require('laravel-elixir');
const imagemin = require('gulp-imagemin');
const del = require('del');

elixir.extend('min_image', function() {

    new elixir.Task('clean', function() {
        // You can use multiple globbing patterns as you would with `gulp.src`
        return del(['public/images', 'public/img']);
    });

    new elixir.Task('min_image1', function() {
        return gulp.src([
            'resources/assets/images/**/*'
        ]).pipe(imagemin({optimizationLevel: 5}))
            .pipe(gulp.dest('public/images'));
    });

    new elixir.Task('min_image2', function() {
        return gulp.src([
            'resources/assets/img/**/*'
        ]).pipe(imagemin({optimizationLevel: 5}))
            .pipe(gulp.dest('public/img'));
    });

    new elixir.Task('min_image3', function() {
        return gulp.src([
            'resources/assets/css/purple@2x.png'
        ]).pipe(imagemin({optimizationLevel: 5}))
            .pipe(gulp.dest('public/css'));
    });

    // this.registerWatcher('date_logger', '/**/*.js');
    //return this.queueTask(['min_image1', 'min_image2', 'min_image3']);

});
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

    // for frontend css/js
    mix.styles([
        'front.css',
        'swiper.min.css',
        '../bower/js-offcanvas/dist/_css/js-offcanvas.css',
        '../bower/sweetalert/dist/sweetalert.css',
        '../bower/loaders.css/loaders.min.css',
        'main.css'
    ], 'public/css/all.css');
    mix.scripts([
        'jquery-2.2.3.min.js',
        'url.min.js',
        '../bower/validator-js/validator.min.js',
        '../bower/js-offcanvas/dist/_js/js-offcanvas.min.js',
        '../bower/noty/js/noty/packaged/jquery.noty.packaged.min.js',
        '../bower/sweetalert/dist/sweetalert.min.js',
        '../bower/swiper/dist/js/swiper.jquery.min.js',
        '../../../node_modules/jquery-countto/jquery.countTo.js',
        '../../../node_modules/vanilla-lazyload/dist/lazyload.transpiled.min.js',
        '../../../node_modules/ramjet/dist/ramjet.umd.min.js',
        'jweixin-1.2.0.js',
        'lodash.min.js',
        'Maillist.js',
        'jquery.ajaxfileupload.js',
        'main.js'
    ], 'public/js/all.js');

    // for round china css/js
    mix.styles([
        '../bower/sweetalert/dist/sweetalert.css',
        '../bower/swiper/dist/css/swiper.min.css',
        'orange.css',
        'vendor.css',
        'round.css',
    ], 'public/css/roundchina.css');
    mix.scripts([
        'jquery-2.2.3.min.js',
        'lodash.min.js',
        'jweixin-1.2.0.js',
        '../bower/jquery_lazyload/jquery.lazyload.js',
        '../bower/validator-js/validator.min.js',
        '../bower/AdminLTE/plugins/iCheck/icheck.min.js',
        '../bower/sweetalert/dist/sweetalert.min.js',
        '../bower/swiper/dist/js/swiper.jquery.min.js',
        '../bower/mojs/build/mo.min.js',
        'manifest.js',
        'vendor.js',
        'round.js',
        'round_china.js'
    ], 'public/js/roundchina.js');

    // for xinjiang css/js
    mix.styles([
        '../bower/sweetalert/dist/sweetalert.css',
        '../bower/swiper/dist/css/swiper.min.css',
        //'../bower/fullpage.js/dist/jquery.fullpage.min.css',
        'animate.min.css',
        'video-js.min.css',
        'xinjiang.css',
    ], 'public/css/xinjiang-final.css');
    mix.scripts([
        'jquery-2.2.3.min.js',
        'jweixin-1.2.0.js',
        '../bower/validator-js/validator.min.js',
        '../bower/sweetalert/dist/sweetalert.min.js',
        '../bower/swiper/dist/js/swiper.jquery.min.js',
        'swiper.animate.min.js',
        'video.min.js',
        'xinj.js'
    ], 'public/js/xinjiang-final.js');

    mix.scripts([
        'jquery-2.2.3.min.js',
        'jweixin-1.2.0.js',
        'video.min.js',
        'xinj.video.js',
    ], 'public/js/xinjvideo.js');

    // for backend css/js
    mix.styles([
        '../bower/AdminLTE/bootstrap/css/bootstrap.min.css',
        '../bower/AdminLTE/dist/css/AdminLTE.min.css',
        '../bower/AdminLTE/dist/css/skins/skin-purple.min.css',
        '../bower/AdminLTE/plugins/select2/select2.min.css',
        '../bower/font-awesome/css/font-awesome.min.css',
        '../bower/Ionicons/css/ionicons.min.css',
        '../bower/bootstrap-fileinput/css/fileinput.min.css',
        '../bower/datatables.net-bs/css/dataTables.bootstrap.min.css',
        '../bower/sweetalert/dist/sweetalert.css',
        'purple.css',
        'amaran.min.css',
        'my.css'
    ], 'public/css/all_bk.css');

    mix.scripts([
        '../bower/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js',
        '../bower/AdminLTE/bootstrap/js/bootstrap.min.js',
        '../bower/AdminLTE/dist/js/app.min.js',
        '../bower/AdminLTE/plugins/iCheck/icheck.min.js',
        '../bower/AdminLTE/plugins/select2/select2.full.min.js',
        '../bower/AdminLTE/plugins/select2/i18n/zh-CN.js',
        '../bower/bootstrap-fileinput/js/plugins/canvas-to-blob.min.js',
        '../bower/bootstrap-fileinput/js/fileinput.min.js',
        '../bower/bootstrap-fileinput/js/locales/zh.js',
        '../bower/datatables.net/js/jquery.dataTables.min.js',
        '../bower/datatables.net-bs/js/dataTables.bootstrap.min.js',
        '../../../node_modules/moment/min/moment-with-locales.min.js',
        '../bower/sweetalert/dist/sweetalert.min.js',
        '../bower/mojs/build/mo.min.js',
        'jquery.amaran.min.js',
        'url.min.js',
        // custom js
        'my.js',
        'keye_route.js',
        'keye_contact.js',
        'keye_enrollment.js',
        'keye_lift.js',
        'keye_club.js',
        'topic_image.js',
        'chetie_apply.js',
        'section_enrollment.js',
        'camera_enrollment.js'
    ], 'public/js/all_bk.js');

    // images
    //mix.min_image();  // for production

    // for debug js, comment it out when production
    // mix.copy('public/css/all.css', 'public/css/all_debug.css');
    // mix.copy('public/js/all.js', 'public/js/all_debug.js');
    // mix.copy('public/css/all_bk.css', 'public/css/all_bk_debug.css');
    // mix.copy('public/js/all_bk.js', 'public/js/all_bk_debug.js');

    // versioning // for production
    mix.version([
        'css/all.css',
        'js/all.js',
        'css/all_bk.css',
        'js/all_bk.js',
        'css/roundchina.css',
        'js/roundchina.js',
        'css/xinjiang-final.css',
        'js/xinjiang-final.js',
        'js/xinjvideo.js',
    ], 'public');
    // watch
    // BrowserSync.init({
    //     server: {
    //         baseDir: "./public"
    //     }
    // });
    //
    // mix.BrowserSync({
    //     proxy 			: "localhost:8000",
    //     logPrefix		: "Laravel Eixir BrowserSync",
    //     logConnections	: false,
    //     reloadOnRestart : false,
    //     notify 			: false
    // });
});
