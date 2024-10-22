/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./index.html', './src/**/*.{vue,js,ts,jsx,tsx}'],
  darkMode: true, // or 'media' or 'class'
  theme: {
    extend: {
      fontSize: {
        'heading-1': ['2.25rem', { lineHeight: '2.5rem' }], // 36px
        'heading-2': ['1.875rem', { lineHeight: '2.25rem' }], // 30px
        'heading-3': ['1.5rem', { lineHeight: '2rem' }], // 24px
      },
      fontWeight: {
        heading: '700',
        text: '400',
      },
    },
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
