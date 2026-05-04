import * as esbuild from 'esbuild'

const isProduction = process.env.NODE_ENV === 'production'

await esbuild.build({
    entryPoints: [
        'resources/js/passkey.js',
        'resources/css/passkey.css',
    ],
    outdir: 'resources/dist',
    entryNames: '[name]',
    bundle: true,
    minify: isProduction,
    sourcemap: false,
    target: 'es2020',
    format: 'iife',
    platform: 'browser',
    logLevel: 'info',
})
