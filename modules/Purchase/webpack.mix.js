const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../public').mergeManifest();

mix.js(['../../resources/js/shared.js', '../../resources/js/mixins.js', __dirname + '/Resources/assets/js/app.js', '../../resources/js/now-ui-kit/plugins/nouislider.min.js',
        '../../resources/js/now-ui-kit/now-ui-kit.js',
        '../../resources/js/now-ui-kit/plugins/bootstrap-switch.js',
        '../../resources/js/jquery-menu.js', '../../resources/js/custom.js'
      //'resources/js/loading-message.js'
      ], 'js/purchase.js')
    .sass( __dirname + '/Resources/assets/sass/app.scss', 'css/purchase.css');

if (mix.inProduction()) {
    mix.version();
}
