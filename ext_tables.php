<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

	// Delete fields from backend plugin form
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key,recursive';
	// Adds Simple Stats to the list of plugins in content elements of type 'Insert plugin'
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(array('LLL:EXT:nc_pbsurveyfesimplestats/Resources/Private/Language/locallang_db.xml:tx_ncpbsurveyfesimplestats_pluginname', $_EXTKEY.'_pi1'),'list_type');
	// initialize static extension templates
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY,'Configuration/TypoScript/ts/','default TS');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY,'Configuration/TypoScript/css/','default CSS');

if (TYPO3_MODE=='BE') {
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_ncpbsurveyfesimplestats_pi1_wizicon'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).'pi1/class.tx_ncpbsurveyfesimplestats_pi1_wizicon.php';
}