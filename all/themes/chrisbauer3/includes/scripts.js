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
};

$(document).ready(function() {

    $('.view-homepage-slider .view-content').slick({
          dots: false,
          arrows:false,
          infinite: true,
          speed: 1800,
          autoplaySpeed:13000,
          fade: true,
          slide: '.views-row',
          cssEase: 'linear',
          autoplay:true
    });

    $('#block-system-main-menu').slimmenu(
        {
            resizeWidth: '800',
            collapserTitle: '',
            animSpeed: 'fast',
            easingEffect: null,
            indentChildren: false,
            childrenIndenter: '&nbsp;'
        });

    /* default */
    resetFields();
});