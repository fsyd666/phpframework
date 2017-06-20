$(function(){
  $('.stu').height( $('.linjok').height() * 0.7125 );
  
  $('.stu').width( $('.ig').width() );
  
  $('.tetl,.tetr').css('height',$('.edg').height());
  
  $('.tetl,.tetr').css('lineHeight',$('.edg').height() + 'px');
  
  $('.tetl,.tetr').css('color','#fff');
  
  $('.tet').css('lineHeight',$('.stu').height() + 'px');
  
  $('.stu').css('marginTop',($('.bjk').height() - $('.stu').height()) * 0.5);
  
  $('.null').width($('.stu').width() * 0.3);
  
  for(var i=1;i<5;i++){
    $('.stu').eq(i).css('marginLeft',$('.stu').width()*0.1);
  };
  
  $('.tetl,.tet,.tetr').css('fontSize',$('.linjok').height() * 0.35 + 'px');
  
  //居中
  $('.bjk').css('left', ($('.linjok').width() - $('.bjk').width()) * 0.5);
  
  
  //初始随机数
  function GetRandomNum(Min,Max){   
    var Range = Max - Min;   
    var Rand = Math.random();   
    return(Min + Math.round(Rand * Range));
  }
  var numarr = [GetRandomNum(3,6),GetRandomNum(0,9),GetRandomNum(0,9),GetRandomNum(0,9)];
  //alert(num);
  for(var i=1;i<5;i++){
    $('.tet').eq(i).html(numarr[i-1])
  };
  
  var tet = parseInt( $('.tet').eq(0).html()+$('.tet').eq(1).html()+$('.tet').eq(2).html()+$('.tet').eq(3).html()+$('.tet').eq(4).html() )
  
  //alert(typeof(tet))
  
  //定时器
  function numup(){
    var i = GetRandomNum(1,6);
    //alert(typeof(i))
    return i;
  }
  
  //alert(numup())
  
  //var j = numup();
  setInterval(function(){
    numup();
    
    var j = numup();
    //j++;
    var q = tet += j;
    //alert(q)
    var s = q.toString();
    var a = s.split("");
    for(var i=1;i<5;i++){
      $('.tet').eq(i).html(a[i-1])
    }
  },3000)
})