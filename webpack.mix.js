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

mix.sass('resources/sass/app.scss', 'public/css/dist');
mix.copy('node_modules/swipebox/src/css/swipebox.min.css', 'public/css/dist');
mix.styles([
    'node_modules/bootstrap/dist/css/bootstrap.min.css',
    'node_modules/intro.js/minified/introjs.min.css',
    'public/css/dist/*.css',
], 'public/css/app.css');
mix.combine([
    'node_modules/jquery/dist/cdn/jquery-2.1.1.min.js',
    'node_modules/bootstrap/dist/js/bootstrap.min.js',
    'node_modules/materialize-css/dist/js/materialize.min.js',
    'node_modules/jquery-sticky/jquery.sticky.js',
    'node_modules/tablesorter/dist/js/jquery.tablesorter.min.js',
    'node_modules/slick-carousel/slick/slick.min.js',
    'node_modules/list.js/dist/list.min.js',
    'node_modules/intro.js/minified/intro.min.js',
    'node_modules/swipebox/src/js/jquery.swipebox.min.js',
    'resources/js/app.js'
], 'public/js/app.js');
