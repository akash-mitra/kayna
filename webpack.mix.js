let mix = require('laravel-mix');
let tailwindcss = require('tailwindcss');
let glob = require("glob-all");
let PurgecssPlugin = require("purgecss-webpack-plugin");


/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
mix.js('resources/js/editor.js', 'public/js')

        


/*
 |--------------------------------------------------------------------------
 | Mix Asset Management - CSS Libraries
 |--------------------------------------------------------------------------
 |
 */
mix.sass('resources/sass/app.scss', 'public/css').options({
        processCssUrls: false,
        postCss: [tailwindcss('./tailwind.js')],
})




// Custom PurgeCSS extractor for Tailwind that allows special characters in
// class names.
//
// https://github.com/FullHuman/purgecss#extractor
class TailwindExtractor {
        static extract(content) {
                return content.match(/[A-Za-z0-9-_:\/]+/g) || [];
        }
}


if (mix.inProduction()) {

        // Only run PurgeCSS during production builds for faster development builds
        // and so you still have the full set of utilities available during
        // development.
        mix.webpackConfig({
                plugins: [
                        new PurgecssPlugin({

                                // Specify the locations of any files you want to scan for class names.
                                paths: glob.sync([
                                        path.join(__dirname, "resources/views/**/*.blade.php"),
                                        path.join(__dirname, "resources/js/**/*.vue")
                                ]),
                                extractors: [
                                        {
                                                extractor: TailwindExtractor,

                                                // Specify the file extensions to include when scanning for
                                                // class names.
                                                extensions: ["html", "js", "php", "vue"]
                                        }
                                ]
                        })
                ]
        });

        mix.sourceMaps();

        // The version method will automatically append a unique hash to the 
        // filenames of all compiled files, allowing for more 
        // convenient cache busting
        mix.version();

        // no notification if mix is triggered in production
        mix.disableNotifications();
        
}