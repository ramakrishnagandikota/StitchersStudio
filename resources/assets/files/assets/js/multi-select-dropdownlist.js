$(".level-dropdown dt a").on('click', function() {
  $(".level-dropdown dd ul").slideToggle('fast');
});

$(".level-dropdown dd ul li a").on('click', function() {
  $(".level-dropdown dd ul").hide();
});

$(".skills-dropdown dt a").on('click', function() {
  $(".skills-dropdown dd ul").slideToggle('fast');
});

$(".skills-dropdown dd ul li a").on('click', function() {
  $(".skills-dropdown dd ul").hide();
});

$(".reasonfor-dropdown dt a").on('click', function() {
  $(".reasonfor-dropdown dd ul").slideToggle('fast');
});

$(".reasonfor-dropdown dd ul li a").on('click', function() {
  $(".reasonfor-dropdown dd ul").hide();
});


$(".ratings-dropdown dt a").on('click', function() {
  $(".ratings-dropdown dd ul").slideToggle('fast');
});

$(".ratings-dropdown dd ul li a").on('click', function() {
  $(".ratings-dropdown dd ul").hide();
});

function getSelectedValue(id) {
  return $("#" + id).find("dt a span.value").html();
}

$(document).bind('click', function(e) {
  var $clicked = $(e.target);
  if (!$clicked.parents().hasClass("level-dropdown")) $(".level-dropdown dd ul").hide();
});

$(document).bind('click', function(e) {
  var $clicked = $(e.target);
  if (!$clicked.parents().hasClass("skills-dropdown")) $(".skills-dropdown dd ul").hide();
});

$(document).bind('click', function(e) {
  var $clicked = $(e.target);
  if (!$clicked.parents().hasClass("reasonfor-dropdown")) $(".reasonfor-dropdown dd ul").hide();
});

$(document).bind('click', function(e) {
  var $clicked = $(e.target);
  if (!$clicked.parents().hasClass("ratings-dropdown")) $(".ratings-dropdown dd ul").hide();
});

$(document).bind('click', function(e) {
  var $clicked = $(e.target);
  if (!$clicked.parents().hasClass("ratings-dropdown")) $(".ratings-dropdown dd ul").hide();
});

function updateCounterskills() {
  var len = $('.skills-mutliSelect').find('input[type=checkbox]:checked').length;

  if(len>0){$("#general i .counter").text('('+len+')');}else{$("#general i .counter").text('');}
  console.log(len);
}

$(".skills-mutliSelect input:checkbox").on("change", function() {
  updateCounterskills();
});


function updateCounterlevel() {
    var len = $('.level-mutliSelect').find('input[type=checkbox]:checked').length;

    if(len>0){$("#general-level i .counter").text('('+len+')');}else{$("#general-level i .counter").text('');}
    console.log(len);
}

$(".level-mutliSelect input:checkbox").on("change", function() {
    updateCounterlevel();
});

function updateCounterreason() {
  var len = $('.reasonfor-mutliSelect').find('input[type=checkbox]:checked').length;

  if(len>0){$("#general-reasonfor i .counter").text('('+len+')');}else{$("#general-reasonfor i .counter").text('');}
  console.log(len);
}

$(".reasonfor-mutliSelect input:checkbox").on("change", function() {
  updateCounterreason();
});

function updateCounterratings() {
  var len = $('.ratings-mutliSelect').find('input[type=checkbox]:checked').length;

  if(len>0){$("#general-ratings i .counter").text('('+len+')');}else{$("#general-ratings i .counter").text('');}
  console.log(len);
}

$(".ratings-mutliSelect input:checkbox").on("change", function() {
  updateCounterratings();
});


