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

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers');
JHtml::addIncludePath(T3_PATH.'/html/com_content');
JHtml::addIncludePath(dirname(dirname(__FILE__)));
JHtml::_('behavior.caption');
//register the helper class
JLoader::register('DecorHelper', T3_TEMPLATE_PATH . '/templateHelper.php');
//template params
$tplparams = JFactory::getApplication()->getTemplate(true)->params;
//Load grid items
DecorHelper::loadGridItems();
$catparent = '';

if($this->maxLevel !=0){
    $catparent = DecorHelper::getCategory($this->category->id,$this->maxLevel);
}

$bloglayout = isset($_COOKIE['blog-layout'])?$_COOKIE['blog-layout'] : '0';
?>

<div class="ja-masonry-wrap">
<!-- Add toolbar change grid -->
<div class="toobar-grid">
    <h3><?php echo JText::_('TPL_FILTER_PROJECT');?></h3>
    <!-- Filter by category -->
    <?php if($catparent) : ?>
    <div class="dropdown">
        <button class="btn dropdown-toggle" type="button" id="dropdownMenu" data-toggle="dropdown">
            <?php echo JText::_('TPL_ALL_PROJECT');?>
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
            <?php
            foreach($catparent as $cat){ ?>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo $cat->url;?>"><?php echo $cat->title;?></a></li>
            <?php }?>
        </ul>
    </div>
    <?php endif;?>
    <!-- Don't change class-->
    <div class="display-blog">
      	<a class="project-grid<?php echo $bloglayout!=1?' active':''?>" href="javascript:void(0)" data-option-value="masonry"><span><i class="fa fa-th-large"></i></span></a>
        <a class="project-list<?php echo $bloglayout==1?' active':''?>" href="javascript:void(0)" data-option-value="straightDown"><i class="fa fa fa-th-list"></i></a>
    </div>
</div>
<div class="grid blog<?php echo $this->pageclass_sfx;?><?php echo $bloglayout==1?' grid-list':'';?>" id="grid">
	<?php if ($this->params->get('show_page_heading', 1)) : ?>
	<div class="page-header clearfix">
		<h1 class="page-title"> <?php echo $this->escape($this->params->get('page_heading')); ?> </h1>
	</div>
	<?php endif; ?>
	<?php if ($this->params->get('show_category_title', 1) or $this->params->get('page_subheading')) : ?>
  	<div class="page-subheader clearfix">
  		<h2 class="page-subtitle"><?php echo $this->escape($this->params->get('page_subheading')); ?>
			<?php if ($this->params->get('show_category_title')) : ?>
			<small class="subheading-category"><?php echo $this->category->title;?></small>
			<?php endif; ?>
  		</h2>
	</div>
	<?php endif; ?>
	
	<?php if ($this->params->get('show_tags', 1) && !empty($this->category->tags->itemTags)) :
        $this->category->tagLayout = new JLayoutFile('joomla.content.tags');
        echo $this->category->tagLayout->render($this->category->tags->itemTags);
    endif; ?>
	
	<?php if ($this->params->get('show_description', 1) || $this->params->def('show_description_image', 1)) : ?>
	<div class="category-desc clearfix">
		<?php if ($this->params->get('show_description_image') && $this->category->getParams()->get('image')) : ?>
			<img src="<?php echo $this->category->getParams()->get('image'); ?>"/>
		<?php endif; ?>
		<?php if ($this->params->get('show_description') && $this->category->description) : ?>
			<?php echo JHtml::_('content.prepare', $this->category->description, '', 'com_content.category'); ?>
		<?php endif; ?>
	</div>
	<?php endif; ?>

	<?php if (empty($this->lead_items) && empty($this->link_items) && empty($this->intro_items)) :
        if ($this->params->get('show_no_articles', 1)) : ?>
			<p><?php echo JText::_('COM_CONTENT_NO_ARTICLES'); ?></p>
		<?php endif; ?>
	<?php endif; ?>

	<?php $leadingcount = 0; ?>
	<?php if (!empty($this->lead_items)) : ?>
		<?php foreach ($this->lead_items as &$item) : ?>
			<?php
                $this->item = &$item;
				echo $this->loadTemplate('item');
			?>
		<?php $leadingcount++; ?>
		<?php endforeach; ?>
	<?php endif; ?>

	<?php
		$introcount = (count($this->intro_items));
		$counter = 0;
	?>

	<?php if (!empty($this->intro_items)) : ?>
	<?php foreach ($this->intro_items as $key => &$item) : ?>
		<?php $rowcount = ((int) $counter % (int) $this->columns) + 1; ?>
			    <?php
					$this->item = &$item;
					echo $this->loadTemplate('item');
				?>
				<?php $counter++; ?>

	<?php endforeach; ?>
	<?php endif; ?>


    <?php if ($this->params->get('show_pagination') == 3 && $this->pagination->get('pages.total') > 1) : ?>
        <nav id="page-nav" class="pagination">
            <?php
            $urlparams = '';
            if (!empty($this->pagination->_additionalUrlParams)){
                foreach ($this->pagination->_additionalUrlParams as $key => $value) {
                    $urlparams .= '&' . $key . '=' . $value;
                }
            }

            $next = $this->pagination->limitstart + $this->pagination->limit;
            $nextlink = JRoute::_($urlparams . '&' . $this->pagination->prefix . 'limitstart=' . $next);
            ?>
            <a id="page-next-link" href="<?php echo $nextlink ?>" data-limit="<?php echo $this->pagination->limit; ?>" data-start="<?php echo $this->pagination->limitstart ?>" data-page-total="<?php echo ceil($this->pagination->total / $this->pagination->limit);?>" data-total="<?php echo $this->pagination->total;?>"></a>
        </nav>
    <?php endif; ?>
</div>
<?php
//Override pagination
if ($this->params->def('show_pagination', 2) == 1  || ($this->params->get('show_pagination') == 2 && $this->pagination->get('pages.total') > 1) || $this->params->def('show_pagination', 2) == 3) : ?>
    <?php 
	if ($this->params->def('show_pagination', 2) == 3) : ?>
		<?php if($this->pagination->get('pages.total') > 1) :?>
				<div id="infinity-next" class="btn btn-primary btn-block hidden"><?php echo JText::_('TPL_INFINITY_NEXT')?></div>
		<?php else:?>
		<div id="infinity-next" class="btn btn-primary btn-block disabled"><?php echo JText::_('TPL_JSLANG_FINISHEDMSG');?></div>
<?php endif;?>		
 <?php else : ?>
        <div class="pagination">
            <?php if ($this->params->def('show_pagination_results', 1)) : ?>
                <p class="counter pull-right">
                    <?php echo $this->pagination->getPagesCounter(); ?>
                </p>
            <?php  endif; ?>
            <?php echo $this->pagination->getPagesLinks(); ?>
        </div>
    <?php endif; ?>
<?php endif; ?>
</div>