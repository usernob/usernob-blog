import defaultTheme from "tailwindcss/defaultTheme";
import { createThemes } from "tw-colors";
/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "class",
    content: [
        "./storage/framework/views/*.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ["Geist", ...defaultTheme.fontFamily.sans],
                mono: ["JetBrains Mono", ...defaultTheme.fontFamily.mono],
            },
            animation: {
                blink: "blink 1s linear infinite",
            },
            keyframes: {
                blink: {
                    "0%": { opacity: "1" },
                    "50%": { opacity: "0" },
                    "100%": { opacity: "1" },
                },
            },
            colors: {
                background: "var(--background)",
                foreground: "var(--foreground)",
                background2: "var(--background2)",
                foreground2: "var(--foreground2)",
                secondary: "#E65050",
                ancent: {
                    DEFAULT: "rgb(var(--ancent) / <alpha-value>)",
                    hover: "rgb(var(--ancent) / 0.75)",
                    disable: "rgb(var(--ancent) / 0.5)",
                },
                placeholder: "var(--placeholder)",
            },
        },
        container: {
            center: true,
            padding: "1rem",
        },
    },
    plugins: [
        require("@tailwindcss/typography"),
        require("@tailwindcss/forms"),
    ],
};
