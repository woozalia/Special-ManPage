<?php
/*
 NAME: SpecialManPage
 PURPOSE: Special page for displaying manpages
 REQUIRES:
  man
  groff
 AUTHOR: Woozle (Nick) Staddon
 VERSION:
	2010-09-06 0.0 (Wzl) Started writing
        2012-01-17 1.0 (Wzl) Tidying up for MW 1.18
	2013-07-21 1.1 (Wzl) Fixing for MW 1.20 - split into 3 files
	2017-12-21 1.11 (Wzl) Removed superfluous loading of 'ferreteria.mw.1'
	  Still generates an error in line 369 of /var/www/php/ferreteria/mw/app-specialpage.php:
	    "2017-12-03 Does anything still use this?"
	    ...but it doesn't work anyway because man no longer has the same HTML output.
*/

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'ManPage',						// for [[Special:Version]]
	'author' =>'[[htwiki:Woozle|Woozle]]', 				// for [[Special:Version]]
	'url' => 'http://htyp.org/SpecialManPage', 
	'description' => 'special page for displaying manpages',	// for [[Special:Version]]
	'descriptionmsg' => 'specialmanpage-desc',
	'version'  => '1.11 2017-12-21',
       );
$wgAutoloadClasses[ 'SpecialManPage' ] = __DIR__ . '/SpecialManPage.main.php'; # Location of the extension's main class
$wgExtensionMessagesFiles['ManPage'] = dirname( __FILE__ ) . '/SpecialManPage.i18n.php';
//$wgExtensionMessagesFiles[ 'ManPage' ] = __DIR__ . '/SpecialManPage.alias.php';	// not used yet
$wgSpecialPageGroups[ 'ManPage' ] = 'reference';	// for [[Special:SpecialPages]]
// value of "specialpages-group-reference" in i18n file will display as the section title
$wgSpecialPages[ 'ManPage' ] = 'SpecialManPage';	// this specifies the class MW will try to load

/*
if (!defined('LIBMGR')) {
    require('libmgr.php');
}
clsLibMgr::Add('menus',		KFP_MW_LIB.'/menu.php',__FILE__,__LINE__);
clsLibMgr::Add('richtext',	KFP_MW_LIB.'/richtext.php',__FILE__,__LINE__);
clsLibMgr::Load('menus'		,__FILE__,__LINE__);
clsLibMgr::Load('richtext'	,__FILE__,__LINE__);
*/
