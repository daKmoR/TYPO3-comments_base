<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'List',
	'Comments: Show List'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'New',
	'Comments: Show Create Form'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Comments');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_commentsbase_domain_model_comment', 'EXT:comments_base/Resources/Private/Language/locallang_csh_tx_commentsbase_domain_model_comment.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_commentsbase_domain_model_comment');
$TCA['tx_commentsbase_domain_model_comment'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:comments_base/Resources/Private/Language/locallang_db.xlf:tx_commentsbase_domain_model_comment',
		'label' => 'entry_id',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'sorting',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'entry_id,text,author_name,author_email,author_url,author,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Comment.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_commentsbase_domain_model_comment.gif'
	),
);
/*
$tmp_comments_base_columns = array(

	'comments' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:comments_base/Resources/Private/Language/locallang_db.xlf:tx_commentsbase_domain_model_frontenduser.comments',
		'config' => array(
			'type' => 'inline',
			'foreign_table' => 'tx_commentsbase_domain_model_comment',
			'foreign_field' => 'frontenduser',
			'maxitems'      => 9999,
			'appearance' => array(
				'collapseAll' => 0,
				'levelLinksPosition' => 'top',
				'showSynchronizationLink' => 1,
				'showPossibleLocalizationRecords' => 1,
				'showAllLocalizationLink' => 1
			),
		),
	),
);


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('fe_users',$tmp_comments_base_columns);

$TCA['fe_users']['columns'][$TCA['fe_users']['ctrl']['type']]['config']['items'][] = array('LLL:EXT:comments_base/Resources/Private/Language/locallang_db.xlf:fe_users.tx_extbase_type.Tx_CommentsBase_FrontendUser','Tx_CommentsBase_FrontendUser');

$TCA['fe_users']['types']['Tx_CommentsBase_FrontendUser']['showitem'] = $TCA['fe_users']['types']['Tx_Extbase_Domain_Model_FrontendUser']['showitem'];
$TCA['fe_users']['types']['Tx_CommentsBase_FrontendUser']['showitem'] .= ',--div--;LLL:EXT:comments_base/Resources/Private/Language/locallang_db.xlf:tx_commentsbase_domain_model_frontenduser,';
$TCA['fe_users']['types']['Tx_CommentsBase_FrontendUser']['showitem'] .= 'comments';
*/
?>