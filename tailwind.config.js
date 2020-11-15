module.exports = {
  future: {
    // removeDeprecatedGapUtilities: true,
    // purgeLayersByDefault: true,
  },
  purge: [
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php'
  ],
  theme: {
    extend: {},
  },
  variants: {},
  plugins: [],
}
