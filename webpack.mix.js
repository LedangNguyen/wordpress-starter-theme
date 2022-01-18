const mix = require('laravel-mix');
const path = require('path');
const os = require('os');

// Variables
const proxy = 'http://wordpress-theme.test';
const themeName = 'wordpress-theme';
const sourcePath = os.platform() === 'win32' ? path.normalize('src') : 'src';
const publicPath = os.platform() === 'win32' ? path.normalize('assets') : 'assets';

// Settings
mix.setPublicPath(publicPath).options({
  processCssUrls: false,
  postCss: [
    require('postcss-preset-env')({
      stage: 1,
      autoprefixer: { grid: true },
    }),
    require('@hail2u/css-mqpacker')({
      sort: true,
    }),
    require('postcss-assets')({
      loadPaths: [`images/`],
      basePath: `${sourcePath}/`,
      baseUrl: `/wp-content/themes/${themeName}/${publicPath}/`,
      // cachebuster: true,
    }),
    require('postcss-aspect-ratio-polyfill'),
    require('@fullhuman/postcss-purgecss')({
      content: ['./src/js/**/*.js', '**/*.php'],
      safelist: ['admin-bar'],
    }),
  ],
});

mix.babelConfig({
  presets: [
    [
      '@babel/preset-env',
      {
        useBuiltIns: 'usage',
        corejs: '3.20',
      },
    ],
  ],
});

mix.alias({
  '@': path.join(__dirname, 'node_modules'),
  '~': path.join(__dirname, 'node_modules'),
});

// Fix for JavaScript Dynamic Imports
mix.webpackConfig({
  output: {
    publicPath: `/wp-content/themes/${themeName}/${publicPath}/`,
    chunkFilename: 'js/[name].[chunkhash].js',
  },
});

// Assets build and copying
mix
  .sass(`${sourcePath}/scss/app.scss`, `css`)
  .sass(`${sourcePath}/scss/critical.scss`, `css`)
  .js(`${sourcePath}/js/app.js`, `js`)
  .copyDirectory(`${sourcePath}/images`, `${publicPath}/images`)
  .sourceMaps(false, 'inline-source-map');

// Versioning for production (cache busting)
if (mix.inProduction()) {
  mix.version();
}

// BrowserSync setup
mix.browserSync({
  proxy,
  https: false,
  ui: false,
  open: true,
  notify: false,
  ghostMode: {
    clicks: false,
    forms: false,
    scroll: false,
  },
  files: ['**/*.php', `assets/css/*.css`, `assets/js/*.js`],
});

// Disable OS notifications
mix.disableSuccessNotifications();
