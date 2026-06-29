import { defineConfig } from 'vite';
import { resolve } from 'path';

export default defineConfig({
  root: '.',
  base: './',
  build: {
    outDir: 'assets/dist',
    emptyOutDir: false,
    rollupOptions: {
      input: {
        admin: resolve(__dirname, 'resources/js/admin.entry.js'),
        front: resolve(__dirname, 'resources/js/front.entry.js')
      },
      external: ['jquery', 'moment'],
      output: {
        entryFileNames: 'js/[name]-[hash].js',
        chunkFileNames: 'js/[name]-[hash].js',
        assetFileNames: 'css/[name]-[hash][extname]',
        globals: {
          jquery: 'jQuery',
          moment: 'moment'
        }
      }
    }
  },
  publicDir: false,
  css: {
    preprocessorOptions: {}
  }
});
