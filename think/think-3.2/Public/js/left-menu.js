// JavaScript Document
$(function() {
    var submenu = $('.sub-menu');
    $('#menu > li > a').click(function() {
        var this_sub = $(this).next('.sub-menu');
        $('.select').removeClass('select');
        $('i.arrow').removeClass('icon-angle-down').addClass('icon-angle-left');
        if (this_sub.is(':hidden')) {
            submenu.slideUp('fast');
            this_sub.slideDown('fast');
            $('.arrow', this).addClass('icon-angle-down');
        } else {
            this_sub.slideUp('fast');
        }
    });
    $('.sub-menu > li > a').click(function() {
        $('#menu  li').removeClass('active');
        var top_li = $(this).parents('.sub-menu').parent();//父LI
        $(this).parent().addClass('active');//添加当前样式
        $('.selected').appendTo(top_li.addClass('active').find('>a'));
    })
    $('#home').click(function() {
        $('#menu  li').removeClass('active');
        $(this).parent().addClass('active');//添加当前样式
        $('.selected').appendTo(this);
    })
})