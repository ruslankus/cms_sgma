/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	config.toolbar = [
	{ name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike' ] },
	{ name: 'align', items: [ 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] },
	{ name: 'format', items: [ 'Format' ] },
	{ name: 'paragraph', items: [ 'NumberedList', 'BulletedList' ] },
	'/',
	{ name: 'paragraph25', items: [ 'Outdent', 'Indent' ] },
	{ name: 'undoredo', items: [ 'Undo', 'Redo' ] },
	{ name: 'lnk', items: [ 'Link', 'Unlink', 'Image', 'CreateDiv' ] },
	{ name: 'tbl', items: [ 'HorizontalRule', 'Table' ] },
	{ name: 'sc', items: [ 'Subscript', 'Superscript' ] },
	{ name: 'spec', items: [ 'SpecialChar' ] }
];
};
