const colors = require('tailwindcss/colors')

module.exports = {
  darkMode: 'class',
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
    extend: {
      colors: {
        blueGray: colors.blueGray,
        coolGray: colors.coolGray,
        gray: colors.gray,
        trueGray: colors.trueGray,
        warmGray: colors.warmGray,
        orange: colors.orange,
        amber: colors.amber,
        yellow: colors.yellow,
        lime: colors.lime,
        green: colors.green,
        emerald: colors.emerald,
        teal: colors.teal,
        cyan: colors.cyan,
        lightBlue: colors.lightBlue,
        violet: colors.violet,
        purple: colors.purple,
        fuchsia: colors.fuchsia,
        rose: colors.rose,
      },
    },
  },
  variants: {},
  plugins: [],
}
