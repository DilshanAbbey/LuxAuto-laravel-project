/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./storage/framework/views/*.php",
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Instrument Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
      },
      colors: {
        'primary-bg': '#e0f0ff',
        'accent': '#007bff',
        'success': '#28a745',
        'error': '#dc3545',
      },
    },
  },
  plugins: [],
  safelist: [
  'active', // for tabs
  'bg-accent', 'text-accent', 'from-accent', 'to-blue-700',
  'auth-tab', 'auth-form',
  'bg-primary-bg'
  ],
}