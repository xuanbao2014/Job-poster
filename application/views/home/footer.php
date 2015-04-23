<style type='text/css'>
#w2b-StoTop {
	filter: progid:DXImageTransform.Microsoft.gradient(startColorStr='#99EEEEEE',EndColorStr='#99EEEEEE');
	text-align:center;
	padding:10px;
	position:fixed;
	bottom:10px;
	right:20px;
}
</style>
<script type='text/javascript'>
$(function() {
    $.fn.scrollToTop = function() {
	$(this).hide().removeAttr("href");
	if ($(window).scrollTop() != "0") {
	    $(this).fadeIn("slow")
	}
	var scrollDiv = $(this);
	$(window).scroll(function() {
	    if ($(window).scrollTop() == "0") {
		$(scrollDiv).fadeOut("slow")
	    } else {
		$(scrollDiv).fadeIn("slow")
	    }
	});
	$(this).click(function() {
	    $("html, body").animate({
		scrollTop: 0
	    }, "slow")
	})
    }
});
$(function() {
    $("#w2b-StoTop").scrollToTop();
});
</script>
		<button type="button" class="btn btn-primary" id='w2b-StoTop' style='display:none;'>&nbsp;&nbsp;<span class="glyphicon glyphicon-chevron-up"></span>&nbsp;&nbsp;</button>

		<div class="container" style="margin-top:50px;">
			<!-- FOOTER -->
			  <footer>
				<p>
					&copy; 2014 <?=lang('zhidian_navbar_brand')?> &middot; 
					<a href="mailto:contact@zhidian.us"><?=lang('zhidian_joinus')?></a>
					<a href="/home/disclaimer"><?=lang('zhidian_disclaimer')?></a>
				</p>
			  </footer>
		</div>


<script src="/tools/google_analytics/analytics.js"></script>

	</body>
</html>