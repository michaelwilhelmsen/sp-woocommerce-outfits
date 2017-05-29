jQuery(document).ready(function($) {

  // Observe a specific DOM element:
  $("#spwo_outfit_image_id-status").bind("DOMSubtreeModified", clickImage );

  function addDotsOnLoad() {
    // Adding each .dot position to an array
    var interestPoints = [];
    $('.cmb-repeatable-grouping').each( function() {
      interestPoints.push($(this).find('.regular-text').val());
    });
    // console.log(interestPoints);

    var dot_count = 0;

    // Creating and positioning the .dot elements in the image
    if (interestPoints.length >= 1) {
      interestPoints.forEach(function(item) {
        dot_count++;
        var position = (item);
        var image = $('.cmb2-media-item img.cmb-file-field-image').parent();

        var top_perc = parseInt(item.split(","));
        var left_perc = parseInt(item.split(",").pop());

        console.log('Top perc: ' + top_perc + '. Left perc: ' + left_perc);

        var dot = '<div class="dot" data-point-number="' + (dot_count) + '" style="top: ' + top_perc + '%; left: ' + left_perc + '%;">' + (dot_count) + '</div>';
        $(dot).appendTo($(image));
      });
    }

    // Drag Dot behaviour
    $( ".dot" ).draggable({
      containment: ".cmb2-media-item",
      stop: function( event, ui ) {
        var new_left_perc = parseInt($(this).css("left")) / ($(".cmb2-media-item").width() / 100) + "%";
        var new_top_perc = parseInt($(this).css("top")) / ($(".cmb2-media-item").height() / 100) + "%";
        $(this).css("left", new_left_perc);
        $(this).css("top", new_top_perc);

        if (dot_count < 1) {
          var dot_number = 0;
        } else {
          var dot_number = $(this).attr('data-point-number') - 1;
        }

        // Add position to correct group
        $('#outfit_points_' + dot_number + '_point_position').val(parseInt(new_top_perc) + ', ' + parseInt(new_left_perc));
        console.log('#outfit_points_' + dot_number + '_point_position');
        console.log(parseInt(new_top_perc) + ', ' + parseInt(new_left_perc));
      }
    });
  }

  function clickImage() {
    $( ".cmb2-media-item img.cmb-file-field-image" ).click(function(e) {
      e.preventDefault();
      e.stopImmediatePropagation();

      // VARIABLES
      var dot_count = $( ".dot" ).length;

      var top_offset = $(this).offset().top - $(window).scrollTop();
      var left_offset = $(this).offset().left - $(window).scrollLeft();
      var top_px = Math.round( (e.clientY - top_offset - 12) );
      var left_px = Math.round( (e.clientX - left_offset - 12) );
      var top_perc = top_px / $(this).height() * 100;
      var left_perc = left_px / $(this).width() * 100;

      var dot = '<div class="dot" data-point-number="' + (dot_count + 1) + '" style="top: ' + top_perc + '%; left: ' + left_perc + '%;">' + (dot_count + 1) + '</div>';


      // Append .dot when Image is clicked
      $(dot).hide().appendTo($(this).parent()).fadeIn(350);;

      // If .dot added is 2 or higher, add Interest Point Meta Box
      if (dot_count > 0) {
        $('.cmb-add-group-row').click();
      }

      // console.log("Left: " + left_perc + "%; Top: " + top_perc + '%;');

      // Add position to correct meta box group
      $('#outfit_points_' + parseInt(dot_count) + '_point_position').val(parseInt(top_perc) + ', ' + parseInt(left_perc));


      // Drag Dot behaviour
      $( ".dot" ).draggable({
        containment: ".cmb2-media-item",
        stop: function( event, ui ) {
          var new_left_perc = parseInt($(this).css("left")) / ($(".cmb2-media-item").width() / 100) + "%";
          var new_top_perc = parseInt($(this).css("top")) / ($(".cmb2-media-item").height() / 100) + "%";
          $(this).css("left", new_left_perc);
          $(this).css("top", new_top_perc);

          if (dot_count < 1) {
            var dot_number = 0;
          } else {
            var dot_number = $(this).attr('data-point-number') - 1;
          }

          // Add position to correct group
          $('#outfit_points_' + dot_number + '_point_position').val(parseInt(new_top_perc) + ', ' + parseInt(new_left_perc));
          console.log('#outfit_points_' + dot_number + '_point_position');
          console.log(parseInt(new_top_perc) + ', ' + parseInt(new_left_perc));
        }
      });
    });
  }

  // Remove corresponding dot when row is removed
  $('#cmb2-metabox-spwo_outfit_metabox').on('click', '.cmb-remove-group-row', function() {
    var rowIterator = parseInt($('.cmb-repeatable-grouping').parent().length);
    var currentDot = $('.dot[data-point-number="' + rowIterator + '"]');

    // Update dot siblings
    $(currentDot).nextAll().each( function() {
      $(this).html(parseInt($(this).attr('data-point-number')) - 1);
      $(this).attr('data-point-number', parseInt($(this).attr('data-point-number')) - 1);
    });

    // Remove dot that == removed row
    $(currentDot).remove();
  });

  addDotsOnLoad();
  clickImage();
});
