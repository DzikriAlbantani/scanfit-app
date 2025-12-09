/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
    './resources/css/**/*.css',
  ],
  theme: {
    extend: {
      backgroundImage: {
        'brand-haze': "linear-gradient(135deg, rgba(200,217,230,0.25) 0%, rgba(255,255,255,0.85) 40%, #f8fafc 100%)",
      },
      colors: {
        'brand-dark': '#2F4156',
        'brand-secondary': '#567C8D',
        'brand-beige': '#F5F5DC',
        'brand-bg': '#C8D9E6',
      },
    },
  },
  plugins: [],
}
