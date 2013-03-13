<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'TYPO3.' . $_EXTKEY,
	'List',
	array(
		'Comment' => 'list, enable, disable, delete',
	),
	// non-cacheable actions
	array(
		'Comment' => 'enable, disable, delete',
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'TYPO3.' . $_EXTKEY,
	'New',
	array(
		'Comment' => 'new, create',
	),
	// non-cacheable actions
	array(
		'Comment' => 'new',
	)
);

?>