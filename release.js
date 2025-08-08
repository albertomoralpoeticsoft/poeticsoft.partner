const fs = require('fs');
const path = require('path');
const archiver = require('archiver');

// E:\trabajo\poeticsoft\poeticsoft.partner\wp-content\plugins\poeticsoft-partner
const sourceDir = path.resolve(__dirname, './wp-content/plugins/poeticsoft-partner');
const outputDir = path.resolve(__dirname, './plugins');

const zipFileName = process.argv[2];

if (!fs.existsSync(outputDir)) {

  fs.mkdirSync(outputDir);
}

const outputPath = path.join(outputDir, zipFileName);
const output = fs.createWriteStream(outputPath);
const archive = archiver('zip', { zlib: { level: 9 } });

output.on('close', () => {

  console.log(`Directorio origen: ${ sourceDir }`);
  console.log(`✅ Archivo comprimido con éxito: ${ archive.pointer() } bytes.`);
  console.log(`El archivo ZIP se encuentra en: ${ outputPath }`);
});

archive.on('warning', (err) => {

  if (err.code === 'ENOENT') {

    console.warn(err);

  } else {

    throw err;
  }
});

archive.on('error', (err) => {

  throw err;
});

archive.pipe(output);
archive.directory(sourceDir, 'poeticsoft-partner');
archive.finalize();