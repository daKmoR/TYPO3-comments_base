<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'TYPO3.' . $_EXTKEY,
	'List',
	array(
		'Comment' => 'list, new, create, edit, update',
	),
	// non-cacheable actions
	array(
		'Comment' => 'create, update',
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'TYPO3.' . $_EXTKEY,
	'New',
	array(
		'Comment' => 'new, create, edit, update',
	),
	// non-cacheable actions
	array(
		'Comment' => 'create, update',
	)
);

?>