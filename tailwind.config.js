const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Nunito", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    100: "#ebeefa",
                    200: "#c2cdef",
                    300: "#9aace4",
                    400: "#728ada",
                    500: "#4969cf",
                    600: "#304fb6",
                    700: "#253e8d",
                    800: "#1b2c65",
                    900: "#101a3d",
                },
            },
        },
    },

    plugins: [require("@tailwindcss/forms")],
};
