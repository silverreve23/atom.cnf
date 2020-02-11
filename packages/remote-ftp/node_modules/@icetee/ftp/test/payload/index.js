process.env.NODE_TLS_REJECT_UNAUTHORIZED = '0';

const Ftp = require('../../lib/connection');
const fs = require('fs');
const path = require('path');

const configFile = fs.readFileSync(path.join(__dirname, '.ftpconfig'), 'utf8');
const config = JSON.parse(configFile);

config.debug = (e) => {
  console.log(e);
};

const f = new Ftp();

f.on('ready', () => {
  f.list((err, list) => {
    if (err) throw err;

    console.dir(list);

    f.end();
  });
});

f.connect(config);
