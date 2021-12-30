const colors = require("tailwindcss/colors");

module.exports = {
    content: ["./resources/**/*.{html,js,vue}"],
    theme: {
        colors: {
            primary: colors.amber["700"],
            primarylight: colors.amber["500"],
            primarydark: colors.amber["900"],
            white: colors.white,
            black: colors.black,
            gray: colors.gray["400"],
            lightgray: colors.gray["100"],
            error: colors.red["600"],
        },
    },
};
