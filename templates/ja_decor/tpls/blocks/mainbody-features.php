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
?>
<?php if ($this->countModules('slideshow')) : ?>
<div id="t3-slideshow" class="t3-slideshow container<?php $this->_c('slideshow') ?>">
	<jdoc:include type="modules" name="<?php $this->_p('slideshow') ?>" style="raw" />
</div>
<?php endif ?>

<div id="t3-mainbody" class="container t3-mainbody">
	<div class="row">
		<div class="main-container">
			<?php if ($this->countModules('features-1')) : ?>
				<div class="col-xs-12 t3-home-1<?php $this->_c('features-1') ?>">
					<jdoc:include type="modules" name="<?php $this->_p('features-1') ?>" style="raw" />
				</div>
			<?php endif ?>
	
			<?php if ($this->checkSpotlight('spotlight-1', 'position-1, position-2, position-3, position-4')) : ?>
				<div class="col-xs-12 t3-sl t3-sl-1">
					<?php $this->spotlight('spotlight-1', 'position-1, position-2, position-3, position-4', array( 'style' => 'raw' )) ?>
				</div>
			<?php endif ?>
			
			<!-- MAIN CONTENT -->
			<div id="t3-content" class="t3-content col-xs-12">
				<?php if($this->hasMessage()) : ?>
				<jdoc:include type="message" />
				<?php endif ?>
				<jdoc:include type="component" />
			</div>
			<!-- //MAIN CONTENT -->
			
			<?php if ($this->countModules('features-2')) : ?>
				<div class="col-xs-12 <?php $this->_c('features-2') ?>">
					<jdoc:include type="modules" name="<?php $this->_p('features-2') ?>" style="raw" />
				</div>
			<?php endif ?>
			
			<?php if ($this->countModules('features-3')) : ?>
				<div class="col-xs-12 <?php $this->_c('features-3') ?>">
					<jdoc:include type="modules" name="<?php $this->_p('features-3') ?>" style="raw" />
				</div>
			<?php endif ?>
			
			<?php if ($this->countModules('features-4')) : ?>
				<div class="col-xs-12 t3-latest<?php $this->_c('features-4') ?>">
					<jdoc:include type="modules" name="<?php $this->_p('features-4') ?>" style="raw" />
				</div>
			<?php endif ?>
			<div id="notification"></div>
		</div>
	</div>
</div>

<?php if ($this->countModules('sticky')) : ?>
	<!-- STICKY MODULE -->
	<div class="sticky-module sticky-module-left <?php $this->_c('sticky') ?>">
		<jdoc:include type="modules" name="<?php $this->_p('sticky') ?>" style="raw" />
	</div>
	<!-- //STICKY MODULE -->
<?php endif ?>