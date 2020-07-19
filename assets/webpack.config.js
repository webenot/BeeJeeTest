const path = require('path');
const webpack = require('webpack');

const isProduction = (process.env.NODE_ENV === 'production');

const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const TerserJSPlugin = require('terser-webpack-plugin');
const Cleanplugin = require('clean-webpack-plugin').CleanWebpackPlugin;
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');
require('@babel/polyfill');

module.exports = {
  mode: (isProduction) ? 'production' : 'development',

  optimization: {
    minimizer: [
      new TerserJSPlugin({}),
      new OptimizeCSSAssetsPlugin({}),
    ],
    usedExports: true,
  },

  watch: !isProduction,

  devtool: (isProduction) ? false : 'inline-source-map',

  context: path.resolve(__dirname, 'src'),

  entry: {
    index: [
      '@babel/polyfill',
      path.resolve(__dirname, 'src', 'js', 'index.js'),
      path.resolve(__dirname, 'src', 'sass', 'style.sass'),
    ],
  },
  output: {
    filename: 'js/[name].js',
    path: path.resolve(__dirname, 'dist'),
    publicPath: '../',
  },
  module: {
    rules: [
      // js
      {
        test: /\.m?jsx?$/i,
        exclude: /^(node_modules)$/,
        use: {
          loader: 'babel-loader',
          options: {
            configFile: './babel.config.js',
            cacheDirectory: true,
          },
        },
      },
      // sass
      {
        test: /\.sass$/i,
        resolve: { extensions: [ '.scss', '.sass' ] },
        use: [
          {
            loader: MiniCssExtractPlugin.loader,
            options: { publicPath: path.resolve('dist', 'css') },
          },
          // 'style-loader',
          {
            loader: 'css-loader',
            options: { sourceMap: !isProduction },
          },
          {
            loader: 'postcss-loader',
            options: { sourceMap: !isProduction },
          },
          {
            loader: 'sass-loader',
            options: { sourceMap: !isProduction },
          },
        ],
      },
      // SVG
      {
        test: /\.svg$/i,
        use: {
          loader: 'svg-url-loader',
          options: { encoding: 'base64' },
        },
      },
    ],
  },

  plugins: [
    new webpack.DefinePlugin({ NODE_ENV: JSON.stringify(process.env.NODE_ENV) }),
    new Cleanplugin({
      verbose: true,
      cleanStaleWebpackAssets: false,
    }),
    new MiniCssExtractPlugin(
      { filename: './css/[name].css' },
    ),
  ],
};

// PRODUCTION ONLY
if (isProduction) {
  module.exports.plugins.push(
    new webpack.LoaderOptionsPlugin({ minimize: true }),
  );
  module.exports.plugins.push(new OptimizeCSSAssetsPlugin());
}
