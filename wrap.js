var autoprefixer = require('autoprefixer');
var postcss = require('postcss');
var data = '';

process.stdin.on('data', function(chunk) {
  data += chunk;
});

process.stdin.on('end', function() {
  data = JSON.parse(data);

  var plugin = autoprefixer({ browsers: data.browsers });

  for (var i in data.css) {
    try {
      data.css[i] = postcss([ plugin ]).process(data.css[i], { from: undefined }).css;
    } catch (e) {
      data.css[i] = 'Error: ' + e.message;
    }
  }

  process.stdout.write(JSON.stringify(data.css));
});