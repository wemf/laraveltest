var confirm= (function (){ 
    var a;
    var attributes = {};       
        attributes.title='';
        attributes.segment='';
        attributes.code;
    return{ 
        setTitle:function(title2){            
            attributes.title=title2;
            $('#confirmtitle').text(title2);
        },
        setSegment:function(segment2){            
            attributes.segment=segment2;
            $('#confirmsegment').text(segment2);
        },
        setFunction:function(code2){            
            attributes.code=code2;
        },
        getTitle:function(){            
            return attributes.title;
        },
        getSegment:function(){            
            return attributes.segment;
        },
        getFunction:function(){            
            return attributes.code;
        },
        show:function(){
            $('.modal-confirm').addClass('confirm-visible').removeClass('confirm-hide');
        },
        hide:function(){
            $('.modal-confirm').addClass('confirm-hide').removeClass('confirm-visible');
            $('.modal-styles').addClass('confirm-hide').removeClass('confirm-visible');
        },
        success:function(){
            attributes.code();
            this.setFunction(null);
            this.hide();
        },
    }

})();