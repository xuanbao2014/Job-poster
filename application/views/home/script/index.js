$(document).ready(function(){  
    $(".panel-title").click(function(){
        $("#collapse").collapse("toggle");
    });

    $('[data-toggle="tooltip"]').tooltip();
    
    $(".panel-body .filter-panel .dropdown").hover(
        function() {$(this).addClass('open');},
        function() {$(this).removeClass('open');}
    );

    $('.favoritePopover').click(function (e) {
        e.preventDefault();
        var tgt = $(this);
        $.ajax({
            type : 'POST',
            url : tgt.attr('href'),
            success:function (data) {
                tgt.children('i').toggleClass('fa-star-o');
                tgt.children('i').toggleClass('fa-star');
            },
        });
    });

    $('.favoritePopover').each(function () {
        var tgt = $(this);
        $.ajax({
            type : 'POST',
            url : tgt.attr('value'),
            success:function (data) {
                if(data==1){
                    tgt.children('i').toggleClass('fa-star-o');
                    tgt.children('i').toggleClass('fa-star');
                }
            }
        });
    });

    //enable popover
    $('.favoritePopover2').popover({
      placement: 'left',
      html: true,
    });

    $('body').on('click', function (e) {
        $('[data-toggle="popover"]').each(function () {
            //the 'is' for buttons that trigger popups
            //the 'has' for icons within a button that triggers a popup
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                $(this).popover('hide');
            }
        });
    });

});

