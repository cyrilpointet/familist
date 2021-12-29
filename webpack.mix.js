const mix = require('laravel-mix');

mix.webpackConfig({
    module: {
        rules: [
            {
                enforce: "pre",
                test: /\.(js|vue)$/,
                loader: "eslint-loader",
                exclude: /node_modules/,
            },
        ],
    },
})
    .js("resources/js/app.js", "public/js")
    .sass("resources/sass/app.scss", "public/css")
    .vue()
    .sourceMaps();

