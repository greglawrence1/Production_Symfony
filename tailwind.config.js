/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './assets/css/**/*.css', // Path to your CSS files
    './templates/navbar.html.twig',
    './templates/registration/register.html.twig',
    './templates/product/product-card.html.twig' // Path to your Twig template files
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}

