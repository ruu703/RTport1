const mix = require('laravel-mix');

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

mix.js([
    'resources/js/app.js',
    'resources/js/router.js'
    ], 'public/js/vue.js')
    .babel([
        'public/js/vue.js',
        'resources/js/burger.js',
        'resources/js/globalnav.js'
        ], 'public/js/app.js')
    .sass('resources/sass/app.scss', 'public/css')
    .version();
