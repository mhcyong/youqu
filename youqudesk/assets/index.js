function readall(tid) {
    $(".loading").show();
    $.post("/usr/themes/youqudesk/libs/apiforcomment.php", {"tid" : tid, "all" : "yes"}, function(data) {
            if (data == "0") {
            $("#comments_from_api").html("还没有评论");

            } else {
            $("#comments_from_api").html(data.html);
            }
            $("#comments_from_api").show();
            $(".loading").hide();
            //$("#share_" + sid + " .comments-count").text(data.count); 

            }, "json");
    return false;
}


function readrefresh(tid) {
    $(".loading").show();
    $("#comments_from_api").hide();
    $(".comment_form").hide();
    $.post("/usr/themes/youqudesk/libs/apiforcomment.php", {"tid" : tid}, function(data) {
		if (data == "0") {
		$("#comments_from_api").html("还没有评论");

		} else {
		$("#comments_from_api").html(data.html);
		}
		$("#comments_from_api").show();
		$(".loading").hide();
		$(".comment_form").show();
		//$("#share_" + sid + " .comments-count").text(data.count); 
		}, "json");
}


function share_item_click(e) {
	var target_el = $(e.target);
	if(target_el.hasClass("web_link")) {
		target_el.addClass("visited");
		return;
	}
	if(target_el.hasClass("tag") || target_el.parent().hasClass("icon")) {
		return;
	}

	//用户删除
	if (target_el.hasClass("share_del")) {
		e.preventDefault();
		var sid = target_el.attr("sid");
		$.post("/share/del", {"sid" : sid}, function(data) {
				if (data.status == 0) {
					$("#share_" + sid).slideUp(200);
					$.notifyBar({
						"html": "删除成功",
						"cls":"success"
						});
				} else {

				$.notifyBar({
					"html": data.msg,
					"cls":"error"
					});
				}
			}, "json");
		return;
	}

	//管理员删除
	if (target_el.hasClass("admin_del")) {
		e.preventDefault();
		var sid = target_el.attr("sid");
		$.post("/share/admin_del", {"sid" : sid}, function(data) {
				if (data.status == 0) {
					$("#share_" + sid).slideUp(200);
					$.notifyBar({
						"html": "删除成功(管理员)",
						"cls":"success"
						});
				} else {

				$.notifyBar({
					"html": data.msg,
					"cls":"error"
					});
				}
			}, "json");
		return;
	}

	if ($(this).hasClass("opened")) {

		$(this).removeClass("opened");
		$(this).find(".media-info a").addClass(".aavisited");
		$(".sidebar").show();
		$(".comment").hide();
		$(".main").removeClass("radius-left");
		$(".main").addClass("radius-both");
		$(".home-header").removeClass("radius-left");
		$(".home-header").addClass("radius-both");
		$("#reply_tid").val("");
		$("#reply_content").val("");
		$(".loading").hide();
		$(".comment_form").hide();

	} else {

		//打开
		$(".stream-item").removeClass("opened");
		$(this).addClass("opened");

		$(".sidebar").hide();
		$(".comment").show();
		$("#comments_from_api").hide();
		$(".main").removeClass("radius-both");
		$(".main").addClass("radius-left");
		$(".home-header").removeClass("radius-both");
		$(".home-header").addClass("radius-left");
		$(".loading").show();
		$(".comment_form").hide();
		var tid = $(this).attr("tid");
		$("#reply_tid").val(tid);
		document.getElementById("new_comment_form").action="/note/"+tid+"/comment";
		
		$("#reply_content").val("");		
		$.post("/usr/themes/youqudesk/libs/apiforcontent.php", {"tid" : tid}, function(data) {
			$("#content_from_api").html(data.html);
			$("#content_from_api").show();
			$(".loading").hide();
		}, "json");
		
		$.post("/usr/themes/youqudesk/libs/apiforcomment.php", {"tid" : tid}, function(data) {
			if (data == "0") {
				$("#comments_from_api").html("还没有评论");

			} else {
				$("#comments_from_api").html(data.html);
			}
			$("#comments_from_api").show();
			$(".loading").hide();

			if(data.topic_status == 1) {
				$(".comment_form_not_allow").show();
				$(".comment_form_not_allow").html(data.msg);
			} else {
				$(".comment_form_not_allow").hide();
				$(".comment_form").show();
			}

			//$("#share_" + sid + " .comments-count").text(data.count); 

		}, "json");

	}
}


