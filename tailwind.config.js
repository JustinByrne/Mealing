module.exports = {
  purge: [],
  darkMode: 'class', // or 'media' or 'class'
  theme: {
    extend: {},
  },
  variants: {
    extend: {
      borderWidth: ['hover']
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}
