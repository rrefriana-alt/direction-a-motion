/* Inlines assets/js/hero-gl.js into index.html as a module script.
   Browsers block ES modules loaded from file:// (CORS), so a separate
   hero-gl.js file would silently do nothing when the page is opened by
   double-clicking. Inline module scripts are exempt, and the `three` import
   still resolves through the import map to the CDN.
   Run after editing hero-gl.js:  node _inline-gl.js                        */
const fs = require('fs');
const src = fs.readFileSync(__dirname + '/assets/js/hero-gl.js', 'utf8');
const file = __dirname + '/index.html';
let html = fs.readFileSync(file, 'utf8');
const open = '<script type="module" data-gl>';
const close = '</scr' + 'ipt>';
const block = open + '\n' + src + '\n' + close;
html = html.replace(/<script type="module" src="assets\/js\/hero-gl\.js"><\/script>/, block)
           .replace(/<script type="module" data-gl>[\s\S]*?<\/script>/, block);
fs.writeFileSync(file, html);
console.log('inlined hero-gl.js into index.html');
