  'use strict';
  // $(document).ready(function() {
  //     Sortable.create(draggablePanelList, {
  //         group: 'draggablePanelList',
  //         animation: 150
  //     });

  //     Sortable.create(draggableMultiple, {
  //         group: 'draggableMultiple',
  //         animation: 150
  //     });
  //     Sortable.create(draggableWithoutImg, {
  //         group: 'draggableWithoutImg',
  //         animation: 150
  //     });
  // });

// $( function() {
//     $( "#draggablePanelList,#draggableMultiple,#draggableWithoutImg" ).sortable({
//       revert: true,
//       animation:150
//     });
//   } );

  // $( function() {
  //   $( "#draggableWithoutImg" ).sortable({
  //     revert: true,
  //     animation:150
  //   });
  // } );

  // $("#sortable1, #sortable2").sortable({
  //   connectWith: ".connectedSortable"
  //   });

  $(function () {

    $('.droptrue').on('click', 'li', function () {

        $(this).toggleClass('selected');
        var $c = $(this).find(".card-title");
           $c.toggleClass("se");
           $(".d_n").addClass('d_b');

    });

    // $('.plus_icon').on('click', function () {
    //   $(this).toggleClass('plus minus');
    // });

  //   $('ul.droptrue li ').click( function() {

  //     $(this).toggleClass('selected');
  //     // var $cb = $(this).find(":checkbox");
  //     // if (!$cb.prop("checked")) {
  //     //     $cb.prop("checked", true);
  //     // } else {
  //     //     $cb.prop("checked", false);
  //     // }
  // });

  // $(".border-checkbox-section").click(function(){
  //   // $(this).toggleClass('selected');
  // });

    $("ul.droptrue").sortable({
        connectWith: '.droptrue',
        opacity: 0.6,
        dropOnEmpty: true,
        // handle: ".handle",
        revert: true,
        forcePlaceholderSize: true,
        helper: function (e, item) {
            console.log('parent-helper');
            console.log(item);
            if(!item.hasClass('selected'))
               item.addClass('selected');
            var elements = $('.selected').not('.ui-sortable-placeholder').clone();
            var helper = $('<ul/>');
            item.siblings('.selected').addClass('hidden');
            return helper.append(elements);
        },
        start: function (e, ui) {
            var elements = ui.item.siblings('.selected.hidden').not('.ui-sortable-placeholder');
            ui.item.data('items', elements);
        },
        receive: function (e, ui) {
            ui.item.before(ui.item.data('items'));
        },
        stop: function (e, ui) {

            var dropId = ui.item.parent().attr("id");
            var Id = ui.item.attr("data-id");

            //alert(Id + ' - '+ dropId);

            if(Id == 0 || dropId == 'sortable1'){
                notify('fa fa-times','danger',' ','can not drag / drop from new patterns');
                return false;
            }

            if(dropId == 'sortable2'){
              var dropTo = 1;
              var dropdown = '<a class="dropdown-item waves-light waves-effect note moveToArchive" href="javascript:;" data-type="success" data-from="top" data-animation-in="animated fadeInRight" data-animation-out="animated fadeOutRight" data-id="'+Id+'" >Add to Archive</a><a class="dropdown-item waves-light waves-effect note moveProject" href="javascript:;" data-type="success" data-from="top" data-animation-in="animated fadeInRight" data-animation-out="animated fadeOutRight" data-id="'+Id+'" data-dropid="sortable3" data-current="generatedpatterns" data-target="workinprogress" >Add to Work in Progress</a><a class="dropdown-item waves-light waves-effect note moveProject" href="javascript:;" data-type="success" data-from="top" data-animation-in="animated fadeInRight" data-animation-out="animated fadeOutRight" data-id="'+Id+'" data-dropid="sortable4" data-current="generatedpatterns" data-target="completed" >Add to Completed</a><a class="dropdown-item waves-light waves-effect deleteAction" data-toggle="modal" data-id="'+Id+'" data-target="#delete-Modal"> Delete</a>';
              ui.item.attr('id',"generatedpatterns"+Id);
            }else if(dropId == 'sortable3'){
              var dropTo = 2;
              var dropdown = '<a class="dropdown-item waves-light waves-effect note moveToArchive" href="javascript:;" data-type="success" data-from="top" data-animation-in="animated fadeInRight" data-animation-out="animated fadeOutRight" data-id="'+Id+'" >Add to Archive</a><a class="dropdown-item waves-light waves-effect note moveProject" href="javascript:;" data-type="success" data-from="top" data-animation-in="animated fadeInRight" data-animation-out="animated fadeOutRight" data-id="'+Id+'" data-dropid="sortable4" data-current="workinprogress" data-target="completed">Add to Completed</a><a class="dropdown-item waves-light waves-effect deleteAction" data-toggle="modal" data-id="'+Id+'" data-target="#delete-Modal"> Delete</a>';
              ui.item.attr('id',"workinprogress"+Id);
            }else{
              var dropTo = 3;
              var dropdown = '<a class="dropdown-item waves-light waves-effect note moveToArchive" href="javascript:;" data-type="success" data-from="top" data-animation-in="animated fadeInRight" data-animation-out="animated fadeOutRight" data-id="'+Id+'" >Add to Archive</a><a class="dropdown-item waves-light waves-effect note moveProject" href="javascript:;" data-type="success" data-from="top" data-animation-in="animated fadeInRight" data-animation-out="animated fadeOutRight" data-id="'+Id+'" data-dropid="sortable3" data-current="completed" data-target="workinprogress">Add to Work in Progress</a><a class="dropdown-item waves-light waves-effect deleteAction" data-toggle="modal" data-id="'+Id+'" data-target="#delete-Modal"> Delete</a>';
              ui.item.attr('id',"completed"+Id);
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
              url : URL+'/knitter/project/change-status',
              type : 'POST',
              data: 'id='+Id+'&status='+dropTo,
              beforeSend : function(){
                //$(".loading").show();
              },
              success : function(res){

                ui.item.siblings('.selected').removeClass('hidden');
                $('.selected').removeClass('selected');
                $('.se').removeClass('se');
                $(".d_n").addClass('d_b');
                $("#date"+Id).html(DATE);
				$("#dropdown"+Id).html(dropdown);
              },
              complete : function(){
                //$(".loading").hide();
              }
            });

        },
      //  update: updatePostOrder
    });
    $(".ul.droptrue").disableSelection();

    $("#sortable2,#sortable3,#sortable4").disableSelection();
    $("#sortable2,#sortable3,#sortable4").css('minHeight', "483.5px");
  //  updatePostOrder();
});

// $(document).ready(function(){
//   $("a.collapsed").click(function(){
//        $(this).find(".btn:contains('answer')").toggleClass("collapsed");
//    });
//   });

//   $(document).ready(function(){
//     // Add minus icon for collapse element which is open by default
//     $(".collapse.show").each(function(){
//       $(this).prev(".card-header").find(".fa").addClass("fa fa-minus").removeClass("fa fa-plus");
//     });

//     // Toggle plus minus icon on show hide of collapse element
//     $(".collapse").on('show.bs.collapse', function(){
//       $(this).prev(".card-header").find(".fa").removeClass("fa fa-plus").addClass("fa fa-minus");
//     }).on('hide.bs.collapse', function(){
//       $(this).prev(".card-header").find(".fa").removeClass("fa fa-minus").addClass("fa fa-plus");
//     });
// });
