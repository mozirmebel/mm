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
?>
<div id="ja-ss-<?php echo $module->id;?>" class="ja-ss<?php echo $params->get( 'moduleclass_sfx' );?> ja-ss-wrap <?php echo $type; ?>"  style="visibility: hidden">
	<div class="ja-ss-items">
	<?php for ($i = 0; $i < count($images); $i++): ?>
		<div class="ja-ss-item">
			<img src="<?php echo $images[$i];?>" alt="<?php echo str_replace('"', '"/', strip_tags($captionsArray[$i]) );?>"/>

			<?php 
				$icaption = trim($captionsArray[$i]);
				$ititle = trim($titles[$i])
			?>
			<?php if(strlen($icaption) || strlen($ititle)): ?>
			<div class="ja-ss-desc">
				<?php if($ititle) : ?>
				<h3><?php echo $ititle ?></h3> 
				<?php endif; ?>
				<p class="ja-ss-caption"><?php echo $icaption ?></p>
			</div>
			<?php endif; ?>
			<div class="ja-ss-mask"></div>
		</div>
	<?php endfor; ?>
	</div>
	
	<?php if ($showThumbnail == 1): ?>
	<div class="ja-ss-thumbs-wrap">
		<div class="ja-ss-thumbs"><!--
		<?php for ($i=0;$i<count($images); $i++): ?>
			--><div class="ja-ss-thumb">
				<img src="<?php echo $thumbArray[$i]?>" alt="Photo Thumbnail" />
			</div><!-- //ja-ss-thumb
		<?php endfor; ?>
		--></div>
	</div>
	<?php endif; ?>
	<?php if ($showNavigation): ?>
	<div class="ja-ss-btns clearfix">
		<?php $lang = jFactory::getLanguage(); if($lang->isRTL() == 1) { ?>
			<span class="ja-ss-prev"><i class="fa fa-angle-right"></i></span>
			<span class="ja-ss-next"><i class="fa fa-angle-left"></i></span>
		<?php } else { ?>
			<span class="ja-ss-prev"><i class="fa fa-angle-left"></i></span>
			<span class="ja-ss-next"><i class="fa fa-angle-right"></i></span>
		<?php } ?>
	</div>
	<?php endif; ?>
</div>