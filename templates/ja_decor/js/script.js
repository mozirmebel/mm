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
(function($){
    // Modified Isotope methods for gutters in masonry
    $.Isotope.prototype._getMasonryGutterColumns = function() {
        var gutter = this.options.masonry && this.options.masonry.gutterWidth || 0;

        containerWidth = this.element.width();

        this.masonry.columnWidth = this.options.masonry && this.options.masonry.columnWidth ||
            // Or use the size of the first item
            this.$filteredAtoms.outerWidth(true) ||
            // If there's no items, use size of container
            containerWidth;

        this.masonry.columnWidth += gutter;

        this.masonry.cols = Math.floor((containerWidth + gutter) / this.masonry.columnWidth);
        this.masonry.cols = Math.max(this.masonry.cols, 1);
    };

    $.Isotope.prototype._masonryReset = function() {
        // Layout-specific props
        this.masonry = {};
        // FIXME shouldn't have to call this again
        this._getMasonryGutterColumns();
        var i = this.masonry.cols;
        this.masonry.colYs = [];
        while (i--) {
            this.masonry.colYs.push(0);
        }
    };

    $.Isotope.prototype._masonryResizeChanged = function() {
        var prevSegments = this.masonry.cols;
        // Update cols/rows
        this._getMasonryGutterColumns();
        // Return if updated cols/rows is not equal to previous
        return (this.masonry.cols !== prevSegments);
    };
})(jQuery);

