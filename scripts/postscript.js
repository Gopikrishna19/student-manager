$(document).ready(function() {
	// Write Code Here
	$("div[title]").hover(function() {
		var menu = $(this);
		$("body").append("<div id='tooltip'/>");
		$("#tooltip").css({
			'position' : 'absolute',
			'width' : 150,
			'text-align' : 'center',
			'top' : menu.offset().top + 30,
			'margin-left' : menu.offset().left - 75 + menu.outerWidth() / 2,
			'color' : '#fff',
			'background-color' : '#444',
			'border' : '1px solid #DDD',
			'border-radius' : '5px',
			'padding' : '5px'
		});
		$("#tooltip").html(menu.attr("title"));
		menu.removeAttr("title");
	}, function() {
		$(this).attr("title", $("#tooltip").html());
		$("#tooltip").remove();
	});
	// $(document).bind("contextmenu", function (e) { e.preventDefault(); return
	// false; });
	var currentMenu = 0;
	var anime_running = false;
	$(".menu").click(function() {
		var menu = $(this);
		if (menu.data("count") !== currentMenu) {
			if (!anime_running) {
				anime_running = true;
				currentMenu = menu.data("count");
				$("#nav .menu").removeClass("s");
				menu.addClass("s");
				$("#box").fadeOut(500, function() {
					$("#box").html("<h1>" + menu.data("title") + "</h1>");
					$.ajax({
						url : menu.data("page") + ".php",
						success : function(e) {
							$("#box").append(e);
						},
						error : function() {
							$("#box").append("Sorry! 404:Page Not Found");
						},
						complete : function() {
							$("#box").fadeIn(500, function() {
								anime_running = false;
							});
						}
					});
				});
			}
		}
		// further
	});
	$(document).ajaxStart(function() {
		$("body").append("<div id='progress'>Working ...</div>");
		$("#progress").css({
			"left" : $(window).width() / 2
		});
		$("#progress").fadeIn(250);
	});
	$(document).ajaxComplete(function() {
		$("#progress").fadeOut(250, function() {
			$("#progress").remove();
		});
	});
	$(".menu[data-count='" + $("#box").data("default") + "']").click();
	init_page();
	// End Here
});