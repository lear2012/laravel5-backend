/**
 * @file
 * @author jinguangguo
 * @date 2016/1/11
 */

var gulp = require('gulp');
var Hapi = require('hapi');
var through2 = require('through2');
var autoprefixer = require('gulp-autoprefixer');
var gulpBrowserify2 = require('gulp-browserify2');
var gulpSass = require('gulp-sass');
var gulpSourcemaps = require('gulp-sourcemaps');
var to5ify = require('6to5ify');

// mock数据
var mocks = require('../mock/mock_index').mocks;
var mocksAdmin = require('../mock/mock_admin').mocks;

// 环境配置
var env = require('../env.js').env;

// 默认前端调试服务地址
var debugServerSetting = {
    host: '127.0.0.1',
    port: 8003

};

// 默认接口代理地址
var apiProxySetting = {
     host: '123.57.61.253',
     port: 8008

};

if (env.debugServerSetting && env.apiProxySetting) {
    debugServerSetting = env.debugServerSetting;
    apiProxySetting = env.apiProxySetting;
}

/**
 * 获取请求文件信息
 * @param requestPath
 * @returns {{directoryPath: string, filePath: string, fileType: string, fileName: string}}
 */
function getFileInfo(requestPath) {
    var filePath = '.' + requestPath;
    var lastIndex = filePath.lastIndexOf('.');
    var directoryPath = filePath.substring(0, lastIndex);
    var fileType = filePath.substring(lastIndex + 1);
    var fileName = filePath.substring(filePath.lastIndexOf('/') + 1, lastIndex);
    return {
        directoryPath: directoryPath,
        filePath: filePath,
        fileType: fileType,
        fileName: fileName
    };
}

gulp.task('server:start', function() {

    "use strict";

    var server = new Hapi.Server();

    server.connection(debugServerSetting);

    server.route({
        method: 'POST',
        path: '/{params*}',
        config: {
            handler: function (request, reply) {
                return reply.proxy({
                    passThrough: true,
                    host: apiProxySetting.host,
                    port: apiProxySetting.port,
                    protocol: 'http'
                });
            },
            payload: {
                output: 'stream',
                parse: false
            }
        }
    });

    // 静态资源、GET请求代理
    server.route({
        method: 'GET',
        path: '/{params*}',
        handler: function(request, reply) {
            console.log('Requesting: ' + request.path);

            var fileInfo = getFileInfo(request.path);

            // api接口请求代理到相应机器
            if (/^\/api/.test(request.path)) {
                console.log('Proxying: ' + request.path);
                return reply.proxy({
                    passThrough: true,
                    host: apiProxySetting.host,
                    port: apiProxySetting.port,
                    protocol: 'http'
                });
            }
            
            if (/(bower_components|dep)/g.test(fileInfo.filePath) === true) {
                console.log('bower_components');
                reply.file(fileInfo.filePath);
                return;
            }

            if (request.path === '/' || request.path === '/en' || request.path === '/ch') {
                return reply.redirect('/app/index.html');
            }

            // 静态资源
            switch (fileInfo.fileType) {

                case 'html':
                    reply.file(fileInfo.filePath);
                    break;

                case 'scss':
                    gulp.src(fileInfo.filePath.replace('.css','.scss'))
                        .pipe(gulpSourcemaps.init())
                        .pipe(gulpSass())
                        .pipe(autoprefixer({
                            browsers: ['last 2 versions', 'Firefox >= 20', 'last 3 Safari versions', 'last 2 Explorer versions']
                        }))
                        .pipe(gulpSourcemaps.write())
                        .pipe(
                            through2.obj(
                                function (file) {
                                    reply(file.contents.toString()).type('text/css')
                                }
                            )
                        );
                    break;

                case 'js':
                case 'jsx':
                    gulp.src(fileInfo.filePath)
                        .pipe(gulpSourcemaps.init())
                        .pipe(gulpBrowserify2({
                            fileName: 'bundle.js',
                            transform: to5ify,
                            options: {
                                debug: true
                            }
                        }))
                        .pipe(gulpSourcemaps.write())
                        .pipe(through2.obj(function (file) {
                            reply(file.contents.toString());
                        }));

                    break;

                // font字体
                case 'eot':
                case 'ttf':
                case 'woff':
                case 'svg':
                    reply.file(fileInfo.filePath.replace('fonts', '../icomoon/fonts'));
                    break;

                default:
                    reply.file(fileInfo.filePath);
            }

        }
    });

    // 添加mock数据
    //mocks.forEach(function (item, index) {
    //    console.log('add mock');
    //    server.route(item);
    //});
    //
    //mocksAdmin.forEach(function (item, index) {
    //    server.route(item);
    //});

    // 启动server
    server.start(function() {
        console.log('Server running at:', server.info.uri);
    });

});
