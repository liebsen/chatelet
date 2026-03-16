/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
  config.allowedContent = true;
  config.language = 'es'
  // config.extraPlugins = 'uploadimage'
  config.toolbar = [
      { name: 'styles', items : [ 'Format' ] },
      { name: 'basicstyles', items : [ 'Bold','Italic','Strike'] },
      { name: 'links', items : [ 'Link','Unlink' ] },
      { name: 'paragraph', items : [ 'NumberedList','BulletedList','Blockquote','Outdent','Indent' ] },
      { name: 'tools', items : [ 'Image', 'Maximize' ] }
  ];
  // Remove unnecessary plugins
  config.removePlugins = 'about,a11yhelp,forms,div,flash,smiley,save,print';
  config.filebrowserUploadUrl = '/api/upload';  
};
