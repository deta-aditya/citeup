const { mix } = require('laravel-mix');

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

mix.js('resources/assets/js/front.js', 'public/js')
   .js('resources/assets/js/dashboard.js', 'public/js')
   .copyDirectory('node_modules/font-awesome/fonts', 'public/fonts')
   .copyDirectory('resources/assets/fonts', 'public/fonts')
   .sass('resources/assets/sass/app.scss', 'public/css')
   .options({
        processCssUrls: false
   })
