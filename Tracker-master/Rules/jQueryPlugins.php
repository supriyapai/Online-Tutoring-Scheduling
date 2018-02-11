<script type="text/javascript" src="../Jquery/js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="../Jquery/js/jquery-ui-1.8.18.custom.min.js"></script>
<script type="text/javascript" src="Jquery/js/jquery.maskedinput-1.3.js"></script>
<link type="text/css" href="../Jquery/css/jquery-ui-1.8.18.custom.css" rel="Stylesheet" />

    <script>
	$(function() {
		$( ".datepicker" ).datepicker(); //enddate; selecting past date disabled -> $( ".datepicker" ).datepicker({minDate: 0, });
	});
    </script>
        
    <script>
	$(function() {
	    	$( "input:submit,a" ).button();
	});
    </script> 

<div class="demo">

<?php //<p><input type="text" name="date" id="datepicker2"></p> ?>


</div><!-- End demo -->



<div class="demo-description" style="display: none; ">
<p>The datepicker is tied to a standard form input field.  Focus on the input (click, or use the tab key) to open an interactive calendar in a small overlay.  Choose a date, click elsewhere on the page (blur the input), or hit the Esc key to close. If a date is chosen, feedback is shown as the input's value.</p>
</div><!-- End demo-description -->

<!--SELECT MENU-->
<link type="text/css" href="../css/jquery.ui.selectmenu.css" rel="stylesheet" />
<script type="text/javascript" src="../Jquery/js/jquery.ui.selectmenu.js"></script>
