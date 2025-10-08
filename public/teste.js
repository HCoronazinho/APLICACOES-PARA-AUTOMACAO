import fs from 'fs';

// Lê o GeoJSON exportado do Mapshaper
const geojsonData = fs.readFileSync('bairros_poa.json', 'utf8');
const geojson = JSON.parse(geojsonData);

// Pega o nome correto dos bairros
const bairros = geojson.features.map(f => f.properties.NOME?.trim()).filter(Boolean);

// Remove duplicados e ordena
const bairrosUnicos = [...new Set(bairros)].sort((a, b) => a.localeCompare(b));

// Gera as queries de inserção
const inserts = bairrosUnicos.map(b => 
  `INSERT INTO bairros_oficiais (nome_bairro) VALUES ('${b.replace(/'/g, "''")}');`
);

console.log('\n--- QUERIES PARA INSERIR BAIRROS ---\n');
console.log(inserts.join('\n'));
console.log(`\nTotal de bairros: ${bairrosUnicos.length}`);
