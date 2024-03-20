/* eslint-env node */
/** @type {import('tailwindcss').Config} */

const colors = require('tailwindcss/colors')

export default {
  content: ['./src/**/*.{vue,js}'],
  theme: {
    extend: { colors }
  },
  plugins: []
}
