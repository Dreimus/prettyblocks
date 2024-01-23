import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [vue()],
  build:{
    manifest: true,
    outDir: "../build/",
    emptyOutDir: true, 
  },
  server: {
    // hmr: {
    //   host: 'vue.prestasafe.com',
    //   clientPort: 443,
    //   protocol: 'wss'
    // } 
    hmr: {
      host: '0.0.0.0',
      protocol: 'ws'
    },
    port: 443,
    host: true,
  }
})
