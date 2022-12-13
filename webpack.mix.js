const mix = require('laravel-mix');
const path = require('path');
let config = require('./webpack.config');
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

mix.js('resources/js/app.js', 'public/js/admin/index.js')
    .js("./node_modules/flowbite/src/flowbite.js", "public/js")
    .vue()
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
    ])
    .postCss("./node_modules/flowbite/src/flowbite.css", "public/css")
    .postCss("./node_modules/font-awesome/css/font-awesome.css", "public/css")
    .postCss("./node_modules/font-awesome/css/font-awesome.min.css", "public/css")
    .version();

mix.sass('resources/sass/admin/index.scss', 'public/css/admin.css')
    .copyDirectory('resources/assets/', 'public/')
    .version();

mix.webpackConfig(config);

mix.options({
    processCssUrls: false,
    postCss: [],
    terser: {},
    autoprefixer: {},
    legacyNodePolyfills: false
});
