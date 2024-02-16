import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path'; // Import path module for correct file paths

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true, // Enable hot reloading for Laravel components
        }),
        vue({
            template: {
                transformAssetUrls: {
                    // Re-write URLs to Vite server, but respect public assets
                    base: process.env.NODE_ENV === 'production' ? './' : 'http://localhost:8000',
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'), // Use path.resolve for correct alias paths
            bootstrap: path.resolve(__dirname, 'node_modules/bootstrap'), // Point alias to Bootstrap root
            'popper.js': path.resolve(__dirname, 'node_modules/popper.js'), // Correct popper.js alias
        },
    },
    css: {
        preprocessorOptions: {
            scss: {
                additionalData: `@import "@/scss/main.scss";`, // Import your main SCSS file
            },
        },
    },
    build: {
        outDir: 'public', // Output directory for Vite build
        manifest: true, // Generate asset manifest for Laravel Vite plugin
        rollupOptions: {
            input: ['resources/js/app.js'], // Specify entry point for build
        },
    },
});
