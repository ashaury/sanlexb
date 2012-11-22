/**
 * YJNF5 - news flash display
 * @version		1.0.0
 * @MooTools version 1.1
 * @Copyright Youjoomla LLC
 * @author		Constantin Boiangiu <info [at] constantinb.com>
 */
 
var YJNF5 = new Class({
	initialize: function(options) {
		this.options = Object.extend({
			outerContainer: null,
			innerContainer: null,
			innerElements: null,
			navLinks: {
				upLink: null,
				downLink: null
			},
			highlightClass: null
		}, options || {});
		
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
		
		$(this.options.outerContainer).addEvent('mousewheel', function(event){
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
})

/*
var YJNF5=new Class({initialize:function(A){this.options=Object.extend({outerContainer:null,innerContainer:null,innerElements:null,navLinks:{upLink:null,downLink:null},highlightClass:null},A||{});this.start()},start:function(){this.elems=$(this.options.outerContainer).getElements(this.options.innerElements);this.elemsLength=this.elems.length;this.currentElement=0;this.elems[0].addClass(this.options.highlightClass);this.fx=new Fx.Scroll(this.options.outerContainer,{wait:false,duration:500,transition:Fx.Transitions.Quad.easeInOut});$(this.options.outerContainer).addEvent("mousewheel",function(A){A=new Event(A);A.stop();this.startScroll(A.wheel)}.bind(this));$(this.options.navLinks.upLink).addEvent("click",function(A){new Event(A).stop();this.startScroll(1)}.bind(this));$(this.options.navLinks.downLink).addEvent("click",function(A){new Event(A).stop();this.startScroll(-1)}.bind(this))},startScroll:function(C){var A=C>0?1:-1;var B=this.currentElement-A;if(C>0&&B<0){B=0}if(C<0&&B>this.elemsLength-1){B=this.currentElement}this.elems.removeClass(this.options.highlightClass);this.elems[B].addClass(this.options.highlightClass);this.fx.toElement(this.elems[B]);this.currentElement=B}});
*/