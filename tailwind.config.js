module.exports = {
  future: {
    // removeDeprecatedGapUtilities: true,
    // purgeLayersByDefault: true,
  },
  purge: {
    mode: 'layers',
    layers: ['base', 'components', 'utilities'],
    content: [
      './storage/framework/views/*.php',
      './resources/views/**/*.blade.php'
    ],
  },
  theme: {
    extend: {},
  },
  variants: {},
  plugins: [],
}
