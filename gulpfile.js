/* eslint-disable no-undef */
/**
 * include plug-ins
 */
var gulp = require('gulp');
var changed = require('gulp-changed');
var imagemin = require('gulp-imagemin');
var stripDebug = require('gulp-strip-debug');
var uglify = require('gulp-uglify');
var sass = require('gulp-sass');
var notify = require('gulp-notify');
var cleanCSS = require('gulp-clean-css');
var sourcemaps = require('gulp-sourcemaps');
var watch = require('gulp-watch');
var gutil = require('gulp-util');
var del = require('del');
var autoprefixer = require('gulp-autoprefixer');
var browserSync = require('browser-sync').create();

/**
 * Path
 */
var name_theme  = 'inssd';
var domaine     = 'inssd.code';
var src_theme = './src/' + name_theme + '/';
var src_sass = './src/sass/';
var dist_theme = './dist/wp-content/themes/' + name_theme + '/';
var src_js = src_theme + 'js/';
var path = {
    src: {
        img: src_theme + 'img/**/*',
        php: src_theme + '**/*.php',
        html: src_theme + '**/*.html',
        scripts: src_js + '**/*.js',
        scss: src_sass + '**/*.scss',
        divers: [
            src_theme + 'fonts/**/*',
            src_theme + 'videos/**/*',
            src_theme + 'favicon*',
            src_theme + 'android-chrome-*',
            src_theme + 'apple-touch-icon*',
            src_theme + 'browserconfig.*',
            src_theme + 'manifest*',
            src_theme + 'site.webmanifest',
            src_theme + 'mstile-*',
            src_theme + 'safari-pinned-tab*',
            src_theme + 'fonts/**/*',
            src_theme + '**/.gitkeep',
            src_theme + 'humans.txt',
        ],
    },
    dist: {
        img: dist_theme + 'img/',
        php: dist_theme,
        html: dist_theme,
        scripts: dist_theme + 'js/',
        scss: dist_theme,
        divers: dist_theme,
    }
};

function generationPage(src, dist) {

    gulp.src(src)
        .pipe(changed(dist))
        .pipe(gulp.dest(dist))
        .on('end', browserSync.reload);
}

/**
 * TASKS
 */

// Browser Sync
gulp.task('browser-sync', function () {
    browserSync.init({
        proxy: domaine,
        host: domaine,
        open: 'external'
    });
});

// HTML
gulp.task('htmlpage', function () {
    generationPage(path.src.html, path.dist.html);
});

// PHP
gulp.task('phppage', function () {
    generationPage(path.src.php, path.dist.php);
});

// minify new images
gulp.task('imagemin', function () {
    gulp.src(path.src.img)
        .pipe(changed(path.dist.img))
        .pipe(imagemin({
            progressive: true,
            optimizationLevel: 7
        }))
        .pipe(gulp.dest(path.dist.img))
        .on('end', browserSync.reload);
});

// JS concat, strip debugging and minify
gulp.task('scripts', function () {
    if (gutil.env.e === 'production') {
        gulp.src(path.src.scripts)
            .pipe(stripDebug())
            .pipe(uglify().on('error', function (e) {
                console.log(e);
            }))
            .pipe(gulp.dest(path.dist.scripts))
            .on('end', browserSync.reload);
    } else {
        gulp.src(path.src.scripts)
            .pipe(gulp.dest(path.dist.scripts))
            .on('end', browserSync.reload);
    }
});

gulp.task('styles', function () {
    gulp.src(path.src.scss)
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', notify.onError({
            message: 'Error: <%= error.message %>',
            title: 'Error running something'
        })))
        .pipe(autoprefixer({ browsers: ['Firefox >= 40', 'IE >= 10'] }))
        .pipe(cleanCSS())
        .pipe(sourcemaps.write())
        .pipe(gulp.dest(path.dist.scss))
        .pipe(browserSync.stream());
});

// Copier-coller
gulp.task('divers', function () {
    gulp.src(path.src.divers, { base: src_theme })
        .pipe(changed(path.dist.divers))
        .pipe(gulp.dest(path.dist.divers))
        .on('end', browserSync.reload);
});

// Clean du dist
gulp.task('clean_all', function () {
    return del([dist_theme + '**/*']);
});
gulp.task('reset', ['clean_all'], function () {
    gulp.start('default');
});
gulp.task('clean', function () {
    return del([dist_theme + '**/*.php', dist_theme + '**/*.html', dist_theme + '**/*.js', dist_theme + '**/*.css', dist_theme + '**/*.css.map']);
});


// default gulp task
gulp.task('default', ['clean', 'imagemin'], function () {
    gulp.start('styles');
    gulp.start('htmlpage');
    gulp.start('phppage');
    gulp.start('scripts');
    gulp.start('divers');
    gulp.start('browser-sync');

    // watch for SCSS changes
    watch(path.src.scss, function () {
        gulp.start('styles');
    });

    // watch for HTML changes
    watch(path.src.html, function () {
        gulp.start('htmlpage');
    });

    // watch for PHP changes
    watch(path.src.php, function () {
        gulp.start('phppage');
    });

    // watch for scripts changes
    watch(path.src.scripts, function () {
        gulp.start('scripts');
    });

    // watch for images changes
    watch(path.src.img, function () {
        gulp.start('imagemin');
    });

    // watch for divers
    watch(path.src.divers, function () {
        gulp.start('divers');
    });

});
