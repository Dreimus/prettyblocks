import {defineConfig} from 'vite'
import vue from '@vitejs/plugin-vue'
import {resolve} from 'path'

// https://vitejs.dev/config/
export default defineConfig({
    base: '/modules/prettyblocks/src/Resources/public/',
    plugins: [vue()],
    build: {
        manifest: true,
        outDir: "../public/",
        emptyOutDir: true,
        rollupOptions: {
            input: {
                index: resolve(__dirname, 'index.html'),
            },
            output: {
                entryFileNames: 'prettyblocks_editor.js',
                chunkFileNames: 'prettyblocks_editor.js',
                assetFileNames: 'prettyblocks_editor.css',
            }
        }
    },
    server: {
        host: '0.0.0.0',
        https: true,
        port: 3000,
      // hmr: {
      //   host: 'localhost',
      //   protocol: 'ws'
      // }
    }
})
