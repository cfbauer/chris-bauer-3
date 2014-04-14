/***********************************
*    Chris Bauer 3 scripts
*    Developer: tragic{media}
***********************************/

var $ = jQuery.noConflict(),

/*
 *  earlyIE: HTML5 override for < IE9
 *  arguments: (none)
 */
earlyIE = function() {
    document.createElement('header');
    document.createElement('nav');
    document.createElement('section');
    document.createElement('article');
    document.createElement('aside');
    document.createElement('footer');
    document.createElement('hgroup');
},
/*
 *  resetFields: removes form input value on mouse click, returns value on blue
 *  arguments: (none)
 */
resetFields = function() {
    var i, j, l, label, len, nodes,
    inputArray = jQuery('input[type=text], input[type=email]'),
    placeholder = 'placeholder' in document.createElement('input');

    for(i=0, len = inputArray.length; i<len; i++) {
        if(inputArray[i].getAttribute('placeholder') == null) {
            if(inputArray[i].value != '' && placeholder) {
                inputArray[i].setAttribute('placeholder', inputArray[i].value);
            } else {
                nodes = inputArray[i].parentNode.children;
                label = '';
                for(j = 0, l = nodes.length; j < l; j++) {
                    if(nodes[j].tagName == 'LABEL') label = nodes[j].innerHTML;
                    if(label.indexOf('<') != -1) label = label.slice(0, label.indexOf('<') - 1);
                }
                inputArray[i].setAttribute('placeholder', label);
                if(!placeholder) inputArray[i].defaultValue = label;
            }
        }
        inputArray[i].onfocus = function() {
            if(this.value == this.defaultValue) this.value = '';
        }
        inputArray[i].onblur = function() {
            if(this.value == '') this.value = this.defaultValue;
        }
    }
},
/*
 *  fadeInit: handles homepage fade init
 *  arguments: ()
*/
fadeInit = function() {
    var fade, constants;

    constants = {
        container:'#banner #block-views-homepage-slider-block-1',
        item:'.views-row',
        intervalSpeed:9000,
        opacitySpeed:1500,
        pageDots:false
    };
    fade = new tFade(constants);
}

/*
 *  scrollInit: doomScroll init function
 *  arguments: (none)

scrollInit = function() {
    var constants, scroll;
    /* even homepage blocks*/
    /* scroller */ /*
        constants = {
            container:'#banner .view-id-homepage_slider',
            itemClass:'.views-row',
            btnLeft:'.prev',
            btnRight:'.next',
            btns:true, 
            pageDots:true,
            interval:true,
            intervalSpeed:9900,
            slideNumber:1,
            numberShown:1,
            speed:450,
            swipe:false
            /* responsive:true,
            responsiveEl:'.views-field-field-slider-image img' */ /*
        };
        scroll = new dScroll(constants);

};
*/
$(document).ready(function() {
    /* default */
    resetFields();

    if($('body.front').length) docFade();
});