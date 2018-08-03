const elixir = require('laravel-elixir');

require('laravel-elixir-browserify-official');
require('laravel-elixir-vueify');

/*
 |--------------------------------------------------------------------------
 | Управление ресурсами Elixir
 |--------------------------------------------------------------------------
 |
 | Elixir предоставляет чистый и гибкий API для определение базовых задач Gulp
 | для вашего приложения Laravel. По умолчанию мы компилируем Sass-файл
 | для вашего приложения, а также публикуем ресурсы вендора.
 |
 */

// elixir(mix => {
//     mix.sass('app.scss')
//     .webpack('app.js');
// });
var webpackOpt = {
    resolve: {
        alias: {
            vue: 'vue'
        }
    }
};

gulp.task('build', function () {
    elixir(function(mix) {
        mix.browserify('app.js');
    });
});

gulp.task('watch', function () {
    gulp.watch('app.js', ['build']);
    console.log('good')
});





// var elixir = require('laravel-elixir');
// var gutils = require('gulp-util');
// var  b = elixir.config.js.browserify;
//
// if(gutils.env._.indexOf('watch') > -1){
//     b.plugins.push({
//         name: "browserify-hmr",
//         options : {}
//     });
// }
//
// b.transformers.push({
//     name: "vueify",
//     options : {}
// });
//
// elixir(function(mix) {
//     mix.sass('app.scss')
//         .browserify('app.js')
//         .version(['css/app.css', 'js/app.js']);
// });


// var gulp = require('gulp');
// var browserify = require('browserify');
// var source = require('vinyl-source-stream');
// var babelify = require('babelify');
//
// gulp.task('js', function() {
//     return browserify({ entries: 'src/js/main.js'})
//         .transform(babelify, { presets: ['es2015'] })
//         .transform(vueify)
//         .bundle()
//         .pipe(source('app.js'))
//         .pipe(gulp.dest('public/js'))
//         .pipe(connect.reload());
// });

// gulp.task("js", function () {
//     browserifyInstance = browserify({
//  "entries": path.join(modulePath, "src/js/main.js"),
// "noParse": ["vue.js"],
// "read": false,
//  "standalone": "JngVueChat",
// "plugin": argv.w || argv.watch ? [watchify] : [],
//  "cache": {},
// "packageCache": {},
// "debug": !isProd
// }).transform("envify", {
//     "global": true,
//  "NODE_ENV": process.env.NODE_ENV
//     })
// .transform(babelify)
//         .transform(vueify)
//         .on("update", methods.bundleJS);
//     return methods.bundleJS();
// });




// gulp.task('build:storages', function () {
//     var b = browserify({
//         entries: ['www/sites/all/modules/custom/wsites/wsites_storages/js/src/app.js'],
//         debug: true
//     });
//
//     b.transform(babelify, { presets: ['es2015', 'react'] });
//     return b.bundle()
//         .pipe(source('app.js'))
//         .pipe(gulp.dest('www/sites/all/modules/custom/wsites/wsites_storages/js'));
// });
//
// gulp.task('watch:storages', function () {
//     gulp.watch('www/sites/all/modules/custom/wsites/wsites_storages/js/src/**/*.js', ['build:storages']);
// });
//
// gulp.task('default', ['watch:storages', 'build:storages']);