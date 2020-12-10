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
    .js('resources/js/modules/branches/branches.js',                        'public/js/modules')
    .js('resources/js/modules/departments/departments.js',                  'public/js/modules')
    .js('resources/js/modules/positions/positions.js',                      'public/js/modules')
    .js('resources/js/modules/employees/employees.js',                      'public/js/modules')
    .js('resources/js/modules/suppliers/suppliers.js',                      'public/js/modules')
    .js('resources/js/modules/income_documents/income_documents.js',        'public/js/modules')
    .js('resources/js/modules/transfer_documents/transfer_documents.js',    'public/js/modules')
    .js('resources/js/modules/expense_documents/expense_documents.js',      'public/js/modules')
    .js('resources/js/modules/markdown_documents/markdown_documents.js',    'public/js/modules')
    .js('resources/js/modules/writedown_documents/writedown_documents.js',  'public/js/modules')
    .js('resources/js/modules/markup_documents/markup_documents.js',        'public/js/modules')
    .js('resources/js/modules/shifts/shifts.js',                            'public/js/modules')
    .js('resources/js/modules/sales_revenues/sales_revenues.js',            'public/js/modules')
    .js('resources/js/modules/cash_documents/cash_documents.js',            'public/js/modules')
    .js('resources/js/modules/payments/payments.js',                        'public/js/modules')
    .js('resources/js/modules/department_turns/department_turns.js',        'public/js/modules')
    .js('resources/js/modules/salaries/salaries.js',                        'public/js/modules');
    
mix.sass('resources/sass/app.scss', 'public/css');
