gy_person.offering = function(){
        $('.p-upbtn').hover(
            function(){
                $(this).parent().addClass('p-uphight');
            },
            function(){
                $(this).parent().removeClass('p-uphight');
            }
        );
        $('.p-diyimgs img').click(function(){
                $('.p-curimg').find('img').attr('src',$(this).attr('src'));
        });
};
gy_person.offering();