import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
	content: [
		"./resources/views/**/*.blade.php",
		"./resources/js/**/*.{tsx,ts}",
	],
	theme: {
		extend: {
			screens: {
				xs: "425px",
			},
			colors: {
				primary: {
					50: "rgb(var(--color-primary-50, 236 253 245) / <alpha-value>)",
					100: "rgb(var(--color-primary-100, 209 250 229) / <alpha-value>)",
					200: "rgb(var(--color-primary-200, 167 243 208) / <alpha-value>)",
					300: "rgb(var(--color-primary-300, 110 231 183) / <alpha-value>)",
					400: "rgb(var(--color-primary-400, 52 211 153) / <alpha-value>)",
					500: "rgb(var(--color-primary-500, 16 185 129) / <alpha-value>)",
					600: "rgb(var(--color-primary-600, 5 150 105) / <alpha-value>)",
					700: "rgb(var(--color-primary-700, 4 120 87) / <alpha-value>)",
					800: "rgb(var(--color-primary-800, 6 95 70) / <alpha-value>)",
					900: "rgb(var(--color-primary-900, 6 78 59) / <alpha-value>)",
				},
			},
			backgroundColor: {
				background: "#F4F5F7",
			},
			fontFamily: {
				sans: ["Inter", ...defaultTheme.fontFamily.sans],
			},
		},
	},
	plugins: [forms],
};
