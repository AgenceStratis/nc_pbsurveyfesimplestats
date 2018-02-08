<?php

$EM_CONF['nc_pbsurveyfesimplestats'] = array(
    'title' => 'Simple Frontend Statistics of Questionaire (pbsurvey) Results',
    'description' => 'Display statistics for all closed types of questions generated from results of pbsurvey',
    'category' => 'plugin',
    'version' => '1.0.0',
    'state' => 'beta',
    'clearcacheonload' => 1,
    'lockType' => '',
    'author' => 'Nicolas ZERR, Patrick Broens',
    'author_email' => 'zerr@stratis.fr,patrick@netcreators.com',
    'author_company' => 'Stratis,Netcreators',
    'constraints' => array(
        'depends' => array(
            'php' => '5.2.0-5.6.99',
            'typo3' => '6.0.0-7.6.99',
            'pbsurvey' => '',
        ),
        'conflicts' => array(),
        'suggests' => array(),
    ),
);