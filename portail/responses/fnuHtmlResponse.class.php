<?php
/**
* @package   havefnubb
* @subpackage havefnubb
* @author    FoxMaSk
* @copyright 2008 FoxMaSk
* @link      http://havefnubb.org
* @licence  http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public Licence, see LICENCE file
*/

require_once (JELIX_LIB_CORE_PATH.'response/jResponseHtml.class.php');

class fnuHtmlResponse extends jResponseHtml {

	public $bodyTpl = 'havefnubb~main';

	function __construct() {
		parent::__construct();
	}

	protected function doAfterActions() {
		global $gJConfig;

		if ($gJConfig->havefnubb['installed'] == 0) $this->bodyTpl = 'havefnubb~main_not_installed';

		$language = preg_split('/_/',$gJConfig->locale);

		/* Dublin Core Meta and Content */
		$this->addHeadContent('<meta name="description" lang="'.$language[0].'" content="'.$gJConfig->havefnubb['description'].'" />');

		$this->addHeadContent('<link rel="schema.dc" href="http://purl.org/dc/elements/1.1/"/>');
		$this->addHeadContent('<meta name="dc.title" lang="'.$language[0].'" content="'.$gJConfig->havefnubb['title'].'" />');
		$this->addHeadContent('<meta name="dc.description" lang="'.$language[0].'" content="'.$gJConfig->havefnubb['description'].'" />');
		$this->addHeadContent('<meta name="dc.language" content="'.$language[0].'" />');
		$this->addHeadContent('<meta name="dc.type" content="text" />');
		$this->addHeadContent('<meta name="dc.format" content="text/html" />');
		$this->addHeadContent('<link rel="section" href="'.htmlentities(jurl::get('havefnubb~default:index')).'" title="'.jLocale::get('havefnubb~main.community').'" />');
		$this->addHeadContent('<link rel="section" href="'.htmlentities(jurl::get('hfnusearch~default:index')).'" title="'.jLocale::get('havefnubb~main.search').'" />');

		/* Dublin Core */

		$title = $gJConfig->havefnubb['title'];
		$description = $gJConfig->havefnubb['description'];

		if ($this->title)
			$this->title = $title . ' - ' . $this->title;
		else
			$this->title = $title;

		if (empty($GLOBALS['gJCoord']->request->params)) {
			$this->body->assign('home',0);
			$this->body->assign('selectedMenuItem','members');
			$this->body->assign('currentIdForum',0);
		}
		else {
			list($ctrl,$method) = preg_split('/:/',$GLOBALS['gJCoord']->request->params['action']);

			switch ($GLOBALS['gJCoord']->request->params['module']) {
				case 'havefnubb' :
					switch ($ctrl) {
						case 'members':
							if ($method != 'mail') {
								$this->body->assign('home',0);
								$this->body->assign('selectedMenuItem','members');
								$this->body->assign('currentIdForum',0);
							}
							else  {
								$this->body->assign('home',0);
								$this->body->assign('selectedMenuItem','users');
								$this->body->assign('currentIdForum',0);
							}
							break;
						case 'posts':

							$this->body->assign('home',0);
							$this->body->assign('selectedMenuItem','home');
							$toolbarConfig  = new jIniFileModifier(JELIX_APP_CONFIG_PATH . 'wikitoolbar.ini.php');
/*							$this->addJSLink($gJConfig->urlengine['basePath'].'hfnu/'.$toolbarConfig->getValue('default.engine.file','wikitoolbar'));
							$this->addJSLink($gJConfig->urlengine['basePath'].'hfnu/'.$toolbarConfig->getValue('default.config.path','wikitoolbar') .$gJConfig->locale . '.js');
							$this->addCssLink($gJConfig->urlengine['basePath'].'hfnu/'.$toolbarConfig->getValue('default.skin','wikitoolbar'));
							$this->addCssLink($gJConfig->urlengine['basePath'].'hfnu/'.$toolbarConfig->getValue('default.config.path','wikitoolbar') .'style.css');
*/
							if ($method == 'view' or $method == 'lists' )
								$this->body->assign('currentIdForum',$GLOBALS['gJCoord']->request->params['id_forum']);
							else
								$this->body->assign('currentIdForum',0);
							break;
						case 'forum':
						case 'cat':
							$this->body->assign('home',0);
							$this->body->assign('selectedMenuItem','home');
							$this->body->assign('currentIdForum',0);
							break;
						default:
							$this->body->assign('home',1);
							$this->body->assign('selectedMenuItem','home');
							$this->body->assign('currentIdForum',0);
							break;
					}
					break;
				case 'hfnusearch' :
						$this->body->assign('home',0);
						$this->body->assign('selectedMenuItem','search');
						$this->body->assign('currentIdForum',0);
						break;
				case 'jcommunity':
				case 'jmessenger':
						$this->body->assign('home',0);
						$this->body->assign('selectedMenuItem','users');
						$this->body->assign('currentIdForum',0);
						break;
				case 'downloads':
						$this->body->assign('home',0);
						$this->body->assign('selectedMenuItem','downloads');
						$this->body->assign('currentIdForum',0);
						break;
				default:
						$this->body->assign('home',1);
						$this->body->assign('selectedMenuItem','home');
						$this->body->assign('currentIdForum',0);
						break;
			}
		}

		$this->body->assignIfNone('MAIN','');
		$this->body->assignIfNone('TITLE',$title);
		$this->body->assignIfNone('DESC',$description);
		$this->body->assignIfNone('BOARD_TITLE',$title);
	}
}