(function ($) {

    $(document).ready(function(){
        //Checking div grid.blog
        if($('.grid.blog').length > 0){
            //isotope grid
            var $container = $('.grid.blog'),
                paginfo = $('#page-next-link'),
                nextbtn = $('#infinity-next'),
                gutter = parseInt(T3JSVars.gutter),
				iOS = parseFloat(('' + (/CPU.*OS ([0-9_]{1,5})|(CPU like).*AppleWebKit.*Mobile/i.exec(navigator.userAgent) || [0,''])[1]).replace('undefined', '3_2').replace('_', '.').replace('_', '')) || false;
                firstLoad = function(){
                    if(!(nextbtn.attr('data-fixel-infinity-end') || nextbtn.attr('data-fixel-infinity-done'))){
                        nextbtn.removeClass('hidden');
                    }
                    if($('.grid-list .item.isotope-item').length > 0){
                        $('.grid-list .item.isotope-item').each(function(i, el) {
                            // As a side note, this === el.
                            if (i % 2 === 0) {
                                $(el).addClass('even');
                            }
                            else {
                                $(el).addClass('odd');
                            }
                        });
                    }
                },
                pathobject = {
                    init: function(link){
                        var pagenext = $('#page-next-link'),
                            fromelm = false;

                        if(!link) {
                            fromelm = true;
                            link = pagenext.attr('href') || '';
                        }

                        this.path = link;

                        var match = this.path.match(/((page|limitstart|start)[=-])(\d*)(&*)/i);

                        if(match){
                            this.type = match[2].toLowerCase();
                            this.number = parseInt(match[3]);
                            this.limit = this.type == 'page' ? 1 : this.number;
                            this.number = this.type == 'page' ? this.number : 1;
                            this.init = 0;

                            var limit = parseInt(pagenext.attr('data-limit')),
                                init = parseInt(pagenext.attr('data-start'));

                            if(isNaN(limit)){
                                limit = 0;
                            }

                            if(isNaN(init)){
                                init = 0;
                            }

                            if(fromelm && this.limit != limit && (this.type == 'start' || this.type == 'limitstart')){

                                this.init = Math.max(0, init);
                                this.number = 1;
                                this.limit = limit;
                            }

                        } else {
                            this.type = 'unk';
                            this.number = 2;
                            this.path = this.path + (this.path.indexOf('?') == -1 ? '?' : '') + 'start=';
                        }

                        var urlparts = this.path.split('#');
                        if(urlparts[0].indexOf('?') == -1){
                            urlparts[0] += '?tmpl=component';
                        } else {
                            urlparts[0] += '&tmpl=component';
                        }

                        this.path = urlparts.join('#');
                    },

                    join: function(){
                        if(pathobject.type == 'unk'){
                            return pathobject.path + pathobject.number++;
                        } else{
                            return pathobject.path.replace(/((page|limitstart|start)[=-])(\d*)(&*)/i, '$1' + (pathobject.init + pathobject.limit * pathobject.number++) + '$4');
                        }
                    }
                },
                colWidth = function () {
                    var w = $container.width(),
                        columnNum = 1,
                        columnWidth = 0,
                        bloglayout = $.cookie('blog-layout');
                    if ($(window).width() > 1200) {
                        columnNum  = T3JSVars.itemlg;
                    } else if ($(window).width() >= 992) {
                        columnNum  = T3JSVars.itemmd;
                    } else if ($(window).width() >= 768) {
                        columnNum  = T3JSVars.itemsm;
                    } else if ($(window).width() >= 480) {
                        columnNum  = T3JSVars.itemsmx;
                    }else{
                        columnNum  = T3JSVars.itemxs;
                    }
					
                    if(bloglayout == '1'){
                        columnNum = 1;
                    }
                    columnWidth = Math.floor((w - gutter*(columnNum-1))/columnNum);

                    $container.find('.item').each(function() {
                        var $item = $(this),
                            $itemimg = $item.find('img'),
							columnw = $item.attr('class').match(/item-w(\d)/),
                            multiplier_w = columnw?((columnw[1] > columnNum) ? columnNum : columnw[1]):'',
                            multiplier_h = $item.attr('class').match(/item-h(\d)/),
                            width = multiplier_w ? (columnWidth*multiplier_w)+gutter*(multiplier_w-1) : columnWidth,
                            height = multiplier_h ? columnWidth*multiplier_h[1] +gutter*(multiplier_h[1]-1) : columnWidth;
						
                        if(bloglayout == '1'){
                            width = columnWidth,
                            height = $item.height()?$item.height():'300';
                            $item.css({
                                width: width,
                                height: height
                            });
                        }else{
                            $item.css({
                                width: width,
                                height: height+gutter
                            });
                            //Set item article height
                            $item.find('article').css({
                                height: height
                            });
                        }
                        //add maxwidth or maxheight
                        if($itemimg.length >0){
                            $itemimg.each(function(){
                                //Remove all style before add
                                $(this).removeAttr('style');
								if($container.hasClass('grid-list')){
									$(this).css("max-height","100%");
								}else{
                                (width/height ) > ($(this).prop('naturalWidth')/$(this).prop('naturalHeight'))?$(this).css("max-width","100%"):$(this).css("max-height","100%");
								}
                            });
                        }
						if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) || iOS) {
							// some code..
							$item.find('.item-desc').css('display','block');
						}
                    });
                    return columnWidth;
                },
                isotope = function(){
                    $container.isotope({
                        resizable: true,
                        layoutMode : 'masonry',
                        itemSelector: '.item',
                        masonry: {
                            columnWidth: colWidth(),
                            gutterWidth : gutter
                        },
                        animationEngine:'jQuery',
                        animationOptions: {
                            duration: 750,
                            easing: 'linear',
                            queue: false
                        }
                    },firstLoad());
                };

            pathobject.init();

            $container.infinitescroll({
                    navSelector  : '#page-nav',    // selector for the paged navigation
                    nextSelector : '#page-nav a',  // selector for the NEXT link (to page 2)
                    itemSelector : '.item',     // selector for all items you'll retrieve
                    loading: {
                        finished: function(){
                            $('#infscr-loading').remove();
                        },
                        finishedMsg: T3JSVars.finishedMsg,
                        img: T3JSVars.tplUrl + '/images/ajax-load.gif',
                        msgText : '',
                        speed : 'fast',
                        start: undefined
                    },
                    state: {
                        isDuringAjax: false,
                        isInvalidPage: false,
                        isDestroyed: false,
                        isDone: false, // For when it goes all the way through the archive.
                        isPaused: false,
                        currPage: 0
                    },
                    pathParse: pathobject.join,
                    path: pathobject.join,
                    binder: $(window), // used to cache the selector for the element that will be scrolling
                    extraScrollPx: 150,
                    dataType: 'html',
                    appendCallback: true,
                    bufferPx: 350,
                    debug : false,
                    errorCallback: function () {
                        nextbtn.addClass('disabled').html(T3JSVars.finishedMsg);
                    },
                    prefill: false, // When the document is smaller than the window, load data until the document is larger or links are exhausted
                    maxPage: parseInt(nextbtn.attr('data-page-total')) // to manually control maximum page (when maxPage is undefined, maximum page limitation is not work)
                },
                // call Isotope as a callback
                function( items ) {
                    $container.isotope( 'appended', $( items ) );
                    if((items.length < parseInt(paginfo.attr('data-limit') || nextbtn.attr('data-limit') || 0)) || (parseInt(paginfo.attr('data-total')) == $container.find('.item.isotope-item').length)){
                        nextbtn.addClass('disabled').html(T3JSVars.finishedMsg);
                    }
                    //update disqus if needed
                    if(typeof DISQUSWIDGETS != 'undefined'){
                        DISQUSWIDGETS.getCount();
                    }
                    isotope();
            });

            isotope();

            $(window).unbind('.infscr');

            $(window).smartresize(isotope);
            //Next click

            if(nextbtn.length){
                nextbtn.on('click', function(){
                    if(!nextbtn.hasClass('finished')){
                        $container.infinitescroll('retrieve');
                    }
                    return false;
                });
            }
            //Change layout grid to list
            var $optionSets = $('.display-blog'),
                $optionLinks = $optionSets.find('a');

            $optionLinks.click(function(){
                var $this = $(this),
                    value = $this.attr('data-option-value')?$this.attr('data-option-value'):'masonry';
                // don't proceed if already selected
                if ( $this.hasClass('active') ) {
                    return false;
                }
                $optionSets.find('.active').removeClass('active');
                $this.addClass('active');
                //Change class parent
                if($this.hasClass('project-list')){
                    $.cookie("blog-layout", '1');
                    $container.addClass('grid-list');
					if($container.find('.item.isotope-item .item-desc').length > 0){
						$container.find('.item.isotope-item .item-desc').hide();
						setTimeout(function(){
							$container.find('.item.isotope-item .item-desc').fadeIn();
						}, 800);
					}
                }else{
                    $.cookie("blog-layout", '0');
                    $container.removeClass('grid-list');
					if($container.find('.item.isotope-item .item-desc').length > 0){
						$container.find('.item.isotope-item .item-desc').removeAttr('style');
					}
                }
                //Reload grid layout
                isotope();
                $(window).smartresize(isotope);
                return false;
            });
        }

        // Thumbnail gallery
        if($('article .thumbnails').length >0 && !$('article .thumbnails').hasClass('no-slide')){
            $('article .thumbnails').magnificPopup({
                delegate: 'a',
                type: 'image',
                tLoading: 'Loading image #%curr%...',
                mainClass: 'mfp-img-mobile',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0,1]
                },
                image: {
                    tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                    titleSrc: function(item) {
                        return item.el.attr('title');
                    }
                }
            });
        }

        (function(){
            //Check div message show
            if($("#system-message").children().length){
                $("#system-message-container").show();
                $("#system-message a.close").click(function(){
                    setTimeout(function(){
                        if(!$("#system-message").children().length) $("#system-message-container").hide();

                        if($('#t3-content').length >0 && $('#t3-content').html().trim().length == 0){
                            $('#t3-content').hide();
                        }else if($('#t3-content').find('.blog-featured').length>0 && $('#t3-content').find('.blog-featured').html().trim().length == 0 && $("#system-message").children().length == 0){
                            $('#t3-content').hide();
                        }
                    }, 100);
                });
            } else {
                $("#system-message-container").hide();
            }
        })();
		//Check t3-content null
		if($('#t3-content').length >0 && $('#t3-content').html().trim().length == 0){
			$('#t3-content').hide();
		}else if($('#t3-content').find('.blog-featured').length>0 && $('#t3-content').find('.blog-featured').html().trim().length == 0 && $("#system-message").children().length == 0){
			$('#t3-content').hide();
		}
        (function(){
            //Check div message show
            if($('#myTab a').length >0){
                $('#myTab a').click(function (e) {
                    e.preventDefault();
                    $(this).tab('show');
                })
            }
			if($('.nav.nav-tabs').length > 0){
				$('.nav.nav-tabs a').click(function (e) {
                    e.preventDefault();
                    $(this).tab('show');
                })
			}
        })();
		//Check ipad 
		if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) || iOS) {
			// some code..
			$('.ja-contentslider .ja-btn-control').css('display','block');
			$('.article-img').find('a').css('display','none');
		}
        //Popup video
        if($('.video-wrapper').length>0 && $('.video-wrapper').find('iframe').length >0){
            var $containervideo =  $('.video-wrapper'),
                $videoiframe = $containervideo.find('iframe').wrap('<div id="video-contents"></div>').parent().html();
            //Remove iframe
            $containervideo.find('#video-contents').remove();
            //Event click
            $containervideo.find('a.video-play-icon').live('click',function(){
                //Created div video iframe wrap
                $('<div/>', {
                    id: 'iframe-video-wrap'
                }).appendTo('body');
                //Created button close
                $('<button type="button" class="video-close pull-right btn btn-default">&times;</button>').appendTo('#iframe-video-wrap');
				//Created mask
				$('<div class="video-container"><div>').appendTo('#iframe-video-wrap');
				$('.video-container').html($videoiframe);
				$('html').addClass('no-scroller');
                return false;
            });
			$('#iframe-video-wrap .video-close').live('click',function() {
				$('#iframe-video-wrap').remove();
				$('html').removeClass('no-scroller');
				return false;
			});
			
        }
    });
}(jQuery));