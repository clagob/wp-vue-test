const
  webpack = require('webpack'),
  path = require('path'),
  ENV = process.env.NODE_ENV || 'development',
  CSS_MAPS = ENV!=='production'


// CUSTOM Folders
const
  THEME_FOLDER = 'wp-vue',
  DIST = path.resolve(__dirname, './' + THEME_FOLDER + '/dist/'),
  PUBLIC_DIST = '/' + THEME_FOLDER + '/dist/',
  SRC = path.resolve(__dirname, './src'),
  SRC_IMG   = SRC + '/assets/img/',
  SRC_JS    = SRC + '/assets/js/',
  SRC_SCSS  = SRC + '/assets/scss/',
  SRC_FONTS = SRC + '/assets/fonts/',
  NODE_MODULES = path.resolve(__dirname, './node_modules')


// Plugins
const
  UglifyJsPlugin = require('uglifyjs-webpack-plugin'),
  ExtractTextPlugin = require("extract-text-webpack-plugin"),
  autoprefixer = require('autoprefixer'),
  //CopyWebpackPlugin = require('copy-webpack-plugin'),
  ImageminPlugin = require('imagemin-webpack-plugin').default



module.exports = {
  context: SRC,
  entry: ['./main.js'], //'./assets/scss/index.scss'],

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
        include: SRC_JS,
        loader: 'babel-loader',
      },
      {
        test: /\.html$/i,
        exclude: NODE_MODULES,
        loader: 'raw-loader',
      },
      {
        test: /\.css$/i,
        exclude: NODE_MODULES,
        use: [
          'style-loader',
          { loader: 'css-loader', options: { sourceMap: CSS_MAPS, importLoaders: 1 } },
          { loader: 'postcss-loader', options: { sourceMap: CSS_MAPS } },
        ],
      },
      {
        // Extract all the CSS from the JS
        test: /\.scss$/i,
        exclude: NODE_MODULES,
        use: ExtractTextPlugin.extract({
          use: [
            { loader: 'css-loader', options: { sourceMap: CSS_MAPS, importLoaders: 1 } },
            { loader: 'postcss-loader', options: { sourceMap: CSS_MAPS } },
            'sass-loader',
          ],
          fallback: "style-loader",
        })
      },
      // {
      //   test: /\.(png|jpe?g|gif|svg)$/i,
      //   include: SRC_IMG,
      //   use: [
      //     {
      //       loader: 'url-loader', // 'file-loader',
      //       options: {
      //         limit: 8192, // Convert images < 8kB to base64 strings with url-loader
      //         name: '[name].[ext]?[hash]',
      //         outputPath: 'img/',
      //       },
      //     },
      //     {
      //       loader: 'image-webpack-loader',
      //       options: {
      //         mozjpeg: {
      //           progressive: true,
      //           quality: 65
      //         },
      //         // optipng.enabled: false will disable optipng
      //         optipng: {
      //           //optimizationLevel: 7,
      //           enabled: false,
      //         },
      //         pngquant: {
      //           quality: '65-90',
      //           speed: 4
      //         },
      //         gifsicle: {
      //           interlaced: false,
      //         },
      //         svgo: {
      //           plugins: [
      //             {
      //               removeViewBox: false
      //             },
      //             {
      //               removeEmptyAttrs: false
      //             }
      //           ]
      //         },
      //         // the webp option will enable WEBP
      //         // webp: {
      //         //   quality: 75
      //         // }
      //       },
      //     },
      //   ],
      // },
      // {
      //   test: /\.woff($|\?)|\.woff2($|\?)|\.ttf($|\?)|\.eot($|\?)|\.svg($|\?)/,
      //   include: SRC_FONTS,
      //   loader: 'url-loader'
      // },
      {
        test: /\.(png|jpe?g|gif|svg)(\?.*)?$/,
        loader: 'url-loader',
        options: {
          limit: 10000, // Convert images < 10KB to base64 strings with url-loader
          name: '[name].[hash:7].[ext]',
          outputPath: 'img/',
        }
      },
      {
        test: /\.(mp4|webm|ogg|mp3|wav|flac|aac)(\?.*)?$/,
        loader: 'url-loader',
        options: {
          limit: 10000, // Convert images < 10KB to base64 strings with url-loader
          name: '[name].[hash:7].[ext]',
          outputPath: 'media/',
        }
      },
      {
        test: /\.(woff2?|eot|ttf|otf)(\?.*)?$/,
        loader: 'url-loader',
        options: {
          limit: 10000, // Convert images < 10KB to base64 strings with url-loader
          name: '[name].[hash:7].[ext]',
          outputPath: 'fonts/',
        }
      }
    ]
  },
  resolve: {
    alias: {
      'vue$': 'vue/dist/vue.esm.js'
    }
  },
  resolve: {
    extensions: ['.js', '.vue', '.json'],
    alias: {
      'vue$': 'vue/dist/vue.esm.js',
      '@': SRC,
    }
  },
  performance: {
    hints: 'warning'
  },

  plugins: ([
    new ExtractTextPlugin({
      filename: './css/[name].min.css',
      allChunks: true,
      disable: true,
    }),
    new webpack.DefinePlugin({
      'process.env.NODE_ENV': JSON.stringify(ENV)
    }),


    // new CopyWebpackPlugin(
    //   [
    //     {
    //       // Optimize all the images
    //       // Good for when the images are not always referenced
    //       context: SRC_IMG,
    //       from: '**/*',
    //       to: './img'
    //     },
    //   ],
    //   {
    //     //copyUnmodified: true
    //   }
    // ),

    // new ImageminPlugin({
    //   test: /\.(png|jpe?g|gif|svg)$/i,
    //   mozjpeg: {
    //     progressive: true,
    //     quality: 65
    //   },
    //   // optipng.enabled: false will disable optipng
    //   optipng: {
    //     //optimizationLevel: 7,
    //     enabled: false,
    //   },
    //   pngquant: {
    //     quality: '65-90',
    //     speed: 4
    //   },
    //   gifsicle: {
    //     interlaced: false,
    //   },
    //   svgo:{
    //     plugins: [
    //       {
    //         removeViewBox: false
    //       },
    //       {
    //         removeEmptyAttrs: false
    //       }
    //     ]
    //   },
    //   // the webp option will enable WEBP
    //   // webp: {
    //   //   quality: 75
    //   // }
    // }),

    // new webpack.DefinePlugin({
    //   'process.env': {
    //     NODE_ENV:  process.env.NODE_ENV === 'production' ? '"production"' : '"development"'
    //   }
    // })

    // new webpack.ProvidePlugin({
    //     $: 'jquery',
    //     jQuery: 'jquery',
    //     Popper: 'popper.js/dist/umd/popper.js',
    //     'window.cookieconsent': 'cookieconsent'
    // }),

    // new UglifyJsPlugin(
    //   {
    //     sourceMap: true,
    //     uglifyOptions: {
    //       output: {
    //         comments: /^!/
    //       },
    //       compress : {
    //         warnings: false
    //       }
    //     }
    //   }
    // ),

    // new webpack.optimize.UglifyJsPlugin({
    //     sourceMap: true,
    //     compress: {
    //         warnings: false
    //     }
    // }),
    // new webpack.LoaderOptionsPlugin({
    //   minimize: true
    // }),

  ]).concat(ENV==='production' ? [
    new webpack.optimize.UglifyJsPlugin({
      output: {
        comments: false, //comments: /^!/
      },
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



if (process.env.NODE_ENV === 'production') {


  module.exports.plugins = (module.exports.plugins || []).concat([
    // new webpack.optimize.UglifyJsPlugin({
    //     sourceMap: true,
    //     compress: {
    //         warnings: false
    //     }
    // }),
    // new webpack.LoaderOptionsPlugin({
    //   minimize: true
    // }),

    // new UglifyJsPlugin(
    //   {
    //     sourceMap: true,
    //     uglifyOptions: {
    //       // output: {
    //       //   comments: /^!/
    //       // },
    //       compress : true,
    //       warnings: false,
    //     },
    //   }
    // ),

  ])

}
