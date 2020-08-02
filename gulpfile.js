var gulp        = require('gulp'),
    sass        = require('gulp-sass'), //модуль для компиляции SASS (SCSS) в CSS
    browserSync = require('browser-sync').create(), // сервер для работы и автоматического обновления страниц  
    concat      = require('gulp-concat'),  // слияние файлов
    cache       = require ('gulp-cached'),
    babel       = require('gulp-babel'), // модуль для преобразования JavaScript
    terser      = require('gulp-terser'), // модуль для минимизации JavaScript
    sourcemaps  = require('gulp-sourcemaps'),
    cssnano     = require('gulp-cssnano'),  // плагин для минимизации CSS
    rename      = require('gulp-rename'),
    del         = require('del'),  // плагин для удаления файлов и каталогов
    imagemin    = require('gulp-imagemin'),  // плагин для сжатия PNG, JPEG, GIF и SVG изображений
    pngquant    = require('imagemin-pngquant'),  // плагин для сжатия png
    imageminJpegRecompress = require('imagemin-jpeg-recompress'),
    svgmin      = require ('gulp-svgmin'), 
    cheerio     = require ('gulp-cheerio'), 
    replace     = require('gulp-replace'),
    svgSprite   = require('gulp-svg-sprite'),
    plumber     = require('gulp-plumber'),// модуль для отслеживания ошибок
    autoprefixer = require('gulp-autoprefixer');// модуль для автоматической установки автопрефиксов

