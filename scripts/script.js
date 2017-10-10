$(document).ready(function(){
    $('#parks-table').DataTable();
    
    /*Scripts for ratings widgets adapted from a tutorial at:
     *https://code.tutsplus.com/tutorials/building-a-5-star-rating-system-with-jquery-ajax-and-php--net-11541
     *Basic javascript and CSS used from the tutorial with some changes, but I (Elizabeth) rewrote pretty much all of the PHP to
     *work with Fat-Free Routing and PDO
     */
    $('.rate_widget').each(function(i) {
                var widget = this;
                var out_data = {
                    widget_id : $(widget).attr('id'),
                    fetch: 1
                };
                $.post(
                    '/328/bark-parks/ratings',
                    out_data,
                    function(INFO) {
                        $(widget).data( 'fsr', INFO );
                        set_votes(widget);
                    },
                    'json'
                );
            });
    
    $('.ratings_stars').hover(
            // Handles the mouseover
            function() {
                $(this).prevAll().addBack().addClass('ratings_over');
                $(this).nextAll().removeClass('ratings_vote'); 
            },
            // Handles the mouseout
            function() {
                $(this).prevAll().addBack().removeClass('ratings_over');
                set_votes($(this).parent());
            }
        );

    // This actually records the vote
        $('.ratings_stars').bind('click', function() {
            var star = this;
            var widget = $(this).parent();
            
            var clicked_data = {
                clicked_on : $(star).attr('class'),
                widget_id : $(star).parent().attr('id')
            };
            $.ajax({
                type: 'POST',
                url: '/328/bark-parks/ratings',
                data: clicked_data,
                dataType: 'json',
                success: function(INFO) {
                    widget.data( 'fsr', INFO );
                    set_votes(widget);
                },
                error: function(req, textStatus, errorThrown) {
                //this is going to happen when you send something different from a 200 OK HTTP
                alert('Oops, something happened: ' + textStatus + ' ' +errorThrown);
                }
            }
            ); 
        });
        
        $(".featuredpics").on("mouseover", function(){
            $(this).animate({height:'40%'}, 200);
            $(this).animate({width:'40%'}, 200);
        });
        $(".featuredpics").on("mouseout", function(){
            $(this).animate({height:'20%'}, 200);
            $(this).animate({width:'20%'}, 200);
        });
});

function set_votes(widget) {

        var avg = $(widget).data('fsr').avg_rating;
        var votes = $(widget).data('fsr').num_ratings;
        
        $(widget).find('.star_' + avg).prevAll().addBack().addClass('ratings_vote');
        $(widget).find('.star_' + avg).nextAll().removeClass('ratings_vote'); 
        $(widget).find('.total_votes').text( votes + ' votes recorded');
    }

//input script adapted from: https://www.abeautifulsite.net/whipping-file-inputs-into-shape-with-bootstrap-3
$(document).on('change', ':file', function() {
    var input = $(this),
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [label]);
});

$(document).ready( function() {
    $(':file').on('fileselect', function(event, label) {

           var input = $(this).parents('.input-group').find(':text');

          if( input.length ) {
              input.val(label);
          } else {
              if( label ) alert(label);
          }

    });
});

//Password verification script adapted from: http://jsfiddle.net/dbwMY/
$(document).ready(function() {
  $("#password-verify").keyup(validate);
});


function validate() {
  var password = $("#password").val();
  var verify = $("#password-verify").val();

    
 
    if(password == verify) {
        $("#verify-status").removeClass("text-danger");
        $("#verify-status").addClass("text-success");
        $("#verify-status").text("Passwords match");        
    }
    else {
        $("#verify-status").removeClass("text-success");
        $("#verify-status").addClass("text-danger");
        $("#verify-status").text("Passwords do not match!");  
    }
    
}