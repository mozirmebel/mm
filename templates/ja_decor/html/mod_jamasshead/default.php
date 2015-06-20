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

defined('_JEXEC') or die('Restricted access');
$input = JFactory::getApplication()->input;
$active = JFactory::getApplication()->getMenu()->getActive();
if ($input->getCmd ('option') == 'com_content' && $input->getVar ('view') == 'article' && isset($active->query['layout'])) :	
$article = JTable::getInstance("content");
$article->load($input->getCmd ('id'));
?>
	
<div class="jamasshead<?php echo $params->get('moduleclass_sfx','')?>">
	<h3 class="jamasshead-title"><?php  echo  $article->get("title"); ?></h3>
</div>		

<?php elseif  ($input->getCmd ('option') == 'com_contact' && $input->getVar ('view') == 'contact') :	

$model = JModelLegacy::getInstance('Contact', 'ContactModel', array('ignore_request' => true));
$appParams = JFactory::getApplication()->getParams();
$model->setState('params',$appParams);
$model->setState('contact.id', $input->getCmd ('id'));
$items = $model->getItem();
?>
	
<div class="jamasshead<?php echo $params->get('moduleclass_sfx','')?>" <?php if(isset($masshead['params']['background'])): ?> style="background-image: url(<?php echo $masshead['params']['background'] ?>)" <?php endif; ?>>
	<h3 class="jamasshead-title"><?php  echo  $items->name; ?></h3>
</div>		

<?php else: ?>

<div class="jamasshead<?php echo $params->get('moduleclass_sfx','')?>" <?php if(isset($masshead['params']['background'])): ?> style="background-image: url(<?php echo $masshead['params']['background'] ?>)" <?php endif; ?>>
	<h3 class="jamasshead-title"><?php echo $masshead['title']; ?></h3>
	<div class="jamasshead-description"><?php echo $masshead['description']; ?></div>
</div>	

<?php endif; ?>

