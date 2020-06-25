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

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/modules/branches/branches.js', 'public/js/modules')
    .js('resources/js/modules/departments/departments.js', 'public/js/modules')
    .js('resources/js/modules/positions/positions.js', 'public/js/modules')
    .js('resources/js/modules/employees/employees.js', 'public/js/modules')
    .sass('resources/sass/app.scss', 'public/css');
