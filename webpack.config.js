var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/static/')
    .setPublicPath('/static')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    // uncomment to create hashed filenames (e.g. app.abc123.css)
    // .enableVersioning(Encore.isProduction())

    // uncomment to define the assets of the project
    .addEntry('js/app', './assets/js/app.js')

    // .addStyleEntry('css/app', './assets/css/app.scss')
    .addStyleEntry('css/app', './assets/css/app.css')

    // uncomment if you use Sass/SCSS files
    // .enableSassLoader()

    // uncomment for legacy applications that require $/jQuery as a global variable
    .autoProvidejQuery()
    .cleanupOutputBeforeBuild()
;

module.exports = Encore.getWebpackConfig();
