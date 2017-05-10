'use strict';

var gulp = require('gulp'),
        concat = require('gulp-concat'),
        uglify = require('gulp-uglify'),
        imagemin = require('gulp-imagemin'),
        pngquant = require('imagemin-pngquant'),
        gls = require('gulp-live-server'),
        jshint = require('gulp-jshint'),
        stylish = require('jshint-stylish'),
        less = require('gulp-less'),
        LessPluginCleanCSS = require('less-plugin-clean-css'),
        LessAutoprefix = require('less-plugin-autoprefix');

var cleancss = new LessPluginCleanCSS({advance: true});
var autoprefix = new LessAutoprefix({browsers: ['last 2 versions']});

gulp.task('default', ['less', 'js', 'img', 'wacth', 'serve']);

gulp.task('less', function () {
    return gulp.src('public/assets/src/less/**/*.less')
            .pipe(concat('main.min.css'))
            .pipe(less({
                plugins: [autoprefix, cleancss]
            }))
            .pipe(gulp.dest('public/assets/css'));
});


gulp.task('js', function () {
    return gulp.src('assets/src/js/**/*.js')
            .pipe(concat('script.min.js'))
            .pipe(uglify())
            .pipe(gulp.dest('public/assets/js'));
});

gulp.task('img', function () {
    return gulp.src('public/assets/src/img/*')
            .pipe(imagemin({
                progressive: true,
                svgoPlugins: [{removeViewBox: false}],
                use: [pngquant()]
            }))
            .pipe(gulp.dest('public/assets/img'));
});

gulp.task('lint', function () {
    return gulp.src('public/assets/src/js/**/*.js')
            .pipe(jshint())
            .pipe(jshint.reporter(stylish));
});

gulp.task('wacth', function () {
    gulp.watch('public/assets/src/less/**/*.less', ['less']);
    gulp.watch('public/assets/src/js/**/*.js', ['js']);
    gulp.watch('public/assets/src/img/*', ['image']);
});

gulp.task('serve', function () {
    var server = gls.static('./', 8000);
    server.start();
    gulp.watch('public/assets/css/**/*.css', function (file) {
        gls.notify.apply(server, [file]);
    });
    gulp.watch('public/assets/js/**/*.js', function (file) {
        gls.notify.apply(server, [file]);
    });
    gulp.watch('public/assets/img/**/*', function (file) {
        gls.notify.apply(server, [file]);
    });
});