module.exports = {
	purge: [
		'./resources/**/*.blade.php',
		'./resources/**/*.js',
		'./resources/**/*.vue',
	  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
		zIndex: {        
			'999999': '999999',      
		}
	},
  },
  variants: {
    extend: {},
  },
  plugins: [
	require('@tailwindcss/forms')
  ],
}
