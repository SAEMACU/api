function onclickchangestatus(p_id){ 
	$('#p'+p_id).html('Liked <i class="fa fa-heart" aria-hidden="true"></i>');
	/*make ajax call here and send status to table to save*/
	if(p_id != 'null'){
	  data = {p_id : p_id};
	  $.ajax({
               url: "/api/objects/postmaster.php/update_post_status",
               data: data,
               dataType: "json",
               type: "POST",
               success: function (msg) {
				   if(msg){
                   location.reload();
					}
					else{
						alert('Sorry Could not update!');
					}
               }
           });
	}
}