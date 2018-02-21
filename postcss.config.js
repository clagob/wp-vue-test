module.exports = (ctx) => ({
  parser: ctx.parser ? 'sugarss' : false,
  map: ctx.env === 'development' ? ctx.map : false,
  plugins: {
    'postcss-import': {},
    'postcss-nested': {},
    // to edit target browsers: use "browserslist"
    'autoprefixer': {},
    cssnano: ctx.env === 'production' ? {} : false
  }
})
