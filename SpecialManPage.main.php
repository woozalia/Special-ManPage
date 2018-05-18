<?php
/*
  PURPOSE: MediaWiki SpecialPage to display manpages for requested items
  HISTORY:
    2018-03-12 significant updating
*/
/*
<<<<<<< HEAD
fcApp_MW::Make();	// create the application object if it hasn't already been

class SpecialManPage extends \ferreteria\mw\cSpecialPage {
//=======
// STATIC

//=======
// DYNAMIC

  protected $args;
=======
// for the URL parser:
define('KS_CHAR_PATH_SEP','/');
define('KS_CHAR_URL_ASSIGN',':');
>>>>>>> e521b2eca1d2b704d2ea780f5064661dafa6dc25
*/
// for the URL parser (2018-05-18 not sure why these are still necessary):
define('KS_CHAR_PATH_SEP','/');
define('KS_CHAR_URL_ASSIGN',':');

class SpecialManPage extends \SpecialPage {
    use \ferreteria\mw\tSpecialPage;

    
    public function __construct() {
	parent::__construct( 'ManPage' );	// this needs to match $wg* array keys in main declaration file
    }
    protected function Go() {
	global $wgUser;

	$this->setHeaders();
	if ($wgUser->isAllowed('editinterface')) {
	    $this->doAdmin();
	} else {
	    $this->doUser();
	}
    }
    /*----
      PURPOSE: do stuff that only admins are allowed to do
	For now, admins have no special powers, so just call doUser().
    */
    public function doAdmin() {
	$this->doUser();
    }
    /*----
	  PURPOSE: do only stuff that regular users are allowed to do
    */
    public function doUser() {
	global $wgOut;

	$oPathIn = \fcApp::Me()->GetKioskObject()->GetInputObject();
	
	// 2018-03-12 this will need updating
	$page = $oPathIn->GetString('page');
	$sect = $oPathIn->GetString('section');

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
	    $wgOut->AddHTML(
	      '<small>'
	      .'<b>Page</b>: '.$page.' | '
	      .'<b>Status</b>: '.$intCmdStat.'| '
	      .'<b>Lines</b>: '.$intLines.' | '
	      .'<b>Command</b>: '.$txtCmd.' | '
	      .'<b>Docs</b>: <a href="http://htyp.org/SpecialManPage">HTYP</a>'
	      .'</small><hr>'
	      );
	    if ($intLines > 0) {
		foreach($arCmdOut as $txtLine) {
		    $txtLine = str_replace('<small>',NULL,$txtLine);
		    $txtLine = str_replace('</small>',NULL,$txtLine);
		    $txtLine = str_replace('<big>',NULL,$txtLine);
		    $txtLine = str_replace('</big>',NULL,$txtLine);
		    $wgOut->AddHTML($txtLine."\n");
		}
	    } else {
		$wgOut->AddHTML("The command [$txtCmd] is not returning any content. Is <b>groff</b> installed?");
	    }
	}
    }
    public function ShowHelp() {
	global $wgOut;

	$urlPage = \fcApp::Me()->GetKioskObject()->GetPagePath();
	$out = "<b>Request Format</b>: $urlPage/page:<i>man-page-name</i>";
	$wgOut->AddHtml($out);
    }
}
