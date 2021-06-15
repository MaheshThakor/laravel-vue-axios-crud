const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/assets/sass/bulma.scss', 'public/css');
