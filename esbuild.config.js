import * as esbuild from 'esbuild'

const isProduction = process.env.NODE_ENV === 'production'

await esbuild.build({
    entryPoints: ['resources/js/passkey.js'],
    outfile: 'resources/dist/passkey.js',
    bundle: true,
    minify: isProduction,
    sourcemap: !isProduction,
    target: 'es2020',
    format: 'iife',
    platform: 'browser',
    logLevel: 'info',
})
