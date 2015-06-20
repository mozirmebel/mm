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

defined('_JEXEC') or die;

/**
 * Mainbody 2 columns: content - sidebar
 */
?>
<?php if ($this->countModules('slideshow')) : ?>
<div id="t3-slideshow" class="t3-slideshow container<?php $this->_c('slideshow') ?>">
	<jdoc:include type="modules" name="<?php $this->_p('slideshow') ?>" style="raw" />
</div>
<?php endif ?>
<div id="t3-mainbody" class="container t3-mainbody">
	<div class="row">
		<div class="main-container">
			<div class="clearfix">
				<!-- MAIN CONTENT -->
				<div id="t3-content" class="t3-content col-xs-12 col-sm-12  col-md-9">
					<?php if($this->hasMessage()) : ?>
					<jdoc:include type="message" />
					<?php endif ?>
					<jdoc:include type="component" />
				</div>
				<!-- //MAIN CONTENT -->
		
				<!-- SIDEBAR RIGHT -->
				<div class="t3-sidebar t3-sidebar-right col-xs-12 col-sm-4 col-md-3 <?php $this->_c($vars['sidebar']) ?>">
					<jdoc:include type="modules" name="<?php $this->_p($vars['sidebar']) ?>" style="T3Xhtml" />
				</div>
				<!-- //SIDEBAR RIGHT -->
			</div>
			 <?php $this->loadBlock('spotlight-1') ?>

			  <?php $this->loadBlock('spotlight-2') ?>
			  
			  <?php $this->loadBlock('navhelper') ?>
		</div>
	</div>
</div> 
