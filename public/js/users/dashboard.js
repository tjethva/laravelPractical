$(document).ready(function(){   
	$( "#searchConn" ).on('keyup', function() {
		let value = $(this).val();

	    $.ajax({
	        type: 'POST',
	        url: '/get-users',
	        data: {'search': value},

	        dataType: "json",
	        success: function(data){                   
	          $("#outputUser").html(data.response);                          
	        },
	        error:function (xhr, ajaxOptions, thrownError){
	          console.log(thrownError);
	        }
	      });                 
	    });

$('body').on('click', '.connectUser', function() {
	//$( ".connectUser" ).click(function() {
		alert("dsad");
		let userId = $(this).attr('data-id');
		let dataAction = $(this).attr('data-action');

	    $.ajax({
	        type: 'POST',
	        url: '/connect-user',
	        data: {'user_id': userId, 'action': dataAction},

	        dataType: "json",
	        success: function(data){                   
	          //$("#outputUser").html(data.response);                          
	        },
	        error:function (xhr, ajaxOptions, thrownError){
	          console.log(thrownError);
	        }
	    });                 
	});
});