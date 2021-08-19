const dotenvExpand = require('dotenv-expand');
dotenvExpand(require('dotenv').config({ path: '../../.env'/*, debug: true*/}));

const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../public').mergeManifest();

var m = __dirname.split("/");
var moduleName = m[m.length-1].toLowerCase();

mix.js(__dirname + '/Resources/assets/js/app.js', `modules/${moduleName}/js`)
   .sass( __dirname + '/Resources/assets/sass/app.scss', `modules/${moduleName}/css`);

mix.webpackConfig({
    output:{
        chunkFilename: `modules/${moduleName}/components/${(mix.inProduction()) ? 'prod/[chunkhash]' : '[name]'}.js`,
        publicPath: `${process.env.APP_URL}${(process.env.APP_URL.slice(process.env.APP_URL.length - 1)!=='/')?'/':''}`,
    }
});

if (mix.inProduction()) {
    mix.version();
}
else {
    mix.sourceMaps();
}
