<?php
/***************************************************************
*  Copyright notice
*  
*  (c) 2007 Patrick Broens (patrick@netcreators)
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is 
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
* 
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * DB Class
 *
 * @author Patrick Broens <patrick@netcreators.com>
 * @package TYPO3
 * @subpackage nc_pbsurveyfesimplestats
 */
class tx_ncpbsurveyfesimplestats_view {
	
	/**
	 * Initialize the object
	 * PHP4 constructor
	 *
	 * @return	void
	 * @see __construct()
	 */
	function tx_ncpbsurveyfesimplestats_view()	{
		$this->__construct();
	}

	/**
	 * Initialization of class
	 *
	 * @return	void
	 */
	function __construct() {
	}
	
	function setCaller(& $oPi) {
		$this->oPi = & $oPi;
	}
	
	function setConfiguration($aConf) {
		$this->aConf = $aConf;
		$this->setTemplateFile($aConf['templateFile']);
	}
	
	function setTemplateFile($sTemplate) {
		$this->sContent = $this->oPi->cObj->fileResource($sTemplate);
	}
	
	function setRespondents($oRespondents) {
		$this->oRespondents = $oRespondents;
	}
	
	function setQuestions($oQuestions) {
		$this->oQuestions = $oQuestions;
	}
	
	function fillLabels() {
		$aLabels = array(
			'respondents',
			'no_results',
		);
		foreach($aLabels as $sKey) {
			$aMarkContent['label_' . $sKey] = $this->oPi->pi_getLL('label_' . $sKey);
		}
		$this->sContent = $this->oPi->cObj->substituteMarkerArray($this->sContent, $aMarkContent, '###|###', 1);
	}
	
	function fillRespondents() {
		$aMarkContent['respondents'] = $this->oRespondents->iResultCount;
		$this->sContent = $this->oPi->cObj->substituteMarkerArray($this->sContent, $aMarkContent, '###|###', 1);
	}
	
	function fillQuestions() {
		$sListContent = $this->oPi->cObj->getSubpart($this->sContent, '###QUESTION_LIST###');
		$sEmptyListContent = $this->oPi->cObj->getSubpart($this->sContent, '###LIST_EMPTY###');

		if (!empty($this->oQuestions->questions)) {
			foreach($this->oQuestions->questions as $oItem){
				if(!in_array($oItem->iQuestionType, array(6, 8, 9))) {
					$aMarkContent['###QUESTION###'] = $this->oPi->cObj->stdWrap($oItem->sQuestion, $this->aConf['questions.']['stdWrap.']);
					/**
					 * STRATIS : separate question and subquestion for matrix
					 * -- start
					 */
					$aMarkContent['###SUBQUESTION###'] = '';
					/**
					 * STRATIS
					 * -- end
					 */
					$aSubpartContent['###ANSWERS###'] = $this->fillAnswers($oItem->aAnswers, $sListContent);
					$sSubpartContent .= $this->oPi->cObj->substituteMarkerArrayCached($sListContent, $aMarkContent, $aSubpartContent);
				} else {
					foreach($oItem->aRows as $oRow) {
						/**
						 * STRATIS : separate question and subquestion for matrix
						 * -- start
						 */
						//$aMarkContent['###QUESTION###'] = $this->oPi->cObj->stdWrap($oItem->sQuestion . ' - ' . $oRow->sRow, $this->aConf['questions.']['stdWrap.']);
						$aMarkContent['###QUESTION###'] = $this->oPi->cObj->stdWrap($oItem->sQuestion, $this->aConf['questions.']['stdWrap.']);
						$aMarkContent['###SUBQUESTION###'] = $this->oPi->cObj->stdWrap($oRow->sRow, $this->aConf['questions.']['stdWrap.']);
						/**
						 * STRATIS
						 * -- end
						 */
						$aSubpartContent['###ANSWERS###'] = $this->fillAnswers($oRow->aAnswers, $sListContent);
						$sSubpartContent .= $this->oPi->cObj->substituteMarkerArrayCached($sListContent, $aMarkContent, $aSubpartContent);
					}
				}
			}
			if(!empty($sSubpartContent)) {
				$this->sContent = $this->oPi->cObj->substituteSubpart($this->sContent,'###QUESTION_LIST###', $sSubpartContent);
				$this->sContent = $this->oPi->cObj->substituteSubpart($this->sContent,'###LIST_EMPTY###', '');
			}
		} else {
			$this->sContent = $this->oPi->cObj->substituteSubpart($this->sContent,'###QUESTION_LIST###', '');
			$this->sContent = $this->oPi->cObj->substituteSubpart($this->sContent,'###LIST_EMPTY###', $sEmptyListContent);
		}
	}
	
	function fillAnswers($aAnswers, $sTemplate) {
		$sTemplate = $this->oPi->cObj->getSubpart($sTemplate, '###ANSWERS###');
		if (is_array($aAnswers)) {
			foreach($aAnswers as $oAnswer) {
				$aMarkContent['answer'] = $this->oPi->cObj->stdWrap($oAnswer->sAnswer, $this->aConf['answers.']['stdWrap.']);
				$aMarkContent['amount'] = $oAnswer->iAmount;
				$aMarkContent['percentage'] = $oAnswer->iPercentage . '%';
				$sContent .= $this->oPi->cObj->substituteMarkerArray($sTemplate, $aMarkContent, '###|###', 1);
			}
		}
		return $sContent;
	}
	
	function done() {
		$this->fillLabels();
		$this->fillRespondents();
		$this->fillQuestions();
		return $this->sContent;
	}
}