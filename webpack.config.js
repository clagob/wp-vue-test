const
  webpack = require('webpack'),
  path = require('path'),
  ENV = process.env.NODE_ENV || 'development',
  CSS_MAPS = ENV!=='production'


// CUSTOM Folders
const
  BASE_PATH = '/', // in line with the functions.php
  THEME_FOLDER = 'wp-vue',
  DIST = path.resolve(__dirname, './' + THEME_FOLDER + '/dist/'),
  PUBLIC_DIST = BASE_PATH + 'wp-content/themes/' + THEME_FOLDER + '/dist/',
  SRC = path.resolve(__dirname, './src'),
  SRC_IMG   = SRC + '/assets/img/',
  SRC_JS    = SRC + '/assets/js/',
  SRC_SCSS  = SRC + '/assets/scss/',
  SRC_FONTS = SRC + '/assets/fonts/',
  NODE_MODULES = path.resolve(__dirname, './node_modules')


// Plugins
const
  // UglifyJsPlugin = require('uglifyjs-webpack-plugin'),
  // autoprefixer = require('autoprefixer'),
  //CopyWebpackPlugin = require('copy-webpack-plugin'),
  // ImageminPlugin = require('imagemin-webpack-plugin').default,
  ExtractTextPlugin = require("extract-text-webpack-plugin")



module.exports = {
  context: SRC,
  entry: ['./main.js'],

  output: {
    path: DIST,
    publicPath: PUBLIC_DIST,
    filename: './[name].js?[chunkhash]'
  },

  module: {
    rules: [
      {
        test: /\.vue$/i,
        exclude: NODE_MODULES,
        loader: 'vue-loader',
        options: {
          // loaders: {
          //   'scss': 'vue-style-loader!css-loader!postcss-loader!sass-loader',
          //   'sass': 'vue-style-loader!css-loader!postcss-loader!sass-loader?indentedSyntax'
          // },
          loaders: {
            'css': ExtractTextPlugin.extract({
              use: [
                { loader: 'css-loader', options: { sourceMap: CSS_MAPS, importLoaders: 1 } },
                { loader: 'postcss-loader', options: { sourceMap: CSS_MAPS } }
              ],
              fallback: 'vue-style-loader'
            }),
            'scss': ExtractTextPlugin.extract({
              use: [
                { loader: 'css-loader', options: { sourceMap: CSS_MAPS, importLoaders: 1 } },
                { loader: 'postcss-loader', options: { sourceMap: CSS_MAPS } },
                'sass-loader'
              ],
              fallback: 'vue-style-loader'
            }),
            'sass': ExtractTextPlugin.extract({
              use: [
                { loader: 'css-loader', options: { sourceMap: CSS_MAPS, importLoaders: 1 } },
                { loader: 'postcss-loader', options: { sourceMap: CSS_MAPS } },
                { loader: 'sass-loader', options: { indentedSyntax: true } }
              ],
              fallback: 'vue-style-loader'
            })
          },
          cssSourceMap: CSS_MAPS
        }
      },
      {
        test: /\.js$/i,
        exclude: NODE_MODULES,
        loader: 'babel-loader',
      },
      // {
      //   test: /\.html$/i,
      //   exclude: NODE_MODULES,
      //   loader: 'raw-loader',
      // },
      // {
      //   test: /\.css$/i,
      //   exclude: NODE_MODULES,
      //   use: [
      //     'style-loader',
      //     { loader: 'css-loader', options: { sourceMap: CSS_MAPS, importLoaders: 1 } },
      //     { loader: 'postcss-loader', options: { sourceMap: CSS_MAPS } },
      //   ],
      // },
      // {
      //   // Extract all the CSS from the JS
      //   test: /\.scss$/i,
      //   exclude: NODE_MODULES,
      //   use: ExtractTextPlugin.extract({
      //     use: [
      //       { loader: 'css-loader', options: { sourceMap: CSS_MAPS, importLoaders: 1 } },
      //       { loader: 'postcss-loader', options: { sourceMap: CSS_MAPS } },
      //       'sass-loader',
      //     ],
      //     fallback: "style-loader",
      //   })
      // },
      {
        test: /\.(png|jpe?g|gif|svg)$/i,
        //include: SRC_IMG,
        use: [
          {
            loader: 'url-loader', // 'file-loader',
            options: {
              limit: 10000, // Convert images < 10KB to base64 strings with url-loader
              name: '[name].[ext]?[hash:7]',
              outputPath: 'img/',
            },
          },
          {
            loader: 'image-webpack-loader',
            options: {
              mozjpeg: {
                progressive: true,
                quality: 65
              },
              // optipng.enabled: false will disable optipng
              optipng: {
                //optimizationLevel: 7,
                enabled: false,
              },
              pngquant: {
                quality: '65-90',
                speed: 4
              },
              gifsicle: {
                interlaced: false,
              },
              svgo: {
                plugins: [
                  {
                    removeViewBox: false
                  },
                  {
                    removeEmptyAttrs: false
                  }
                ]
              },
              // the webp option will enable WEBP
              // webp: {
              //   quality: 75
              // }
            },
          },
        ],
      },
      {
        test: /\.(mp4|webm|ogg|mp3|wav|flac|aac)(\?.*)?$/,
        loader: 'url-loader',
        options: {
          limit: 10000, // Convert images < 10KB to base64 strings with url-loader
          name: '[name].[ext]?[hash:7]',
          outputPath: 'media/',
        }
      },
      {
        test: /\.(woff2?|eot|ttf|otf)(\?.*)?$/,
        loader: 'url-loader',
        options: {
          limit: 10000, // Convert images < 10KB to base64 strings with url-loader
          name: '[name].[ext]?[hash:7]',
          outputPath: 'fonts/',
        }
      }
    ]
  },
  resolve: {
    extensions: ['.js', '.vue', '.json'],
    alias: {
      'vue$': 'vue/dist/vue.esm.js',
      '@': SRC,
    }
  },
  performance: {
    hints: false //'warning'
  },

  plugins: ([
    new ExtractTextPlugin("build.css"),
    new webpack.DefinePlugin({
      'process.env.NODE_ENV': JSON.stringify(ENV)
    }),
    // new webpack.optimize.CommonsChunkPlugin({
    //   name: 'common' // Specify the common bundle's name.
    // }),
  ]).concat(ENV==='production' ? [
    new webpack.optimize.UglifyJsPlugin({
      output: {
        comments: false, //comments: /^!/
      },
      sourceMap: true,
      compress: {
        unsafe_comps: true,
        properties: true,
        keep_fargs: false,
        pure_getters: true,
        collapse_vars: true,
        unsafe: true,
        warnings: false,
        screw_ie8: true,
        sequences: true,
        dead_code: true,
        drop_debugger: true,
        comparisons: true,
        conditionals: true,
        evaluate: true,
        booleans: true,
        loops: true,
        unused: true,
        hoist_funs: true,
        if_return: true,
        join_vars: true,
        cascade: true,
        drop_console: true
      }
    }),
  ] : []),
  devtool: ENV==='production' ? 'source-map' : 'eval',
}
