<?php
/* @package Joomla
 * @copyright Copyright (C) Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @extension Phoca Extension
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

use Joomla\CMS\HTML\HTMLHelper;

class PhocaEmailRenderAdminView
{

	public $view 	= '';
	public $option	= '';
	public $vC		= false;

	public function __construct(){

		$app			= JFactory::getApplication();
		$version 		= new \Joomla\CMS\Version();
		$this->vC 		= $version->isCompatible('4.0.0-alpha');
		$this->view		= $app->input->get('view');
		$this->option	= $app->input->get('option');

		switch($this->view) {

			case 'phocaemailwrite':
			case 'phocaemailsendnewsletter':
			case 'phocaemailnewstetter':
            case 'phocaemailsubscriber':
            case 'phocaemaillist':
            default:
				JHtml::_('behavior.formvalidator');
				JHtml::_('behavior.keepalive');

				if (!$this->vC) {
					JHtml::_('behavior.tooltip');
					JHtml::_('formbehavior.chosen', 'select');

				}

			break;
		}

		// CP View
		if ($this->view ==  null) {
			JHtml::stylesheet( 'media/'.$this->option.'/duoton/joomla-fonts.css' );
		}
	}

	public function startCp() {

		$o = '';
		if ($this->vC) {

		} else {
			$o .= '<div id="j-sidebar-container" class="span2 col-md-2">' . JHtmlSidebar::render() . '</div>'."\n";
			$o .= '<div id="j-main-container" class="span10 col-md-10">'."\n";
		}

		return $o;
	}

	public function endCp() {

		$o = '';
		if ($this->vC) {

		} else {
			$o .= '</div></div>';
		}

		return $o;
	}

	public function startForm($option, $view, $itemId, $id = 'adminForm', $name = 'adminForm') {
		$o = '<div id="'.$view.'">'."\n";
		$o .= '<form action="'.JRoute::_('index.php?option='.$option . '&layout=edit&id='.(int) $itemId).'" method="post" name="'.$name.'" id="'.$id.'" class="form-validate">'."\n";
		$o .= '<div class="row-fluid">'."\n";

		return $o;
	}

	public function endForm() {
		$o = '</div>'."\n";
		$o .= '</form>'."\n";
		$o .= '</div>'."\n";

		return $o;
	}

	public function formInputs() {

		$o = '<input type="hidden" name="task" value="" />'. "\n";
		$o .= JHtml::_('form.token'). "\n";

		return $o;
	}


	public function group($form, $formArray, $clear = 0) {

		$o = '';
		if (!empty($formArray)) {
			if ($clear == 1) {
				foreach ($formArray as $value) {
					$o .= '<div>'. $form->getLabel($value) . '</div>'."\n"
					. '<div class="clearfix"></div>'. "\n"
					. '<div>' . $form->getInput($value). '</div>'."\n";
				}
			} else {
				foreach ($formArray as $value) {
					$o .= '<div class="control-group">'."\n"
					. '<div class="control-label">'. $form->getLabel($value) . '</div>'."\n"
					. '<div class="controls">' . $form->getInput($value). '</div>'."\n"
					. '</div>' . "\n";
				}
			}
		}
		return $o;
	}

	public function item($form, $item, $suffix = '') {

		$value = $o = '';
		if ($suffix != '') {
			$value = $suffix;
		} else {
			$value = $form->getInput($item);
		}
		$o .= '<div class="control-group">'."\n";
		$o .= '<div class="control-label">'. $form->getLabel($item) . '</div>'."\n"
		. '<div class="controls">' . $value.'</div>'."\n"
		. '</div>' . "\n";
		return $o;
	}

	public function quickIconButton( $link, $text = '', $icon = '', $color = '') {

		$o = '<div class="ph-cp-item">';
		$o .= ' <div class="ph-cp-item-icon">';
		$o .= '  <a class="ph-cp-item-icon-link" href="'.$link.'"><span style="background-color: '.$color.'20;"><i style="color: '.$color.';" class="phi '.$icon.' ph-cp-item-icon-link-large"></i></span></a>';
		$o .= ' </div>';

		$o .= ' <div class="ph-cp-item-title"><a class="ph-cp-item-title-link" href="'.$link.'"><span>'.$text.'</span></a></div>';
		$o .= '</div>';

		return $o;
	}



	public function getLinks($internalLinksOnly = 0) {
		$app	= JFactory::getApplication();
		$option = $app->input->get('option');
		$oT		= strtoupper($option);

		$links =  array();
		switch ($option) {

			case 'com_phocaemail':
				$links[]	= array('Phoca Email site', 'https://www.phoca.cz/phocaemail');
				$links[]	= array('Phoca Email documentation site', 'https://www.phoca.cz/documentation/category/60-phoca-email-component');
				$links[]	= array('Phoca Email download site', 'https://www.phoca.cz/download/category/47-phoca-email-component');
			break;

		}

		$links[]	= array('Phoca News', 'https://www.phoca.cz/news');
		$links[]	= array('Phoca Forum', 'https://www.phoca.cz/forum');

		if ($internalLinksOnly == 1) {
		    return $links;
        }

		$components 	= array();
		$components[]	= array('Phoca Gallery','phocagallery', 'pg');
		$components[]	= array('Phoca Guestbook','phocaguestbook', 'pgb');
		$components[]	= array('Phoca Download','phocadownload', 'pd');
		$components[]	= array('Phoca Documentation','phocadocumentation', 'pdc');
		$components[]	= array('Phoca Favicon','phocafavicon', 'pfv');
		$components[]	= array('Phoca SEF','phocasef', 'psef');
		$components[]	= array('Phoca PDF','phocapdf', 'ppdf');
		$components[]	= array('Phoca Restaurant Menu','phocamenu', 'prm');
		$components[]	= array('Phoca Maps','phocamaps', 'pm');
		$components[]	= array('Phoca Font','phocafont', 'pf');
		$components[]	= array('Phoca Email','phocaemail', 'pe');
		$components[]	= array('Phoca Install','phocainstall', 'pi');
		$components[]	= array('Phoca Template','phocatemplate', 'pt');
		$components[]	= array('Phoca Panorama','phocapanorama', 'pp');
		$components[]	= array('Phoca Commander','phocacommander', 'pcm');
		$components[]	= array('Phoca Photo','phocaphoto', 'ph');
		$components[]	= array('Phoca Cart','phocacart', 'pc');

		$banners	= array();
		$banners[]	= array('Phoca Restaurant Menu','phocamenu', 'prm');

		$o = '';
		$o .= '<p>&nbsp;</p>';
		$o .= '<h4 style="margin-bottom:5px;">'.JText::_($oT.'_USEFUL_LINKS'). '</h4>';
		$o .= '<ul>';
		foreach ($links as $k => $v) {
			$o .= '<li><a style="text-decoration:underline" href="'.$v[1].'" target="_blank">'.$v[0].'</a></li>';
		}
		$o .= '</ul>';

		$o .= '<div>';
		$o .= '<p>&nbsp;</p>';
		$o .= '<h4 style="margin-bottom:5px;">'.JText::_($oT.'_USEFUL_TIPS'). '</h4>';

		$m = mt_rand(0, 10);
		if ((int)$m > 0) {
			$o .= '<div>';
			$num = range(0,(count($components) - 1 ));
			shuffle($num);
			for ($i = 0; $i<3; $i++) {
				$numO = $num[$i];
				$o .= '<div style="float:left;width:33%;margin:0 auto;">';
				$o .= '<div><a style="text-decoration:underline;" href="https://www.phoca.cz/'.$components[$numO][1].'" target="_blank">'.JHTML::_('image',  'media/'.$option.'/images/administrator/icon-box-'.$components[$numO][2].'.png', ''). '</a></div>';
				$o .= '<div style="margin-top:-10px;"><small><a style="text-decoration:underline;" href="https://www.phoca.cz/'.$components[$numO][1].'" target="_blank">'.$components[$numO][0].'</a></small></div>';
				$o .= '</div>';
			}
			$o .= '<div style="clear:both"></div>';
			$o .= '</div>';
		} else {
			$num = range(0,(count($banners) - 1 ));
			shuffle($num);
			$numO = $num[0];
			$o .= '<div><a href="https://www.phoca.cz/'.$banners[$numO][1].'" target="_blank">'.JHTML::_('image',  'media/'.$option.'/images/administrator/b-'.$banners[$numO][2].'.png', ''). '</a></div>';

		}

		$o .= '<p>&nbsp;</p>';
		$o .= '<h4 style="margin-bottom:5px;">'.JText::_($oT.'_PLEASE_READ'). '</h4>';
		$o .= '<div><a style="text-decoration:underline" href="https://www.phoca.cz/phoca-needs-your-help/" target="_blank">'.JText::_($oT.'_PHOCA_NEEDS_YOUR_HELP'). '</a></div>';

		$o .= '</div>';
		return $o;
	}

	// TABS

	public function navigation($tabs) {

		if ($this->vC) {
			return '';
		}

		$o = '<ul class="nav nav-tabs">';
		$i = 0;
		foreach($tabs as $k => $v) {
			$cA = 0;
			if ($i == 0) {
				$cA = 'class="active"';
			}
			$o .= '<li '.$cA.'><a href="#'.$k.'" data-toggle="tab">'. $v.'</a></li>'."\n";
			$i++;
		}
		$o .= '</ul>';
		return $o;
	}


	public function startTabs($active = 'general') {
		if ($this->vC) {
			return HTMLHelper::_('uitab.startTabSet', 'myTab', array('active' => $active));
		} else {
			return '<div class="tab-content">'. "\n";
		}
	}

	public function endTabs() {
		if ($this->vC) {
			return HTMLHelper::_('uitab.endTabSet');
		} else {
			return '</div>';
		}
	}

	public function startTab($id, $name, $active = '') {
		if ($this->vC) {
			return HTMLHelper::_('uitab.addTab', 'myTab', $id, $name);
		} else {
			return '<div class="tab-pane '.$active.'" id="'.$id.'">'."\n";
		}
	}

	public function endTab() {
		if ($this->vC) {
			return HTMLHelper::_('uitab.endTab');
		} else {
			return '</div>';
		}
	}


}
?>
