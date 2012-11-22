/**
 * YJNF5 - news flash display
 * @version		2.0
 * @MooTools version 1.3
 * @Copyright Youjoomla LLC
 * @author		Constantin Boiangiu <info [at] constantinb.com>
 */
var YJNF5 = new Class({	
	Implements: [Options],
	options: {
			outerContainer: null,
			innerContainer: null,
			wheelContainer: null,
			innerElements: null,
			navLinks: {
				upLink: null,
				downLink: null
			}
	},
	
	initialize: function(options){
		this.setOptions(options);
		this.elements = $$(this.options.elements);
		this.start();	
	},	
	start: function(){
		
		this.elems = $(this.options.outerContainer).getElements(this.options.innerElements);
		this.elemsLength = this.elems.length;
		this.currentElement = 0;
		this.elems[0].addClass(this.options.highlightClass);
		
		this.fx = new Fx.Scroll(this.options.outerContainer, {
			wait: false,
			duration: 500,
			transition: Fx.Transitions.Quad.easeInOut
		});
		$(this.options.wheelContainer).addEvent('mousewheel', function(event){
			event = new Event(event);
			event.stop();
			this.startScroll(event.wheel);	

		}.bind(this));
		
		$(this.options.navLinks.upLink).addEvent('click', function(event){
			new Event(event).stop();
			this.startScroll(1);
		}.bind(this));
		
		$(this.options.navLinks.downLink).addEvent('click', function(event){
			new Event(event).stop();
			this.startScroll(-1);
		}.bind(this))		
	},
	
	startScroll: function( direction ){
		
		var dir = direction > 0 ? 1 : -1;
		var el = this.currentElement-dir;
		if( direction > 0 && el <0 ) el = 0;
		if( direction < 0 && el > this.elemsLength-1 ) el = this.currentElement;
		
		this.elems.removeClass(this.options.highlightClass);
		this.elems[el].addClass(this.options.highlightClass);
		
		this.fx.toElement(this.elems[el]);
		this.currentElement = el;
		
	}	
});
