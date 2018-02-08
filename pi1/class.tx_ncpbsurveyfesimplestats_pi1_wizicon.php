<?php

$GLOBALS['LANG']->includeLLFile('EXT:nc_pbsurveyfesimplestats/Resources/Private/Language/locallang_db.xml');

/**
 * Class that adds the wizard icon.
 */
class tx_ncpbsurveyfesimplestats_pi1_wizicon
{
    function proc($wizardItems)
    {
        $wizardItems["plugins_tx_ncpbsurveyfesimplestats_pi1"] = array(
            "icon" => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath("nc_pbsurveyfesimplestats") . "ext_icon.gif",
            "title" => $GLOBALS['LANG']->getLL("tx_ncpbsurveyfesimplestats_pluginname"),
            "description" => $GLOBALS['LANG']->getLL("tx_ncpbsurveyfesimplestats_plugindescription"),
            "params" => "&defVals[tt_content][CType]=list&defVals[tt_content][list_type]=nc_pbsurveyfesimplestats_pi1"
        );

        return $wizardItems;
    }
}