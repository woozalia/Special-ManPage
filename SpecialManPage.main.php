<?php
/*
if (!defined('LIBMGR')) {
    require('libmgr.php');
}
clsLibMgr::Add('menus',		KFP_MW_LIB.'/menu.php',__FILE__,__LINE__);
clsLibMgr::Add('richtext',	KFP_MW_LIB.'/richtext.php',__FILE__,__LINE__);
clsLibMgr::Load('menus'		,__FILE__,__LINE__);
clsLibMgr::Load('richtext'	,__FILE__,__LINE__);
*/
clsLibrary::Load_byName('ferreteria.mw.1');

class SpecialManPage extends SpecialPageApp {
//=======
// STATIC

//=======
// DYNAMIC

  protected $args;

  public function __construct() {
	global $wgOut, $wgMessageCache;

	parent::__construct( 'ManPage' );
	//$this->includable( true );	// 2015-02-12 no longer defined
  }
  function execute( $par ) {
	global $wgUser;

	$this->setHeaders();
	$this->GetArgs($par);
	if ($wgUser->isAllowed('editinterface')) {
		$this->doAdmin();
	} else {
		$this->doUser();
	}
  }
  public function doAdmin() {
	global $wgOut;
/*
	PURPOSE: do stuff that only admins are allowed to do
	  For now, admins have no special powers, so just call doUser().
*/
      $this->doUser();
// display menu
  }
  /*----
	PURPOSE: do only stuff that regular users are allowed to do
  */
  public function doUser() {
	global $wgOut;
	$page = nzArr($this->args,'page');
	$sect = nzArr($this->args,'section');

	if (is_null($page)) {
		$this->ShowHelp();
	} else {

		$carg = $page;
		if (!is_null($sect)) {
		    $carg = $sect.' '.$carg;
		}

		$txtCmd = 'man --html=cat '.$carg;
		exec($txtCmd,$arCmdOut,$intCmdStat);
		$intLines = count($arCmdOut);
		$wgOut->AddHTML('<small>');
		$wgOut->AddHTML('<b>Page</b>: '.$page.' | ');
		$wgOut->AddHTML('<b>Status</b>: '.$intCmdStat.'| ');
		$wgOut->AddHTML('<b>Lines</b>: '.$intLines.' | ');
		$wgOut->AddHTML('<b>Command</b>: '.$txtCmd.'</small><hr>');
		foreach($arCmdOut as $txtLine) {
		    $txtLine = str_replace('<small>',NULL,$txtLine);
		    $txtLine = str_replace('</small>',NULL,$txtLine);
		    $txtLine = str_replace('<big>',NULL,$txtLine);
		    $txtLine = str_replace('</big>',NULL,$txtLine);
		    $wgOut->AddHTML($txtLine."\n");
		}
	}
  }
  public function ShowHelp() {
	global $wgOut;

	$out = '<b>Format</b>: '.$this->BaseURL().'/page:<i>man-page-name</i>';
	$wgOut->AddHtml($out);
  }
}
function nzArr($iArr=NULL,$iKey,$iDefault=NULL) {
    if (is_null($iArr)) {
	return $iDefault;
    } else {
	if (array_key_exists($iKey,$iArr)) {
	    return $iArr[$iKey];
	} else {
	    return $iDefault;
	}
    }
}
