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
?><div class="acymailing_module<?php echo $params->get('moduleclass_sfx')?>" id="acymailing_module_<?php echo $formName; ?>">
<?php
	if(!empty($mootoolsIntro)) echo '<p class="acymailing_mootoolsintro">'.$mootoolsIntro.'</p>'; ?>
	<div class="acymailing_mootoolsbutton">
		<?php
		 	$link = "rel=\"{handler: 'iframe', size: {x: ".$params->get('boxwidth',250).", y: ".$params->get('boxheight',200)."}}\" class=\"btn modal btn-primary acymailing_togglemodule\"";
		 	$href=acymailing_completeLink('sub&task=display&formid='.$module->id,true);
		?>
		<p><a <?php echo $link; ?> id="acymailing_togglemodule_<?php echo $formName; ?>" href="<?php echo $href;?>"><?php echo $mootoolsButton ?></a></p>
	</div>
</div>
