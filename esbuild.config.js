import * as esbuild from 'esbuild'

await esbuild.build({
    entryPoints: [
        'resources/js/passkey.js',
        'resources/css/passkey.css',
    ],
    outdir: 'resources/dist',
    entryNames: '[name]',
    bundle: true,
    minify: true,
    sourcemap: false,
    target: 'es2020',
    format: 'iife',
    platform: 'browser',
    logLevel: 'info',
})
