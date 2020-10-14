$(document).ready(function(){     
var i=1;  
$('#add').click(function(){  

       $('#tcnlg').append('<input id="technology'+i+'" type="text" class="form-control" name="technology['+i+']" value="" required autocomplete="technology" autofocus>');  
  		i++;
  }); 

});