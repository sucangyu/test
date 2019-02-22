const gulp = require("gulp");
//转译js
gulp.task("webpack",() =>{
    const webpack = require("webpack-stream");
    const config = require("./webpack.config.js");
    gulp.src("./js/**/*.js")
        .pipe(webpack(config))
        .pipe(gulp.dest("../www/js"));
});

//编译 less ->css
gulp.task("less",()=>{
    const less = require("gulp-less");
    gulp.src("./less/*.less")
        .pipe(less())
        .pipe(gulp.dest("../www/css"));
});

gulp.task("default",["webpack","less"]);
//监视指定文件变动进行制定操作
gulp.task("watch",()=>{
    gulp.watch("less/**/*.less",["less"]);
    gulp.watch("js/**/*.js",["webpack"]);
});


















