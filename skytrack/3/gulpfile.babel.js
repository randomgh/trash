'use strict';

import gulp from 'gulp';
import eslint from 'gulp-eslint';
import gulpStylelint from 'gulp-stylelint';
import sassLint from 'gulp-sass-lint';
import uglify from 'gulp-uglify';
import babel from 'gulp-babel';
import sass from 'gulp-sass';
import postcss from 'gulp-postcss';
import autoprefixer from 'autoprefixer';
import precss from 'precss';
import postcssPresetEnv from 'postcss-preset-env';
import cleanCSS from 'gulp-clean-css';
import sourcemaps from 'gulp-sourcemaps';
import clean from 'gulp-clean';

const DIRECTORIES = {
    js: {
        src: 'js/src/**/*.js',
        build: 'js/build/'
    },
    scss: {
        src: 'scss/**/*.scss',
        build: 'css/src/'
    },
    css: {
        src: 'css/src/**/*.css',
        build: 'css/build/'
    }
};


gulp.task('js-clean', () => gulp.src(DIRECTORIES.js.build, { read: false })
    .pipe(clean()));

gulp.task('js-build', () => gulp.src(DIRECTORIES.js.src)
    .pipe(sourcemaps.init({ loadMaps: true }))
    .pipe(babel())
    .pipe(uglify())
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest(DIRECTORIES.js.build)));

gulp.task('js-lint', () => gulp.src(DIRECTORIES.js.src)
    .pipe(eslint())
    .pipe(eslint.format())
    .pipe(eslint.failAfterError()));


gulp.task('css-clean', () => gulp.src(DIRECTORIES.css.build, { read: false })
    .pipe(clean()));

gulp.task('css-build', () => gulp.src(DIRECTORIES.css.src)
    .pipe(sourcemaps.init({ loadMaps: true }))
    .pipe(postcss([
        autoprefixer(),
        postcssPresetEnv(),
        precss
    ]))
    .pipe(cleanCSS())
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest(DIRECTORIES.css.build)));

gulp.task('css-lint', () => gulp
    .src(DIRECTORIES.css.src)
    .pipe(gulpStylelint({
        failAfterError: true,
        reportOutputDir: 'reports/lint',
        reporters: [
            { formatter: 'string', console: true }
        ],
        debug: true
    })));


gulp.task('scss-clean', () => gulp.src(DIRECTORIES.scss.build, { read: false })
    .pipe(clean()));

gulp.task('scss-build', () => gulp.src(DIRECTORIES.scss.src)
    .pipe(sourcemaps.init({ loadMaps: true }))
    .pipe(sass().on('error', sass.logError))
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest(DIRECTORIES.scss.build)));

gulp.task('scss-lint', () => gulp.src(DIRECTORIES.scss.src)
    .pipe(sassLint({ configFile: '.sasslintrc.json' }))
    .pipe(sassLint.format())
    .pipe(sassLint.failOnError()));


gulp.task('build-js-dev', gulp.series('js-clean', 'js-build'));
gulp.task('build-js-prod', gulp.series('js-lint', 'js-clean', 'js-build'));

gulp.task('watch-js-dev', () => gulp.watch(DIRECTORIES.js.src, gulp.series('build-js-dev')));
gulp.task('watch-js-prod', () => gulp.watch(DIRECTORIES.js.src, gulp.series('build-js-prod')));


gulp.task('build-css-dev', gulp.series('css-clean', 'css-build'));
gulp.task('build-css-prod', gulp.series('css-lint', 'css-clean', 'css-build'));

gulp.task('watch-css-dev', () => gulp.watch(DIRECTORIES.css.src, gulp.series('build-css-dev')));
gulp.task('watch-css-prod', () => gulp.watch(DIRECTORIES.css.src, gulp.series('build-css-prod')));


gulp.task('build-scss-dev', gulp.series('scss-clean', 'scss-build', 'css-clean', 'css-build'));
gulp.task('build-scss-prod', gulp.series('scss-lint', 'scss-clean', 'scss-build', 'css-clean', 'css-build'));

gulp.task('watch-scss-dev', () => gulp.watch(DIRECTORIES.scss.src, gulp.series('build-scss-dev')));
gulp.task('watch-scss-prod', () => gulp.watch(DIRECTORIES.scss.src, gulp.series('build-scss-prod')));


gulp.task('build-dev', gulp.series('js-clean', 'js-build', 'scss-clean', 'scss-build', 'css-clean', 'css-build'));
gulp.task('build-prod', gulp.series('js-lint', 'scss-lint', 'build-dev'));