$(document).ready(function() {
        $("#new_comment_form").submit(function(e) {
                e.preventDefault();

                var submit_el = $(this).find("input[type=submit]");
                submit_el.attr("disabled", "disabled").val("已提交...").blur();

                var value = $("#new_comment_form").serialize();
				var foraction = document.getElementById("new_comment_form").action;
                $.post(foraction, value, function(data){
				   //alert("Data Loaded: " + data);
				$(".loading").show();
				$("#comments_from_api").hide();
				$(".comment_form").hide();
				
				var tid = document.getElementById("reply_tid").value;
				$.post("/usr/themes/youqudesk/libs/apiforcomment.php", {"tid" : tid}, function(data) {
					if (data == "0") {
					$("#comments_from_api").html("还没有评论");

					} else {
					$("#comments_from_api").html(data.html);
					}
					$("#comments_from_api").show();
					$(".loading").hide();
					$(".comment_form").show();
					$("textarea").val("");
				}, "json");
                
				 });               
                //submit_el.removeAttr("disabled").val("回复");	
        });
        $(".stream-item").live({
                "click" : share_item_click,
                "mouseover" : function() {
                $(this).addClass("hover");
                $(this).find(".share_action").show();
                },

                "mouseout": function() {
                $(this).removeClass("hover");
                $(this).find(".share_action").hide();
                }

                });

        $(".comments-items").height($(window).height() - 110);
        var main_width = $(".main").width();
        var container_width = $(".container").width();
        var comment_width = container_width - main_width;
        $(".comment").css({"margin-left" : main_width + "px", "width" : comment_width+"px"});
        $(window).resize(function() {
                $(".comments-items").height($(window).height() - 110);
                var main_width = $(".main").width();
                var container_width = $(".container").width();
                var comment_width = container_width - main_width;
                $(".comment").css({"margin-left" : main_width + "px", "width" : comment_width+"px"});
                });
        $(".login_user").hover( function() {
                $(this).toggleClass("active",!$(this).hasClass("active"))
                });
        //关闭评论列表
        $("#comment_close").click(function(e) {
                    e.preventDefault();
                    $(this).blur();
                    $(".stream-item").removeClass("opened");
                    $(".sidebar").show();
                    $(".comment").hide();
                    $(".main").removeClass("radius-left");
                    $(".main").addClass("radius-both");
                    $(".home-header").removeClass("radius-left");
                    $(".home-header").addClass("radius-both");
                    $("#reply_tid").val("");
                    $("#reply_content").val("");
                    $(".loading").hide();
                    $(".comment_form").hide();
        });
        /*
        $("body").click(function(e) {
                e = $(e.target);
                if (!e.hasClass("login_user") &&
                    !e.parents(".login_user").length
                    ) {
                    $(".login_user").removeClass("active");
                }

                });
        */
        $(".follow_tag").click(function(e) {
                e.preventDefault();
                var tid = $(this).attr("tid");
                var value = {"tid" : tid};
                e = $(e.target);
                $.post("/tag/follow_or_un", value, function(data) {
                    if (e.text() == "关注该标签") {
                        e.text("取消关注");
                        var follow_count = $("#follow_count").text();
                        $("#follow_count").text(parseInt(follow_count) + 1);
                    } else {
                        e.text("关注该标签");
                        var follow_count = $("#follow_count").text();
                        $("#follow_count").text(parseInt(follow_count) - 1);
                    }
                    });
                });

       
       
        //喜欢
        $(".like").live("click", function(e) {
            var rid = $(this).attr("rid");
            var like_el = $(this);

            $.post("/reply/like", {"rid" : rid}, function(data) {
                if(data.status == 0) {
                    like_el.next().text(data.like_count);
                } else {
                    $.notifyBar({
                        "html": data.msg,
                        "cls":"error"
                    });
                }
            }, "json");
        });

        $(".normal-replies .comment-item").live({
            "mouseover" : function() {
                $(this).find(".comment-time .to").show();
                if($(this).find(".comment-text").text().indexOf("@") != -1) {
                    $(this).find(".talk").show();
                }
                $(this).find(".reply_time").hide();
                $(this).find(".action_like").show();
            },

            "mouseout": function() {
                $(this).find(".comment-time .to").hide();
                $(this).find(".talk").hide();
                $(this).find(".reply_time").show();
                $(this).find(".action_like").hide();
            }

        });

        //返回顶部
        $backToTopEle = $(".gotoTop").click(function() {
            $("html, body").animate({ scrollTop: 0 }, 120);
        }), $backToTopFun = function() {
            var st = $(document).scrollTop(), winh = $(window).height();
            (st > 0)? $backToTopEle.show(): $backToTopEle.hide();    
            //IE6下的定位
            if (!window.XMLHttpRequest) {
                $backToTopEle.css("top", st + winh - 166);    
            }
        };

        $(window).bind("scroll", $backToTopFun);
        $(function() { $backToTopFun(); });
        $(".gotoTop, .gotoComment").hover(function() {
            $(this).addClass("normal_opacity");
        }, function() {
            $(this).removeClass("normal_opacity");
        });

        $("#sidebar_ad").autoFloat(30);
});