//import cache from 'gulp-cache';

    gulp.task('browser-sync', function(done) { // Создаем таск browser-sync
        browserSync.init(
        { // Выполняем browser Sync
            reloadOnRestart: true,
            proxy: "thewall.local",
        });
        done();
    });

    gulp.task('sass', function(done){ // Создаем таск Sass
        return gulp.src('app/sass/**/*.scss') // Берем источники  main, fonts и libs
        .pipe(plumber()) // для отслеживания ошибок
        .pipe(sourcemaps.init({largeFile: true}))
        .pipe(sass()) // Преобразуем Sass в CSS посредством gulp-sass
        .pipe(autoprefixer(['last 15 versions', '> 1%', 'ie 8', 'ie 7'], { cascade: true })) // Создаем префиксы
        .pipe(sourcemaps.write('../maps'))
        .pipe(gulp.dest('app/css'));// Выгружаем результат в папку app/css
      //  .pipe(browserSync.stream()); // Обновляем CSS на странице при изменении
        done();
});

    gulp.task('css-mainmin', function(done) {
        return gulp.src('app/css/main.css')
        .pipe(plumber()) // для отслеживания ошибок
        .pipe(cssnano())             //Сжимаем main.css
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest('app/css'))
        .pipe(browserSync.stream()); // Обновляем CSS на странице при изменении
        done();
});

    gulp.task('css-libsmin', function(done) {
        return gulp.src('app/css/libs.css')
        .pipe(plumber()) // для отслеживания ошибок
        .pipe(cssnano())              // Сжимаем libs.css
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest('app/css'))
        .pipe(browserSync.stream()); // Обновляем CSS на странице при изменении
        done();
});

    gulp.task('js-main', function (done) {
        return gulp.src('app/js/partials/*.js')
        .pipe(plumber())
        .pipe(sourcemaps.init())
        .pipe(concat('main.js')) // Собираем их в кучу в новом файле main.js
        .pipe(babel())
        .pipe(sourcemaps.write('../maps'))
        .pipe(gulp.dest('app/js'))
        .pipe(browserSync.reload({stream: true})); // Обновляем JS на странице при изменении
        done();
});

  /*  gulp.task('js-main-admin', function (done) {
      return gulp.src('app/js/partials_admin/*.js')
      .pipe(plumber())
      .pipe(sourcemaps.init())
      .pipe(concat('main-admin.js')) // Собираем их в кучу в новом файле main.js
      .pipe(babel())
      .pipe(sourcemaps.write('../maps'))
      .pipe(gulp.dest('app/js'))
      .pipe(browserSync.reload({stream: true})); // Обновляем JS на странице при изменении
      done();
    });
  */
    gulp.task('js-mainmin', function(done) {
        return gulp.src('app/js/main.js')
        .pipe(plumber()) // для отслеживания ошибок
     //   .pipe(cache())
        .pipe(sourcemaps.init())        
        .pipe(cache(terser()))           // Сжимаем main.js
        .pipe(rename({suffix: '.min'}))
        .pipe(sourcemaps.write('../maps'))
        .pipe(gulp.dest('app/js'))
      //  .on('end', browserSync.reload);
        .pipe(browserSync.reload({stream: true})); // Обновляем JS на странице при изменении
      //  .pipe(browserSync.stream()); // Обновляем JS на странице при изменении
        done();
});
/*
    gulp.task('js-main-adminmin', function(done) {
      return gulp.src('app/js/main-admin.js')
      .pipe(plumber()) // для отслеживания ошибок
    //   .pipe(cache())
      .pipe(sourcemaps.init())        
      .pipe(cache(terser()))           // Сжимаем main.js
      .pipe(rename({suffix: '.min'}))
      .pipe(sourcemaps.write('../maps'))
      .pipe(gulp.dest('app/js'))
    //  .on('end', browserSync.reload);
      .pipe(browserSync.reload({stream: true})); // Обновляем JS на странице при изменении
    //  .pipe(browserSync.stream()); // Обновляем JS на странице при изменении
      done();
    });
*/
    gulp.task('js-libs', function(done) {
        return gulp.src([ // Берем все необходимые библиотеки
            'app/libs/jquery-3.2.1.min.js',           //Берем jQuery
            'app/libs/popper.min.js',         //Берем Popper Popup
            'app/libs/bootstrap.min.js'  //Берем Bootstrap
      //      'app/libs/owl.carousel/dist/owl.carousel.min.js'  //Берем Owl.Carousel
            ])
        .pipe(plumber()) // для отслеживания ошибок
        .pipe(sourcemaps.init({largeFile: true}))
        .pipe(concat('lib.js')) // Собираем их в кучу в новом файле lib.js
        .pipe(sourcemaps.write('../maps'))        
        .pipe(gulp.dest('app/js'));
      //  .pipe(browserSync.reload({stream: true}));
        done();
});

    gulp.task('js-libsmin', function(done) {
        return gulp.src('app/js/lib.js')
        .pipe(plumber()) // для отслеживания ошибок
        .pipe(sourcemaps.init({largeFile: true}))
        .pipe(terser())              // Сжимаем lib.js
        .pipe(rename({suffix: '.min'}))
        .pipe(sourcemaps.write('../maps'))
        .pipe(gulp.dest('app/js'))
        .pipe(browserSync.reload({stream: true}));
      //  .pipe(browserSync.stream()); // Обновляем JS на странице при изменении
        done();
});

    gulp.task('clean', function(done) {
        return del('dist')
        done();
});

    gulp.task('clear', function(done) {
        return cache.clearAll()
        done();
});

    gulp.task('watch', function() {
    gulp.watch('app/sass/*.scss', gulp.series('sass', 'css-mainmin', 'css-libsmin')); // Наблюдение за рабочими SCSS файлами
    gulp.watch('app/*.html').on('change', browserSync.reload); // Наблюдение за HTML файлами в корне проекта
    gulp.watch('app/**/*.php').on('change', browserSync.reload); // Наблюдение за PHP файлами в проекте
    gulp.watch(['app/js/partials/*.js'], gulp.series('js-main', 'js-mainmin')); // Наблюдение за JS файлами
  //  gulp.watch(['app/js/partials_admin/*.js'], gulp.series('js-main-admin', 'js-main-adminmin')); // Наблюдение за JS файлами
    gulp.watch(['app/libs/**/*.js'], gulp.series('js-libs', 'js-libsmin')); // Наблюдение за JS библиотеками
    gulp.watch(['app/libs/**/*.scss'], gulp.series('sass', 'css-mainmin', 'css-libsmin')); // Наблюдение за SCSS файлами в библиотеке
});

    gulp.task('default', gulp.parallel('browser-sync', 'watch'));

    gulp.task('imgmin', function () {
        return gulp.src('app/img/**/*.{png,jpg,svg}')
        .pipe(imagemin([
          imagemin.jpegtran({progressive: true}),
          imageminJpegRecompress({
            loops: 5,
            min: 60,
            max: 70,
            quality: 'medium'
          }),
          imagemin.optipng({optimizationLevel: 3}),
          pngquant({quality: [0.6,0.7], speed: 5})
     //     imagemin.svgo()
        ]))
        .pipe(gulp.dest('dist/img'));
  });

  gulp.task('svg', function () {
    return gulp.src('app/img/svg/*.svg')
        .pipe(plumber()) // для отслеживания ошибок
        .pipe(svgmin({
          js2svg: {
            pretty: true
          }
        }))
        .pipe(cheerio({
          run: function ($) {
            $('[fill]').removeAttr('fill');
            $('[stroke]').removeAttr('stroke');
            $('[style]').removeAttr('style');
          },
          parserOptions: {xmlMode: true}
        }))
        .pipe(replace('&gt;', '>'))
        // build svg sprite
        .pipe(svgSprite({
          mode: {
            symbol: {
              sprite: "../sprite.svg"
            }
          }
        }))
        .pipe(gulp.dest('app/img'));
  });

    gulp.task('buildCss', function() {
        return gulp.src([ // Переносим библиотеки в продакшен
        'app/css/libs.min.css',
        'app/css/main.min.css',
        'app/css/main.css'
		])
    .pipe(gulp.dest('dist/css'));
});

    gulp.task('buildFonts', function() {
        return gulp.src('app/fonts/**/*') // Переносим шрифты в продакшен
    .pipe(gulp.dest('dist/fonts'));
});

    gulp.task('buildJs', function() {
        return gulp.src('app/js/**/*') // Переносим скрипты в продакшен
    .pipe(gulp.dest('dist/js'));
});

    gulp.task ('buildHtml', function() {
        return gulp.src('app/*.html') // Переносим HTML в продакшен
	.pipe(gulp.dest('dist'));
});

gulp.task ('buildPhp', function() {
  return gulp.src('app/*.php') // Переносим HTML в продакшен
.pipe(gulp.dest('dist'));
});
/*
gulp.task ('buildPhp_admin', function() {
  return gulp.src('app/admin/*.php') // Переносим HTML в продакшен
.pipe(gulp.dest('dist'));
});
*/
    gulp.task('build', gulp.series(gulp.parallel('sass', 'js-main', 'js-libs'), 
                                   gulp.parallel('css-libsmin', 'js-libsmin'),
                                   gulp.parallel('css-mainmin', 'js-mainmin',),
                                   'clean',
                                   gulp.parallel('imgmin', 'buildCss', 'buildFonts', 'buildJs', 'buildHtml', 'buildPhp')));


