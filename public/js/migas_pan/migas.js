$('.breadcrumbs li a').each(function(){
    var breadWidth = $(this).parent().width();
    if($(this).parent('li').hasClass('active') || $(this).parent('li').hasClass('first')){
    } else {

        $(this).css('width', 75 + 'px');

        $(this).mouseover(function(){
            $(this).css('width', breadWidth + 'px');
        });

        $(this).mouseout(function(){
            $(this).css('width', 75 + 'px');
        });
    }

        
});