import { defineConfig } from 'vite'
import { copyFileSync } from 'fs'

export default defineConfig({
    root: 'resources',
    build: {
        outDir: '../resources/dist',
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
    plugins: [
        {
            name: 'copy-favicon',
            closeBundle() {
                try {
                    copyFileSync('resources/static/incidents.ico', 'resources/dist/incidents.ico')
                    console.log('Copied favicon.ico')
                } catch (err) {
                    console.error('Failed to copy favicon.ico:', err)
                }
            }
        }
    ]
})
