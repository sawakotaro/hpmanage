$(function() {
   $("form :input[name^='is_batch']") .change(function() {
       toggleBatchArea($(this));
   }) .each(function() {
       toggleBatchArea($(this));
   });
   
   $("a.birthday_of_today") .click(function() {
      var date = new Date();
      $("form :input[name='birth_year'] option[value='']") .prop('selected', true);
      $("form :input[name='birth_month'] option[value='"+ (date.getMonth() + 1) +"']") .prop('selected', true);
      $("form :input[name='birth_day'] option[value='"+ (date.getDate()) +"']") .prop('selected', true);
   });
});

function toggleBatchArea(obj) {
    if(obj .prop("checked")) {
        obj .closest("div") .find("div.datetime") .hide();
        obj .closest("div") .find("div.batch") .show();
    } else {
        obj .closest("div") .find("div.batch") .hide();
        obj .closest("div") .find("div.datetime") .show();
    }
}