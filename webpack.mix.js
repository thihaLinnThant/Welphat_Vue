const mix = require('laravel-mix');


mix.webpackConfig({
    resolve: {
      alias: {
        'vue$': 'vue/dist/vue.runtime.esm.js'
      }
    }
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

// mix.options({
//   extractVueStyles: 'public/css/vue-style.css'
// });

mix.js('resources/js/admin_app.js', 'public/js/admin_app.js')
    .sass('resources/sass/admin.scss', 'public/css/admin_style.css')
    .styles([
      'resources/css/admin_style.css'
    ], 'public/css/admin_style.css');
