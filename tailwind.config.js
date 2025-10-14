/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {},
  },
   plugins: [
     require('tailwind-scrollbar')({ nocompatible: true }),
  ],

  safelist: [
  'bg-green-500', 'hover:bg-green-600',
  'bg-orange-500', 'hover:bg-orange-600',
  'text-white'
],

};
