$( document ).ready(function(){
  $(".button-collapse").sideNav();
  $('.tabs').tabs();
  $('ul.tabs').tabs({
  swipeable : true,
});
  instance.select('tab_id');
  instance.updateTabIndicator();
  instance.destroy();

})
