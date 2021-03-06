'use strict';

var gulp = require('gulp');
var yaml = require('js-yaml');
var fs = require('fs');
var filter = require('gulp-filter');
var less = require('gulp-less');
var concat = require('gulp-concat');
var autoprefixer = require('gulp-autoprefixer');
var replace = require('gulp-replace');
var csso = require('gulp-csso');
var jshint = require('gulp-jshint');
var uglify = require('gulp-uglify');
var imagemin = require('gulp-imagemin');
var mainBowerFiles = require('main-bower-files');
var flatten = require('gulp-flatten');
var runSequence = require('run-sequence');
var browserSync = require('browser-sync');
var del = require('del');
var cached = require('gulp-cached');
var remember = require('gulp-remember');
var newer = require('gulp-newer');
var mux = require('gulp-mux');
var diff = require('deep-diff').diff;
var path = require('path');
var beeper = require('beeper');
var chalk = require('chalk');
var gulpIf = require('gulp-if');
var jquery = require('gulp-jquery');

function logTime() {
  var date = new Date();
  var hour = date.getHours();
  hour = (hour < 10 ? '0' : '') + hour;
  var min = date.getMinutes();
  min = (min < 10 ? '0' : '') + min;
  var sec = date.getSeconds();
  sec = (sec < 10 ? '0' : '') + sec;
  return '[' + chalk.gray(hour + ':' + min + ':' + sec) + ']';
}

function mergeObject(obj1, obj2) {
  var obj3 = {};
  for (var obj1Attr in obj1) {
    obj3[obj1Attr] = obj1[obj1Attr];
  }
  for (var obj2Attr in obj2) {
    obj3[obj2Attr] = obj2[obj2Attr];
  }
  return obj3;
}

function getAbsolutePath(mPath, isFile) {
  if (!mPath) {
    beeper(1);
    console.error(logTime(), chalk.cyan('getAbsolutePath') + ': ' + chalk.red('Path is undefined.'));
    return undefined;
  }
  mPath = path.normalize(mPath);
  if (!fs.existsSync(mPath) || (isFile && !fs.statSync(mPath).isFile())) {
    beeper(1);
    console.error(logTime(), chalk.cyan('getAbsolutePath') + ': ' + chalk.red((isFile ? 'File ' : '') + '\'' + mPath + '\' does\'t exist.'));
    return undefined;
  }
  return fs.realpathSync(mPath);
}

function yamlLoad(file) {
  var filePath = getAbsolutePath(file, true);
  if (typeof filePath === 'undefined') {
    return false;
  }
  var object;
  try {
    object = yaml.safeLoad(fs.readFileSync(file, 'utf8'));
  } catch (e) {
    beeper(1);
    console.error(logTime(), chalk.cyan('yamlLoad') + ': ' + chalk.red('Can\'t load data'));
    console.error(e);
    object = false;
  }
  return object;
}

function getConfigs() {
  var configs = yamlLoad('./gulp-symfony2.yml');
  if (!configs) {
    throw logTime() + ' ' + chalk.cyan('getConfigs') + ': ' + chalk.red('Can\'t get configs');
  }
  return configs;
}

var appDir = 'app';
var appPublicDir = appDir + '/Resources/public';
var srcDir = 'src';
var destDir = 'web';
var minify = false;
var parameters = {
  'gulp_symfony2_proxy': 'localhost'
};
var oldConfigs = getConfigs();
var yamlParameters = yamlLoad('app/config/parameters.yml');
if (yamlParameters) {
  parameters = mergeObject(parameters, yamlParameters.parameters);
}

function getDestFiles(objectName, file) {
  var configs = getConfigs();
  var destFiles = [];
  var object = configs[objectName];
  if (typeof configs[objectName] !== 'object') {
    return destFiles;
  }
  for (var destFile in object) {
    if (object[destFile] !== null && object[destFile].length > 0) {
      for (var i = 0; i < object[destFile].length; i++) {
        var currentFile = getAbsolutePath(object[destFile][i]);
        if (currentFile === file) {
          destFiles.push(destFile);
        }
      }
    }
  }
  return destFiles;
}

gulp.task('styles', function () {
  var configs = getConfigs();
  if (typeof configs.styles !== 'object') {
    return;
  }

  var targets = [];
  var constants = {
    destFile: '{{targetName}}'
  };
  var task = function (constant) {
    var src = configs.styles[constant.destFile].map(function (file) {
      return getAbsolutePath(file, true);
    });
    var cssPreProcessorFilter = filter('**/*.less');
    gulp.src(src)
      .pipe(cached(constant.destFile))
      .pipe(cssPreProcessorFilter)
      .pipe(less({
        paths: [appPublicDir + '/styles']
      }))
      .pipe(cssPreProcessorFilter.restore())
      .pipe(remember(constant.destFile))
      .pipe(newer(destDir + '/styles/' + constant.destFile))
      .pipe(concat(constant.destFile))
      .pipe(autoprefixer('last 1 version'))
      .pipe(replace(/([\/\w\._-]+\/)*([\w\._-]+\.(ttf|eot|woff|woff2|svg))/g, '../fonts/$2'))
      .pipe(replace(/([\/\w\._-]+\/)*([\w\._-]+\.(png|jpg|gif))/g, '../images/$2'))
      .pipe(gulpIf(minify, csso()))
      .pipe(gulp.dest(destDir + '/styles'));
  };

  for (var destFile in configs.styles) {
    if (configs.styles[destFile] !== null && configs.styles[destFile].length > 0) {
      targets.push(destFile);
    }
  }
  return mux.createAndRunTasks(gulp, task, 'styles', targets, '', constants);
});





