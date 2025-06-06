import { defineConfig } from 'vite'
import * as globModule from 'glob';
import path from 'path';
import viteImagemin from 'vite-plugin-imagemin';

const outputDir = path.resolve(__dirname, '../dn-tools-for-klaviyo/assets');

export default defineConfig({
    plugins: [
        viteImagemin({
            gifsicle: { optimizationLevel: 7 },
            optipng: { optimizationLevel: 7 },
            mozjpeg: { quality: 80 },
            svgo: {
                plugins: [
                    { name: 'removeViewBox', active: false },
                    { name: 'removeEmptyAttrs', active: false },
                ],
            },
            webp: { quality: 80 },
            avif: { quality: 80 },
        }),
    ],
    build: {
        rollupOptions: {
            input: globModule.sync('mappings/**/*.{js,css}'),
            output: {
                entryFileNames: (chunkInfo) => {
                    if (chunkInfo.facadeModuleId) {
                        const normalizedId = chunkInfo.facadeModuleId.replace(/\\/g, '/');
                        const match = normalizedId.match(/\/mappings\/(.+)$/);
                        if (match && match[1]) {
                            return match[1];
                        }
                    }
                    return '[name].js';
                },
                chunkFileNames: '[name].js',
                assetFileNames: (assetInfo) => {
                    if (assetInfo.name && assetInfo.name.endsWith('.css')) {
                        const orig = globModule.sync('mappings/**/*.css').find(f => path.basename(f) === assetInfo.name);
                        if (orig) {
                            return orig.replace(/.*mappings[\\/]/, '');
                        }
                    }
                    return '[name][extname]';
                },
            },
        },
        assetsInlineLimit: Infinity, // inline css images
        sourcemap: 'inline',
        minify: true,
        outDir: outputDir,
        emptyOutDir: true,
    },
});