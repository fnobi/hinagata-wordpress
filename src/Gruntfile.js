module.exports = function (grunt) {
    var path = require('path');
    var config = {};

    // dirs
    var JS = 'js';
    var JS_LIB = 'js/lib';
    var CSS = 'css';
    var SASS = 'sass';
    var IMG = 'img';
    var TEST = 'test';

    
    // js library alias
    var alias = {
        $: 'jquery',
        _: 'underscore'
    };


    // dev config
    var DEV = 'dev';
    var devTasks = [];
    var devSitePath = '../';
    var devHttpPath = '/';


    // basic
    {
        config.pkg =  grunt.file.readJSON('package.json');
    }

    // este watch
    {
        grunt.loadNpmTasks('grunt-este-watch');
        grunt.registerTask('watch', 'esteWatch');

        config.esteWatch = {
            options: {
                dirs: [],
                livereload: { enabled: false }
            }
        };
    }

    // auto deps
    {
        grunt.loadNpmTasks('grunt-auto-deps');
        config.auto_deps = {};
    
        var autoDepsDefaultConfig = {
            scripts: ['theme'],
            loadPath: [JS + '/*.js', JS_LIB + '/*.js'],
            ignore: [],
            forced: [],
            wrap: true,
            alias: alias
        };

        // dev
        config.auto_deps[DEV] = util.clone(autoDepsDefaultConfig, {
            dest: path.resolve(devSitePath, JS)
        });
        devTasks.push('auto_deps:' + DEV);

        // watch
        config.esteWatch.options.dirs.push(JS + '/*.js');
        config.esteWatch['js'] = function () { return 'auto_deps:' + DEV; };
    }
    
    
    // js lib copy
    (function () {
        grunt.loadNpmTasks('grunt-contrib-copy');

        var libs = [
            'bower_components/html5shiv/src/html5shiv.js'
        ];
    
        var files = [];
        libs.forEach(function (lib) {
            files.push({
                expand: true,
                flatten: true,
                src: lib,
                dest: path.resolve(devSitePath, JS_LIB)
            });
        });

        config.copy = {};
        config.copy[DEV] = { files: files };
        devTasks.push('copy:' + DEV);
    })();
    
    
    // compass
    {
        grunt.loadNpmTasks('grunt-contrib-compass');
        config.compass = {};

        var compassDefaultConfig = {
            options: {
                sassDir: SASS,
                outputStyle: 'compressed'
            }
        };

        // dev
        config.compass[DEV] = util.clone(compassDefaultConfig, {
            options: {
                cssDir                  : path.resolve(devSitePath, CSS),
                javascriptsDir          : path.resolve(devSitePath, JS),
                imagesDir               : path.resolve(devSitePath, IMG),
                generatedImagesPath     : path.resolve(devSitePath, IMG),
                httpImagesPath          : path.resolve(devHttpPath, IMG),
                httpGeneratedImagesPath : path.resolve(devHttpPath, IMG)
            }
        });
        devTasks.push('compass:' + DEV);
        
        // watch
        config.esteWatch.options.dirs.push(SASS + '/*.scss');
        config.esteWatch.options.dirs.push(SASS + '/**/*.scss');
        config.esteWatch['scss'] = function () { return 'compass:' + DEV; };
    
    }
    
    
    // set as task
    grunt.registerTask(DEV, devTasks);

    // init
    grunt.initConfig(config);
    grunt.registerTask('default', [DEV]);
};


var util = {
    clone: function (obj, opts) {
        opts = opts || {};

        var newObj = {};

        var key;
        for (key in obj) {
            if (typeof obj[key] == 'object') {
                if (isNaN(obj[key].length)) {
                    newObj[key] = util.clone(obj[key], opts[key]);
                } else {
                    newObj[key] = opts[key] || obj[key];
                }
            } else {
                newObj[key] = opts[key] || obj[key];
            }
        }
        for (key in opts) {
            if (!obj[key]) {
                newObj[key] = opts[key];
            }
        }

        return newObj;
    }
};