gulp.task('scripts', function () {
  var configs = getConfigs();
  if (typeof configs.scripts !== 'object') {
    return;
  }

  var targets = [];
  var constants = {
    destFile: '{{targetName}}'
  };
  var task = function (constant) {
    var src = configs.scripts[constant.destFile].map(function (file) {
      return getAbsolutePath(file, true);
    });
    var customScriptsFilter = filter(function (file) {
      var path = file.path;
      var ignore = appPublicDir + '/vendor';
      return path.indexOf(ignore) === -1;
    });
    gulp.src(src)
      .pipe(cached(constant.destFile))
      .pipe(customScriptsFilter)
      .pipe(jshint())
      .pipe(jshint.reporter('jshint-stylish'))
      .pipe(customScriptsFilter.restore())
      .pipe(remember(constant.destFile))
      .pipe(newer(destDir + '/scripts/' + constant.destFile))
      .pipe(concat(constant.destFile))
      .pipe(gulpIf(minify, uglify()))
      .pipe(gulp.dest(destDir + '/scripts'));
  };

  for (var destFile in configs.scripts) {
    if (configs.scripts[destFile] !== null && configs.scripts[destFile].length > 0) {
      targets.push(destFile);
    }
  }
  return mux.createAndRunTasks(gulp, task, 'script', targets, '', constants);
});

gulp.task('jquery', function () {
    return jquery.src({
        release: 2, //jQuery 2 
        flags: ['-deprecated', '-event/alias', '-ajax/script', '-ajax/jsonp', '-exports/global']
    })
      .pipe(gulpIf(minify, uglify()))
      .pipe(gulp.dest(destDir + '/scripts'));
});
gulp.task('images', function () {
  var sources = [
    appPublicDir + '/images/**/*.{png,jpg,gif}',
    appPublicDir + '/vendor/**/*.{png,jpg,gif}'
  ];
  return gulp.src(sources)
    .pipe(cached('images'))
    .pipe(gulpIf(minify, imagemin({
      optimizationLevel: 3,
      interlaced: true
    })))
    .pipe(flatten())
    .pipe(gulp.dest(destDir + '/images'));
});

gulp.task('fonts', function () {
  var files = mainBowerFiles();
  files.push(appPublicDir + '/fonts/**/*');
  return gulp.src(files)
    .pipe(filter('**/*.{eot,svg,ttf,woff,woff2}'))
    .pipe(cached('fonts'))
    .pipe(flatten())
    .pipe(gulp.dest(destDir + '/fonts'));
});

gulp.task('clean', function () {
  del.sync([
    appPublicDir + '/.styles',
    destDir + '/styles/**/*',
    destDir + '/scripts/**/*',
    destDir + '/fonts/**/*',
    destDir + '/images/**/*'
  ]);
});

gulp.task('build', function (callback) {
  minify = true;
  runSequence('clean', 'styles', 'jquery', 'scripts', 'fonts', 'images', callback);
});

gulp.task('preServe', function (callback) {
  minify = false;
  runSequence('clean', 'styles', 'jquery', 'scripts', 'fonts', 'images', callback);
});
gulp.task('stream', function (callback) {
  minify = false;
  runSequence('clean', 'styles');
  gulp.watch(appPublicDir + '/styles/**/*', ['styles']);
});
gulp.task('serve', ['preServe'], function () {

  var stylesWatcher = gulp.watch(appPublicDir + '/styles/**/*', ['styles']);
  stylesWatcher.on('change', function (event) {
    if (event.type === 'deleted') {
      var destFiles = getDestFiles('styles', event.path);
      if (destFiles.length > 0) {
        destFiles.forEach(function (destFile) {
          delete cached.caches[destFile][event.path];
          remember.forget(destFile, event.path);
        });
      }
    }
    var arr = event.path.split('/');
    var file = arr.pop();
    if (file.indexOf('_') === 0) {
      var configs = getConfigs();
      var object = configs.styles;
      if (typeof object === 'object') {
        for (var destFile in object) {
          delete cached.caches[destFile];
          remember.forgetAll(destFile);
          del.sync(destDir + '/styles/' + destFile);
        }
      }
    }
  });
  var scriptsWatcher = gulp.watch(appPublicDir + '/scripts/**/*', ['scripts']);
  scriptsWatcher.on('change', function (event) {
    if (event.type === 'deleted') {
      var destFiles = getDestFiles('scripts', event.path);
      if (destFiles.length > 0) {
        destFiles.forEach(function (destFile) {
          delete cached.caches[destFile][event.path];
          remember.forget(destFile, event.path);
        });
      }
    }
  });
  var fontsWatcher = gulp.watch(appPublicDir + '/fonts/**/*', ['fonts']);
  fontsWatcher.on('change', function (event) {
    if (event.type === 'deleted') {
      delete cached.caches.fonts[event.path];
    }
  });
  var imagesWatcher = gulp.watch(appPublicDir + '/images/**/*', ['images']);
  imagesWatcher.on('change', function (event) {
    if (event.type === 'deleted') {
      delete cached.caches.images[event.path];
    }
  });
  gulp.watch('bower.json', ['fonts', 'images']);
  var gulpSymfony2Watcher = gulp.watch('gulp-symfony2.yml', ['styles', 'scripts']);
  gulpSymfony2Watcher.on('change', function () {
    var configs = getConfigs();
    var changes = diff(oldConfigs, configs);
    oldConfigs = configs;
    if (changes) {
      changes.forEach(function (change) {
        if ((change.kind === 'D' || change.kind === 'A') && change.path.length === 2) {
          var destFile = change.path[1];
          delete cached.caches[destFile];
          remember.forgetAll(destFile);
          del.sync(destDir + '/' + change.path[0] + '/' + destFile);
        }
      });
    }
  });
});

gulp.task('default', function () {
  gulp.start('build');
});