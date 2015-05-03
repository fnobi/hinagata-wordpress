var path = require('path');
var gulp = require('gulp');

var source = require('vinyl-source-stream');
var sass = require('gulp-ruby-sass');
var varline = require('varline').gulp;

var util = require('./task-util');


/* ========================================= *
 * const
 * ========================================= */
var SRC = '.';
var SRC_SASS = [ SRC, 'sass' ].join('/');
var SRC_JS = [ SRC, 'js' ].join('/');
var SRC_JS_LIB = [ SRC_JS, 'lib' ].join('/');

var GLOB_SASS = path.join(SRC_SASS, '**/*.scss');
var GLOB_JS = path.join(SRC_JS, '**/*.js');

var DEST = '..';
var DEST_CSS = path.join(DEST, 'css');
var DEST_JS = path.join(DEST, 'js');
var DEST_JS_LIB = path.join(DEST_JS, 'lib');

var HTTP_PATH = '/';
var HTTP_PATH_CSS = path.join(HTTP_PATH, 'css');
var HTTP_PATH_JS = path.join(HTTP_PATH, 'js');
var HTTP_PATH_IMG = path.join(HTTP_PATH, 'img');


var onError = function (err) {
    console.error('Error!', err.message);
};


/* ========================================= *
 * tasks
 * ========================================= */

// css
gulp.task('sass', function () {
    return sass(SRC_SASS, { compass: true, style: 'compressed' })
        .on('error', onError)
        .pipe(gulp.dest(DEST_CSS));
});

gulp.task('css', ['sass']);


// js
gulp.task('copy-lib', function () {
    return gulp.src([
        'bower_components/html5shiv/dist/html5shiv.min.js'
    ]).pipe(gulp.dest(DEST_JS_LIB));
});

gulp.task('compile-js', function () {

    gulp.src(SRC_JS + '/theme.js')
        .pipe(varline({
            wrap: true,
            loadPath: [
                SRC_JS + '/*.js',
                SRC_JS_LIB + '/*.js'
            ],
            alias: {
                $: 'jquery',
                _: 'underscore'
            }
        }))
        .pipe(gulp.dest(DEST_JS));
});

gulp.task('js', ['copy-lib', 'compile-js']);


// default
gulp.task('default', ['css', 'js']);


// watch
gulp.task('watch', function () {
    gulp.watch(GLOB_SASS, ['sass']);
    gulp.watch(GLOB_JS, ['js']);
});
