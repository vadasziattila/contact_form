const Encore = require('@symfony/webpack-encore');
const webpack = require('webpack');

if (!Encore.isRuntimeEnvironmentConfigured()) {
  Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
  .setOutputPath('public/build/')
  .setPublicPath('/build')
  .addEntry('app', './assets/app.js')
  .splitEntryChunks()
  .cleanupOutputBeforeBuild()
  .enableBuildNotifications()
  .enableSourceMaps(!Encore.isProduction())
  .enableVersioning(Encore.isProduction())
  .enableSassLoader() // Enable Sass/SCSS support
  .configureBabelPresetEnv((config) => {
    config.useBuiltIns = 'usage';
    config.corejs = '3.23';
  })
  .enableSingleRuntimeChunk()
  .enablePostCssLoader((options) => {
    options.postcssOptions = {
      plugins: [
        require('autoprefixer')(),
      ],
    };
  })
  .autoProvidejQuery()
  .configureFilenames({
    css: 'css/[name].[contenthash:8].css',
    js: 'js/[name].[contenthash:8].js',
  })
  .addStyleEntry('styles', './assets/styles/app.scss')

module.exports = Encore.getWebpackConfig();
