/**
 * @package		YJ Module Engine
 * @author		Youjoomla LLC
 * @website     Youjoomla.com 
 * @copyright	Copyright (c) 2007 - 2011 Youjoomla LLC.
 * @license   PHP files are GNU/GPL V2. CSS / JS / IMAGES are Copyrighted Commercial
 */

window.addEvent("domready", function() {

    $$('#menu-pane tr,#menu-pane td').each(function (el) {
        var get_all_labels = el.getElements('label');
        var get_label_ids = get_all_labels.map(function (label) {
            return label.getProperty("for").replace(",", "");
        });
        el.addClass(get_label_ids.join(" "));

    });


    var k2t = $('menu-pane').getElement('.paramsk2_items_holder');
    var get_spacersy = $$('#paramsj_news_source');
    var get_spacersk = $$('#paramsk2_news_source');
    var get_yj_items = $$('#yjcatfilter_rad,#paramsget_items,#joomla_select_items,#itemsList,#paramsordering,#paramsshow_frontpage');
    var get_yj_lbl = $$('#paramsyjcatfilter-lbl,#paramsget_items-lbl,#paramsitem-lbl,#paramsgetspecific-lbl,#paramsordering-lbl,#paramsshow_frontpage-lbl');


    var get_k2_items = $$('#k2catfilter_rad,#paramscategory_id,#k2_select_items,#itemsListk2,#paramsk2image_size,#paramsk2ordering');
    var get_k2_lbl = $$('#paramsk2catfilter-lbl,#paramscategory_id-lbl,#paramsk2item-lbl,#paramsk2items-lbl,#paramsk2image_size-lbl,#paramsk2ordering-lbl');

    var gotsprcy = $('paramsjoomla_items_holdersprc');
    var gotsprck = $('paramsk2_items_holdersprc');
    var gotjoomla = $('paramsjoomla_items_holderpar');
    var gotjoomlalbl = $('paramsjoomla_items_holderlbl');
    var gotk2 = $('paramsk2_items_holderpar');
    var gotk2lbl = $('paramsk2_items_holderlbl');
    gotsprcy.adopt(get_spacersy);
    gotsprck.adopt(get_spacersk);
    gotjoomla.adopt(get_yj_items);
    gotjoomlalbl.adopt(get_yj_lbl);
    gotk2.adopt(get_k2_items);
    gotk2lbl.adopt(get_k2_lbl);
    var clrtopk = new Element('div').setProperty('class', 'clrtopk');
    var clrtopj = new Element('div').setProperty('class', 'clrtopk');
    clrtopj.inject($('itemsList'), 'after');
    clrtopk.inject($('itemsListk2'), 'after');




					

var selected = $('paramsitem_source').getProperty("value");
if (selected == 1) {
    $('selectedresult').setText('Your news source is Joomla Content!');
	$('selectedresult').setStyle('color','#769904');
    		var mySlide1= new Fx.Slide('paramsk2_items_holder',{duration:1000,transition: Fx.Transitions.Pow.easeOut}).hide();
			var mySlide2= new Fx.Slide('paramsjoomla_items_holder',{duration:1000,transition: Fx.Transitions.Pow.easeOut}).show();
} else if (selected == 2){
    $('selectedresult').setText('Your news source is K2 Content!');
	$('selectedresult').setStyle('color','#1A6EAE');
    		var mySlide1= new Fx.Slide('paramsk2_items_holder',{duration:1000,transition: Fx.Transitions.Pow.easeOut}).show();
			var mySlide2= new Fx.Slide('paramsjoomla_items_holder',{duration:1000,transition: Fx.Transitions.Pow.easeOut}).hide();
}	



    $$('td.paramlist_value').each(function (el) {
        var myTag = el.getProperty('html');
        if (myTag == 0) {
            el.dispose();
        }


    });
    //k2
    if ($('itemsListk2').getProperty('html') == 0) {
        var item_in = false;
    } else {
        var k2_ibox = $('itemsListk2').getSize().size;
        $('paramsk2items-lbl').setStyle('height', k2_ibox.y);
        var item_in = true;
    }
    //////jj
    if ($('itemsList').getProperty('html') == 0) {
        var yjitem_in = false;
    } else {
        var yj_ibox = $('itemsList').getSize().size;
        $('paramsgetspecific-lbl').setStyle('height', yj_ibox.y);
        var yjitem_in = true;
    }


    $('paramsjoomla_items_holder').getParent().addClass('togh_yj');
    $('paramsk2_items_holder').getParent().addClass('togh_k2');













    
    $('paramsitem_source').addEvent('change', function(event){
		var selectedsource = this.getProperty("value");
		if (selectedsource==1) { ///joomla selected

  		var effectj = $('paramsselect_source_title').effect('background-color', {duration: 50});
		var highlight = function() {
			effectj.start('#769904').chain(function() {
				effectj.start('#fff');
			});
		}
			mySlide1.toggle();
			mySlide2.toggle();
			highlight();
			$('paramsselect_source_title').setStyle('color','#769904');
			$('k2not').setStyle('display', 'none');
		}
		
		if (selectedsource==2) { ///k2 selected

  		var effectk = $('paramsselect_source_title').effect('background-color', {duration: 50});
		var highlight = function() {
			effectk.start('#1A6EAE').chain(function() {
				effectk.start('#fff');
			});
		}
			mySlide1.toggle();
			mySlide2.toggle();
			highlight();
			$('paramsselect_source_title').setStyle('color','#1A6EAE');
			$('k2not').setStyle('display', 'block');
		}

        
    });



	
	// k2 select 
	
	
	
				
			$('paramsk2catfilter0').addEvent('click', function(){
				$('paramscategory_id').setProperty('disabled', 'disabled');
				$$('#paramscategory_id option').each(function(el) {
					el.setProperty('selected', 'selected');
				});
			})
			
			$('paramsk2catfilter1').addEvent('click', function(){
				$('paramscategory_id').removeProperty('disabled');
				$$('#paramscategory_id option').each(function(el) {
					el.removeProperty('selected');
				});

			})
			
			if ($('paramsk2catfilter0').checked) {
				$('paramscategory_id').setProperty('disabled', 'disabled');
				$$('#paramscategory_id option').each(function(el) {
					el.setProperty('selected', 'selected');
				});
			}
			
			if ($('paramsk2catfilter1').checked) {
				$('paramscategory_id').removeProperty('disabled');
			}
			
			
// joomla select

			$('paramsyjcatfilter0').addEvent('click', function(){
				$('paramsget_items').setProperty('disabled', 'disabled');
				$$('#paramsget_items option').each(function(el) {
					el.setProperty('selected', 'selected');
				});
			})
			
			$('paramsyjcatfilter1').addEvent('click', function(){
				$('paramsget_items').removeProperty('disabled');
				$$('#paramsget_items option').each(function(el) {
					el.removeProperty('selected');
				});

			})
			
			if ($('paramsyjcatfilter0').checked) {
				$('paramsget_items').setProperty('disabled', 'disabled');
				$$('#paramsget_items option').each(function(el) {
					el.setProperty('selected', 'selected');
				});
			}
			
			if ($('paramsyjcatfilter1').checked) {
				$('paramsget_items').removeProperty('disabled');
			}

});	
