//发布话题
$(document).ready(function() {
	
    $("#add_tag_link").click(function(e) {
        e.preventDefault();
        $(this).hide();
        $("#tag_input").show();
    });

});
