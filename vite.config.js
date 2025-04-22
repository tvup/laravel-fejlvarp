import { defineConfig } from 'vite'

export default defineConfig({
    root: 'resources',
    build: {
        outDir: '../public',
        emptyOutDir: true,
        rollupOptions: {
            input: {
                app: '/css/app.css',
            },
            output: {
                assetFileNames: 'app.css',
            },
        },
    },
})
