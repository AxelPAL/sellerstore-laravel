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

mix.js('resources/js/app.js', 'public/js/dist')
   .js('node_modules/bootstrap/dist/js/bootstrap.min.js', 'public/js/dist')
   .sass('node_modules/materialize-css/sass/materialize.scss', 'public/css/dist')
   .sass('node_modules/slick-carousel/slick/slick.scss', 'public/css/dist')
   .sass('node_modules/slick-carousel/slick/slick-theme.scss', 'public/css/dist')
   .sass('resources/sass/app.scss', 'public/css/dist');
mix.styles([
    'node_modules/bootstrap/dist/css/bootstrap.min.css',
    'node_modules/intro.js/minified/introjs.min.css',
    'public/css/dist/*.css',
], 'public/css/app.css');
mix.combine(['public/js/dist/*'], 'public/js/app.js');
