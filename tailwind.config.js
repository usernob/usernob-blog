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
                sans: ["Poppins", ...defaultTheme.fontFamily.sans],
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
                ancent_alt: "#E65050",
                ancent: "#d84a3d",
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
        createThemes({
            dark: {
                background: "#252931",
                foreground: "#EAEAEB",
                background2: "#1e222a",
                foreground2: "#abb2bf",
                placeholder: "#42464e"
            },
            light: {
                background: "#EAEAEB",
                foreground: "#252931",
                background2: "#fafafa",
                foreground2: "#383a42",
                placeholder: "#dadadb"
            }
        })
    ],
};
