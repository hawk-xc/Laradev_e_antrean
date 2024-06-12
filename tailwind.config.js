import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                // sans: ["Figtree", ...defaultTheme.fontFamily.sans],
                // sans: ["Inter var", ...defaultTheme.fontFamily.sans],
                sans: ["Montserrat", "sans-serif"],
                times: ['Times New Roman', 'serif'],
            },
            backgroundImage: theme => ({
                'custom-bg': "url('http://localhost:8000/images/mydoodles.png')",
              }),
        },
    },

    daisyui: {
        themes: [
            "light",
            "dark",
            "cupcake",
            "coffee",
            "synthwave",
            "cyberpunk",
        ],
    },

    plugins: [require("daisyui")],
    // plugins: [forms],
};
