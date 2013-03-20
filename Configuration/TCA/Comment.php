<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_commentsbase_domain_model_comment'] = array(
	'ctrl' => $TCA['tx_commentsbase_domain_model_comment']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, entry_id, text, author_name, author_email, author_url, author, parent',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, entry_id, text, author_name, author_email, author_url, author, parent,--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_commentsbase_domain_model_comment',
				'foreign_table_where' => 'AND tx_commentsbase_domain_model_comment.pid=###CURRENT_PID### AND tx_commentsbase_domain_model_comment.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'entry_id' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:comments_base/Resources/Private/Language/locallang_db.xlf:tx_commentsbase_domain_model_comment.entry_id',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'text' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:comments_base/Resources/Private/Language/locallang_db.xlf:tx_commentsbase_domain_model_comment.text',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			),
		),
		'author_name' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:comments_base/Resources/Private/Language/locallang_db.xlf:tx_commentsbase_domain_model_comment.author_name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'author_email' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:comments_base/Resources/Private/Language/locallang_db.xlf:tx_commentsbase_domain_model_comment.author_email',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'author_url' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:comments_base/Resources/Private/Language/locallang_db.xlf:tx_commentsbase_domain_model_comment.author_url',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'author' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:comments_base/Resources/Private/Language/locallang_db.xlf:tx_commentsbase_domain_model_comment.author',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'fe_users',
				'minitems' => 0,
				'maxitems' => 1,
			),
		),
		'parent' => array(
			'exclude' => 0,
			'label' => 'Parent',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_commentsbase_domain_model_comment',
				'minitems' => 0,
				'maxitems' => 1,
			),
		),

		'children' => array(
			'config' => array(
				'type' => 'passthrough',
				'foreign_table' => 'tx_commentsbase_domain_model_comment',
				'foreign_field' => 'parent',
			),
		),

	),
);

?>