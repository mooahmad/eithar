let mix = require('laravel-mix');

const WebpackShellPlugin = require('webpack-shell-plugin');

// Add shell command plugin configured to create JavaScript language file
mix.webpackConfig({
    plugins:
        [
            new WebpackShellPlugin({onBuildStart:['php artisan lang:js --quiet --no-lib'], onBuildEnd:[]})
        ]
});

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/Questionnaire/questionnaire.js', 'public/js/preprocessor')
   .sass('resources/assets/sass/Questionnaire/questionnaire.scss', 'public/css/preprocessor');

mix.js('resources/assets/js/medical-reports/medical-reports-questions.js', 'public/js/preprocessor')
    .sass('resources/assets/sass/medical-reports/medical-reports-questions.scss', 'public/css/preprocessor');
