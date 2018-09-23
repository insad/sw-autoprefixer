# Shopware CSS Prefixer

This Shopware plugin automatically adds CSS vendor prefixes for the current theme using [postcss/Autoprefixer](https://github.com/postcss/autoprefixer).  
Supported browsers can be configured using a [browserlist query](https://github.com/browserslist/browserslist#best-practices).  
The autoprefixer runs every time the `sw:theme:cache:generate` command is executed.  

## Requirements

[NodeJS](https://nodejs.org) needs to be installed on the server.  
The plugin has been tested with Shopware 5.5.1 and Node.js 8.12.0

## Installing

<pre>
cd Shopware/custom/plugins
git clone https://github.com/maxia/sw-autoprefixer.git Autoprefixer
cd ../../
./bin/console sw:plugin:refresh
./bin/console sw:plugin:install --activate Autoprefixer
./bin/console sw:cache:clear
</pre>

## License

[MIT](https://raw.github.com/maxia/shopware-css-prefixer/master/LICENSE)