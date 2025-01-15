<?php

$GLOBALS['TL_DCA']['tl_content']['fields']['hb_rechtstext_type'] = [
	'exclude' => true,
	'inputType' => 'select',
	'options' => [
		'12766C46A8A',
		'12766C53647',
		'12766C58F26',
		'12766C5E204',
		'1293C20B491',
		'134CBB4D101',
	],
	'reference' => &$GLOBALS['TL_LANG']['tl_content']['hb_rechtstext_type_ref'],
	'eval' => ['tl_class' => 'w50', 'includeBlankOption' => true, 'mandatory' => true],
	'sql' => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['hb_rechtstext_language'] = [
	'exclude' => true,
	'inputType' => 'select',
	'options' => [
		'de',
		'en',
		'fr',
		'it',
		'es',
		'nl',
		'pl',
		'ar',
	],
	'reference' => &$GLOBALS['TL_LANG']['tl_content']['hb_rechtstext_language_ref'],
	'eval' => ['tl_class' => 'w50', 'includeBlankOption' => true, 'mandatory' => true],
	'sql' => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['hb_rechtstext_access_token'] = [
	'exclude' => true,
	'inputType' => 'text',
	'eval' => ['tl_class' => 'w50', 'mandatory' => true],
	'sql' => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['palettes']['hb_rechtstext'] = '{type_legend},type,headline;{hb_rechtstext_legend},hb_rechtstext_type,hb_rechtstext_language,hb_rechtstext_access_token;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';
