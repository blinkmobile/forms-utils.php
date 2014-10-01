/*jslint indent:2, node:true*/

module.exports = function (grunt) {
  'use strict';

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json')
  });

  grunt.loadNpmTasks('grunt-phpunit');

  grunt.initConfig({
    phpunit: {
      classes: {
        dir: 'blinkmobile/forms/utils/errors/tests'
      },
      options: {
        bin: 'php vendor/phpunit/phpunit/phpunit.php',
        colors: true
      }
    },
    watch: {
      test: {
        files: ['blinkmobile/forms/utils/errors/tests/*.php'],
        tasks: ['phpunit']
      }
    }

  });

  grunt.loadNpmTasks('grunt-phpunit');
  grunt.loadNpmTasks('grunt-contrib-watch');

  // Default task(s).
  grunt.registerTask('default', ['phpunit']);

};
