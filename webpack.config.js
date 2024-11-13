const path = require('path');
const fs = require('fs');
const exec = require('child_process').exec;
const WebpackWatchPlugin = require('webpack-watch-files-plugin').default;

const source = './app/ui';
const dest = './www/assets/ui';

module.exports = {
  entry: source + '/js/main.js',
  output: {
    filename: 'tmp.js',
    path: path.resolve(dest),
  },
  mode: 'production',
  module: {
    rules: [
      {test: /\.html/, use: 'html-loader'}
    ],
  },
  plugins: [
    new WebpackWatchPlugin({
      files: [
        source + '/**/*.js',
        source + '/**/*.css',
        source + '/**/*.scss',
        source + '/**/*.html',
      ]
    }),
    {
      apply: (compiler) => {
        compiler.hooks.afterEmit.tap('AfterEmitPlugin', () => {
          let js = [
            dest + '/tmp.js',
          ];
          fs.writeFileSync(dest +'/build.js', js.map(f => fs.readFileSync(f, 'utf8')).join('\n'));
          fs.unlink(dest + '/tmp.js', () => {
          });

          console.log('Starting SASS');
          exec('sass --no-source-map --style=compressed ' + source +'/css/main.scss ' + dest + '/build.css', (err) => {
            err && console.log('SASS err', err);
            console.log('SASS finished');
          });
        });
      }
    }
  ]
};
