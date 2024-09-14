module.exports = {
  configureWebpack: {
    resolve: {
      alias: {
        '@': require('path').resolve(__dirname, 'src'),
      },
    },
  },

  devServer: {
    port: 8080,
    open: true, // Secara otomatis membuka browser setelah server dimulai
  },
}
