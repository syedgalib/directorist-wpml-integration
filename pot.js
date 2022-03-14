const wpPot = require('wp-pot');
 
wpPot({
  destFile: './languages/directorist-wpml-integration.pot',
  domain: 'directorist-wpml-integration',
  package: 'Simple Todo',
  src: './**/*.php'
});