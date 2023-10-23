const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    // .js('resources/metronic/plugins/global/plugins.bundle.js', 'public/js')
    // .js('resources/metronic/plugins/custom/prismjs/prismjs.bundle.js', 'public/js')
    // .js('resources/metronic/js/scripts.bundle.js', 'public/js')
    .vue()
    .postCss('resources/css/app.css','public/css')
    .postCss('resources/metronic/plugins/global/plugins.bundle.css','public/css')
    .postCss('resources/metronic/plugins/custom/prismjs/prismjs.bundle.css','public/css')
    .postCss('resources/metronic/css/style.bundle.css','public/css')
    .webpackConfig(require('./webpack.config'));

mix.webpackConfig({
    output: {
        chunkFilename: 'js/[name].js?id=[chunkhash]',
    }
});

if (mix.inProduction()) {
    mix.version();
}
else {
    mix.browserSync({
        proxy: 'http://127.0.0.1:8000'
    })
    .webpackConfig({
        devServer: {
            hot: true,
            open: true,
        },
    });
}
