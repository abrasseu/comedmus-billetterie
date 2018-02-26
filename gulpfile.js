var gulp = require('gulp');
var plugins = require('gulp-load-plugins')();

// Paths variables
var devFolder  = './';
var prodFolder = './';


// CSS Task
gulp.task('css', function () {
	return gulp.src(devFolder + 'css/all.scss')
	.pipe(plugins.sourcemaps.init())
	.pipe(plugins.sass())
	.pipe(plugins.autoprefixer())
	// .pipe(concat('bootstrap/css/bootstrap.css'))
	// Add bootstrap
	.pipe(plugins.csscomb())
	.pipe(plugins.cssbeautify({indent: '	'}))
	.pipe(plugins.sourcemaps.write())
	.pipe(gulp.dest(prodFolder + 'css/'))
	.pipe(plugins.csso())
	.pipe(plugins.rename({suffix: '.min'}))
	.pipe(gulp.dest(prodFolder + 'css/'));
});

// Javascript Task
gulp.task('js', function() {
	return gulp.src(devFolder + 'js/contact.js')
	// .pipe(plugins.sourcemaps.init())
	.pipe(plugins.uglify())
	// .pipe(concat('all.min.js'))
	// .pipe(plugins.sourcemaps.write())
	.pipe(plugins.rename({suffix: '.min'}))
	.pipe(gulp.dest(prodFolder + 'js/'));
});

// Image Task
gulp.task('img', function () {
	return gulp.src(devFolder + 'img/*.{png,jpg,jpeg,gif,svg}')
	.pipe(imagemin())
	.pipe(gulp.dest(prodFolder + 'img/'));
});



// Tasks
gulp.task('build', ['css', 'js']);
gulp.task('buildcss', ['css']);
gulp.task('buildjs', ['js']);
gulp.task('prod', ['build', 'img']);
gulp.task('default', ['build']);

// Watch
/*
var watcher = gulp.watch('./css/*.scss', ['css']);
watcher.on('change', function(event) {
	console.log('File ' + event.path + ' was ' + event.type + ', running tasks...');
});
 */

