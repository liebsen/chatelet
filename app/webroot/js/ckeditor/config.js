/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
  // Define changes to default configuration here. For example:
  // config.language = 'fr';
  config.uiColor = '#AADC6E';
  config.allowedContent = true;
  config.language = 'es'
  /*config.toolbar = [
      { name: 'styles', items : [ 'Format' ] },
      { name: 'basicstyles', items : [ 'Bold','Italic','Strike'] },
      { name: 'links', items : [ 'Link','Unlink' ] },
      // { name: 'align', items : [ 'Align','TextAlign', 'Justify', 'Align' ] },
      { name: 'paragraph', items : [ 'NumberedList','BulletedList','Blockquote','Outdent','Indent' ] },
      { name: 'tools', items : [ 'Image', 'Maximize' ] }
  ];*/
  // Specific plugins we need
  // config.extraPlugins = 'table,tabletools,justify'
  // Remove unnecessary plugins
  config.removePlugins = 'about,flash,forms,div,smiley,save,elementspath';
  // config.filebrowserUploadMethod = 'form';
  config.filebrowserUploadUrl = '/api/ckupload';  

};
