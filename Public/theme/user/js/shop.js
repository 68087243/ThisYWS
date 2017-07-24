/**
 * @Version   :1.0.0
 * @WebSite   :http://www.t3t2.com/
 * @DateTime  :2016-02-28 01:48:20
 * @By        :Xiaoya
 * 积分商城 - 全局JS
 **/

// 全局购买次数按钮
// +
var goods_max = 999; // 必须控制最大参与数
$('.number-btn-plus').click(function(){
    var targetInput = $(this).parent().find('.g-number-input'),
        goods_max = parseInt(targetInput.attr('maxval')),
        count = parseInt(targetInput.val()) + 1;
    if (count <= goods_max && goods_max != 0) {
        targetInput.val(count);
    }else{
        targetInput.val(goods_max);
    }
});
// -
$('.number-btn-minus').click(function(){
    var targetInput =$(this).parent().find('.g-number-input'),
        goods_max = parseInt(targetInput.attr('maxval')),
        count = parseInt(targetInput.val()) - 1;
    if (count < 1 && goods_max != 0) {
        targetInput.val(1);
    }else if(goods_max == 0){
        targetInput.val(0);
    }else{
        targetInput.val(count);
    }
});
$('.g-number-input').bind({
    mouseover: function(){
        $(this).select();
    },
    blur: function(){
        var goods_max = parseInt($(this).attr('maxval')),
            goods_cur = parseInt($(this).val());
        goods_cur = goods_cur > 0 ? goods_cur : 1;
        if (goods_cur > goods_max && goods_max != 0) {
            $(this).val(goods_max);
        }else if(goods_max == 0){
            $(this).val(goods_max);
        }else{
            $(this).val(goods_cur);
        }
    }
});

// 商品内容页
// 商品大图展示TAB
function initTab(ele,cla,con,evt){
    var evt = evt? evt : "mouseover";
    $(ele).live(evt,function(){
        var index = $(this).index();
        $(this).addClass(cla).siblings().removeClass(cla);
        $(con).eq(index).show().siblings().hide();
    }).eq(0).trigger(evt)
}
// 奖品详情-商品展示-触摸加Class
initTab('#gallery-thumb li','active','#gallery-full li','mouseover');

// 购物车
// 删除商品操作
var car_goods_id = 0;
$('.car-del-btn').click(function(){
    // 删除提示
    popTips('pop-shopping-cart', '<p class="tc">亲，您确定要将该商品移除购物车外么，</p> <p class="tc">还请三思~~</p>', '<a href="javascript:;" class="optbtn" id="gs-del-btn">移除</a>');
    // 获取商品参数
    car_goods_id = $(this).attr('sid');
});

$('#pop-shopping-cart #gs-del-btn').live('click', function(){
    if(car_goods_id) {
        var param = {
            'ac': 'del_car_item',
            'id': car_goods_id
        }
        getJson(param, function(result){
            if(result == 1) {
                window.location.href = window.location.href;
            }else{
                alert('网络原因，请稍后重试。');
            }
        }, app_url+'/api/api.php', 'POST');
    }
});

// 全选
// checkbox操作
$('.w-checkbox').bind('click',function(){
    if ($(this).hasClass('icon-checkbox-selected')) {
        $(this).removeClass('icon-checkbox-selected');
    }else{
        $(this).addClass('icon-checkbox-selected');
    }
});

// 商城商品全选
// 由于购物车的checkbox有其他操作，所以先删除之前绑定的点击事件
$('.m-cart-order .w-checkbox').unbind('click');
var chk_list = $('#cart-submit .w-checkbox');  //选择所有checkbox元素
var item_chk = $('.item-box .w-checkbox');  //选择商品栏目下的checkbox元素
$('.checkall').live('click', function(){
    var obj = $(this).closest('.w-table').find('.w-checkbox');
    if (obj.hasClass('icon-checkbox-selected')) {
        obj.removeClass('icon-checkbox-selected');
        if ($('.item-box .w-checkbox').hasClass('icon-checkbox-selected')) {
            submitAble();
        }else{
            submitDisable();
        }
    }else{
        obj.addClass('icon-checkbox-selected');
        submitAble();
    }
    // 设置统计栏
    setBalance();
})
// 根据商品勾选，判断提交按钮状态
item_chk.live('click', function(){
    // 修改点击的商品选择状态
    if ($(this).hasClass('icon-checkbox-selected')) {
        $(this).removeClass('icon-checkbox-selected');
    }else{
        $(this).addClass('icon-checkbox-selected');
    }

    // 判断是否有一个商品被选中
    if ($('.item-box .w-checkbox').hasClass('icon-checkbox-selected')) {
        submitAble();
    }else{
        submitDisable();
    }

    // 设置统计栏
    setBalance();
});
$('#submit-checkout').bind('click', cartSubmit);
function cartSubmit(){
    $('#cart-order-form').submit();
    return false;
}
function submitAble(){
    $('#submit-checkout').removeClass('cart-submit-disabled').bind('click', cartSubmit);
}
function submitDisable(){
    $('#submit-checkout').addClass('cart-submit-disabled').unbind('click', cartSubmit);
}
// 设置统计栏对应数量和价格
function setBalance(){
    // 设置已选商品数量
    var select_num = 0;
    var goods_count = $('.item-box .w-checkbox').length;
    for(var i = 0; i < goods_count; i++){
        if ($('.item-box .w-checkbox').eq(i).hasClass('icon-checkbox-selected')) {
            select_num++;
        };
    }
    $('#select-num').text(select_num);
    // 设置已选商品总价格
    getTotalPrice();
}
$('#submit-checkout').bind('click', cartSubmit);
function cartSubmit(){
    $('#cart-order-form').submit();
    return false;
}
function submitAble(){
    $('#submit-checkout').removeClass('cart-submit-disabled').bind('click', cartSubmit);
}
function submitDisable(){
    $('#submit-checkout').addClass('cart-submit-disabled').unbind('click', cartSubmit);
}
// 设置统计栏对应数量和价格
function setBalance(){
    // 设置已选商品数量
    var select_num = 0;
    var goods_count = $('.item-box .w-checkbox').length;
    for(var i = 0; i < goods_count; i++){
        if ($('.item-box .w-checkbox').eq(i).hasClass('icon-checkbox-selected')) {
            select_num++;
        };
    }
    $('#select-num').text(select_num);
    // 设置已选商品总价格
    getTotalPrice();
}
// 所有商品合计
function getTotalPrice(){
    var goods_count = $('.item-box .w-checkbox').length,
        total_credit = 0,
        total_pfcoin = 0;
    for(var i = 0; i < goods_count; i++){
        if ($('.item-box .w-checkbox').eq(i).hasClass('icon-checkbox-selected')) {
            var obj = $('.item-box').eq(i).find('.col-total span'),
                cobj = obj.eq(0).attr('val'), //获取未格式化的价格
                pobj = obj.eq(1).html() ? obj.eq(1).attr('val') : 0; //获取未格式化的价格

            total_credit += Number(cobj);
            total_pfcoin += Number(pobj);
        };
    }
    if (total_credit >= 10000) { total_credit = total_credit/10000 + '万'; };// 如果金额超过1万，格式化字段；x.xx万
    if (total_pfcoin >= 10000) { total_pfcoin = total_pfcoin/10000 + '万'; };// 如果金额超过1万，格式化字段；x.xx万
    $('.w-table-balance .col-sums em').eq(0).text(total_credit); //积分
    $('.w-table-balance .col-sums em').eq(1) && $('.w-table-balance .col-sums em').eq(1).text(total_pfcoin); //平台币
}
