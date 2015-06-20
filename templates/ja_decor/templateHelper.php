<?php
/**
 * ------------------------------------------------------------------------
 * JA Decor Template
 * ------------------------------------------------------------------------
 * Copyright (C) 2004-2011 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
 * @license - Copyrighted Commercial Software
 * Author: J.O.O.M Solutions Co., Ltd
 * Websites:  http://www.joomlart.com -  http://www.joomlancers.com
 * This file may not be redistributed in whole or significant part.
 * ------------------------------------------------------------------------
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

define('JA_GRID_SIZE', '1x1');

jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');
jimport('joomla.image.image');

class DecorHelper {

	public static function loadParamsContents($item, $pdata = 'attribs'){
		$data = $item->$pdata;
		if(is_string($pdata)){
			$data = new JRegistry;
			$data->loadString($item->$pdata);
		}

		if($data instanceof JRegistry){
			return array(
				'size' => $data->get('jcontent_size', JA_GRID_SIZE),
                'jcontent_client'=>$data->get('jcontent_client', ''),
                'jcontent_location'=>$data->get('jcontent_location', ''),
                'jcontent_category'=>$data->get('jcontent_category', ''),
                'jcontent_year'=>$data->get('jcontent_year', '')
			);
		}
		
		return array(
			'size' => JA_GRID_SIZE,
            'jcontent_client'=> '',
            'jcontent_location'=>'',
            'jcontent_category'=>'',
            'jcontent_year'=>''
		);
	}
    public static function loadGridItems(){
        $tplparams = JFactory::getApplication()->getTemplate(true)->params;
        $doc = jFactory::getDocument();
        $doc->addScriptDeclaration('
            var T3JSVars = {
               baseUrl: "'.JUri::base(true).'",
               tplUrl: "'.T3_TEMPLATE_URL.'",
               finishedMsg: "'.addslashes(JText::_('TPL_JSLANG_FINISHEDMSG')).'",
               itemlg : "'.$tplparams->get('itemlg',4).'",
               itemmd : "'.$tplparams->get('itemmd',3).'",
               itemsm : "'.$tplparams->get('itemsm',2).'",
               itemsmx : "'.$tplparams->get('itemsmx',2).'",
               itemxs : "'.$tplparams->get('itemxs',1).'",
               gutter : "'.$tplparams->get('gutter',5).'"
            };
        ');
        return;
    }
    public static function getChildCategory($catid,$maxLevel){

        $db		= JFactory::getDbo();
        $query	= $db->getQuery(true);
        $query->select('id');
        $query->from('#__categories');
        $query->where('parent_id = '.$catid);
        // Filter on extension.
        $query->where('extension = '.$db->quote('com_content'));
        // Filter on the published state
        $query->where('published = 1');
        if ($maxLevel) {
            $query->where('level <= '.(int) $maxLevel);
        }
        $db->setQuery($query);
        if($db->loadResult()) return true;
        return false;

    }

    public static function getCategory($pid,$maxLevel=-1,$sub=''){
        static $res = array();
        if($maxLevel =='-1') $maxLevel='999999';
        $db		= JFactory::getDbo();
        $query	= $db->getQuery(true);

        $query->select('a.id AS id, a.title as title');
        $query->from('#__categories AS a');
        $query->join('LEFT', $db->quoteName('#__categories').' AS b ON a.lft > b.lft AND a.rgt < b.rgt');

        // Filter by the type
        $query->where('a.extension ='.$db->quote('com_content'));
        $query->where('a.parent_id = '.$pid);
        $query->where('a.published = 1');
        if ($maxLevel) {
            $query->where('a.level <= '.(int) $maxLevel);
        }
        $query->group('a.id, a.title, a.level, a.lft, a.rgt');
        $query->order('a.lft ASC');
        // Get the options.
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        foreach($rows as $row){
            $row->url = ContentHelperRoute::getCategoryRoute($row->id);
            $row->title = $sub.$row->title;
            array_push($res,$row);

            if(DecorHelper::getChildCategory($row->id,$maxLevel)){
                DecorHelper::getCategory($row->id,$maxLevel,$sub !=''?$sub.'-':'-');
            }
        }
        return $res;

    }
    
    public static function photogallery($text){
        if(preg_match_all('#<img[^>]+>#iU', $text, $imgs)){
            //remove the text
            $text = preg_replace('#<img[^>]+>#iU', '', $text);
            //collect all images
            $img_data = array();
            // parse image attributes
            foreach( $imgs[0] as $img_tag){
                $img_data[$img_tag] = JUtility::parseAttributes($img_tag);
            }
            $total = count($img_data);

            if($total > 0) :
                $text .=  '<ul class="thumbnails'.($total>1?'':' no-slide').'">';
                $j = 0;
                foreach ($img_data as $img => $attr) :
                  $text .=  '<li class="'.($j == 0 ? 'col-xs-12' : 'col-sm-6 col-xs-12').'">'
                            .($total>1?'<a title="'.$attr['alt'].'" href="'.(isset($attr['src']) ? $attr['src'] : '').'" class="thumbnail'.($j == 0 ? ' active' : '').'">':'')
                            .$img
                            .($total>1?'</a>':'').
                        '</li>';
                   $j++;
                endforeach;
                $text .= '</ul>';
            endif;

            return $text;
        } else {
            return $text;
        }
    }
    public static function loadModule($name, $style = 'raw')
	{
		jimport('joomla.application.module.helper');
		$module = JModuleHelper::getModule($name);
		$params = array('style' => $style);
		echo JModuleHelper::renderModule($module, $params);
	}

	public static function loadModules($position, $style = 'raw')
	{
		jimport('joomla.application.module.helper');
		$modules = JModuleHelper::getModules($position);
		$params = array('style' => $style);
		foreach ($modules as $module) {
			echo JModuleHelper::renderModule($module, $params);
		}
	}
}