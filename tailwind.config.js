module.exports = {
  purge: [
    './resources/views/**/*.blade.php',
    './resources/css/**/*.css',
  ],
  theme: {
    extend: {
      spacing:{
        '128':'32rem'
      }
    }
  },
  variants: {},
  plugins: [
    require('@tailwindcss/ui'),
  ]
}
