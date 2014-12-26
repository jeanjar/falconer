#!/usr/bin/nodejs

var fs = require('fs');
var path = require('path');
var exec = require('child_process').exec;
var dir = '/home/jaon/projects/falconer/src/Falconer/Helper/Definition/';
var fileDir = dir + process.argv[2] + '.php';

//fs.closeSync(fs.openSync(fileDir, 'w'));
var data = '<?php \n\n' +
          'namespace Falconer\Helper\Definition;\n\n' +
          'class ' + process.argv[2] + ' extends DefinitionHelper {\n' +
          '    public static function getStruct()\n    {\n        \n    }\n}';

fs.writeFile(fileDir, data, function(err) {
  if(err) throw err;
  exec('atom ' + fileDir);
});

console.log(fileDir);
