!function($){$(function(){var $window=$(window)
$('section [href^=#]').click(function(e){e.preventDefault()})
$('.bs-docs-sidenav').affix({offset:{top:function(){return $window.width()<=980?290:210},bottom:270}})
window.prettyPrint&&prettyPrint()
$('.add-on :checkbox').on('click',function(){var $this=$(this),method=$this.attr('checked')?'addClass':'removeClass'
$(this).parents('.add-on')[method]('active')})
var $win=$(window),$nav=$('.subnav'),navTop=$('.subnav').length&&$('.subnav').offset().top-40,isFixed=0
processScroll()
$nav.on('click',function(){if(!isFixed)setTimeout(function(){$win.scrollTop($win.scrollTop()-47)},10)})
$win.on('scroll',processScroll)
function processScroll(){var i,scrollTop=$win.scrollTop()
if(scrollTop>=navTop&&!isFixed){isFixed=1
$nav.addClass('subnav-fixed')}else if(scrollTop<=navTop&&isFixed){isFixed=0
$nav.removeClass('subnav-fixed')}}
if($('#gridSystem').length){$('#gridSystem').tooltip({selector:'.show-grid > div',title:function(){return $(this).width()+'px'}})}
$('.tooltip-demo').tooltip({selector:"a[rel=tooltip]"})
$('.tooltip-test').tooltip()
$('.popover-test').popover()
$("a[rel=popover]").popover().click(function(e){e.preventDefault()})
$('#fat-btn').click(function(){var btn=$(this)
btn.button('loading')
setTimeout(function(){btn.button('reset')},3000)})
$('#myCarousel').carousel()
var inputsComponent=$("#components.download input"),inputsPlugin=$("#plugins.download input"),inputsVariables=$("#variables.download input")
$('#components.download .toggle-all').on('click',function(e){e.preventDefault()
inputsComponent.attr('checked',!inputsComponent.is(':checked'))})
$('#plugins.download .toggle-all').on('click',function(e){e.preventDefault()
inputsPlugin.attr('checked',!inputsPlugin.is(':checked'))})
$('#variables.download .toggle-all').on('click',function(e){e.preventDefault()
inputsVariables.val('')})
$('.download-btn').on('click',function(){var css=$("#components.download input:checked").map(function(){return this.value}).toArray(),js=$("#plugins.download input:checked").map(function(){return this.value}).toArray(),vars={},img=['glyphicons-halflings.png','glyphicons-halflings-white.png']
$("#variables.download input").each(function(){$(this).val()&&(vars[$(this).prev().text()]=$(this).val())})
$.ajax({type:'POST',url:/\?dev/.test(window.location)?'http://localhost:3000':'http://bootstrap.herokuapp.com',dataType:'jsonpi',params:{js:js,css:css,vars:vars,img:img}})})})
$(function(){$(".newsticker-jcarousellite").jCarouselLite({vertical:true,hoverPause:true,visible:4,auto:500,speed:5000});});$.ajaxTransport('jsonpi',function(opts,originalOptions,jqXHR){var url=opts.url;return{send:function(_,completeCallback){var name='jQuery_iframe_'+jQuery.now(),iframe,form
iframe=$('<iframe>').attr('name',name).appendTo('head')
form=$('<form>').attr('method',opts.type).attr('action',url).attr('target',name)
$.each(opts.params,function(k,v){$('<input>').attr('type','hidden').attr('name',k).attr('value',typeof v=='string'?v:JSON.stringify(v)).appendTo(form)})
form.appendTo('body').submit()}}})}(window.jQuery)