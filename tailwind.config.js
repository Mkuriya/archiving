/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        'vibrant': '#F88848',
        'vibrant-light' : '#f89048',
        'muted' : '#888888',
        'muted-dark' : '#503030',
        'muted-semi' : '#f1e7e3',
        'muted-light' : '#E8E0D0',
        'whitebg' : '#701d0b',
        'thbg' : '#4FC3A1',
        'thodd' : '#324960',
      },
    },
  },
  plugins: [],
}

