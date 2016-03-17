/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	//config.uiColor = '#AADC6E';
	config.toolbar = [
	{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline' ] },
	{ name: 'paragraph', groups: [ 'list'], items: [ 'NumberedList', 'BulletedList'] },
	{ name: 'paragraph2', groups: [ 'list'], items: [ 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
	{ name: 'links', items: [ 'Link', 'Unlink'] },
	{ name: 'styles', items: [ 'Format', 'FontSize' ] },
	{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
];
	
};
