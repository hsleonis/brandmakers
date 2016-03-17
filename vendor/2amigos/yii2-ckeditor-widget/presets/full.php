<?php
/**
 *
 * full preset returns the full toolbar configuration set for CKEditor.
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 */
return [
	'height' => 400,
	'toolbarGroups' => [
		['name' => 'clipboard', 'groups' => ['mode','undo', 'selection', 'clipboard', 'doctools']],
		['name' => 'document',  'groups' => [ 'mode', 'document', 'doctools' ]],
		['name' => 'editing', 'groups' => ['find', 'spellchecker', 'tools', 'about', 'selection']],
		'/',
		['name' => 'paragraph', 'groups' => ['list', 'indent', 'blocks', 'align', 'bidi']],
		['name' => 'forms'],
		['name' => 'basicstyles', 'groups' => [ 'basicstyles', 'cleanup' ]],
		'/',
		['name' => 'styles'],
		['name' => 'blocks'],
		'/',
		['name' => 'basicstyles', 'groups' => ['basicstyles', 'colors','cleanup']],
		['name' => 'links', 'groups' => ['links', 'insert']],
		['name' => 'others'],
	],
];