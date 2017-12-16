<?php
  $bc = isset($_SESSION['bc']) && $_SESSION['bc'] > 0 ? (int)$_SESSION['bc'] : 0;
  $scripts_file_name = $bc === 1 ? 'scripts.js' : 'scripts-'.$bc.'.js';
?>
<!-- javascripts --> 
<script src="/assets/js/jquery.js"></script> 
<script src="/assets/js/jquery-ui-1.10.4.min.js"></script> 
<!--<script src="js/jquery-1.8.3.min.js"></script> --> 
<!--script type="text/javascript" src="js/jquery-ui-1.9.2.custom.min.js"></script>--> 
<!-- bootstrap --> 
<script src="/assets/js/bootstrap.min.js"></script> 
<!-- nice scroll --> 
<script src="/assets/js/jquery.scrollTo.min.js"></script> 
<script src="/assets/js/jquery.nicescroll.js" type="text/javascript"></script> 

<!-- Datepicker script for all page --> 
<script src="/assets/datetime/datepicker/js/bootstrap-datepicker.js"></script> 
<!-- Timepicker script for all page --> 
<script src="/assets/datetime/timepicker/js/bootstrap-timepicker.js"></script>
<!-- load lazy compression library -->
<script src="/assets/js/lz-string.min.js"></script>

<!--custom script for all page-->
<script src="/assets/js/<?php echo $scripts_file_name ?>"></script>

<!--bootbox plugin--> 
<script src="/assets/js/bootbox.min.js"></script>

<!--load Autocomplete plugin -->
<script src="/assets/js/jauto/jquery.autocomplete.js"></script>
<script src="/assets/js/jauto/jquery-migrate-1.0.0.js"></script>

<!--load graph library -->
<script src="/assets/js/jqplot1.0.9/jquery.jqplot.min.js"></script>
<script src="/assets/js/jqplot1.0.9/plugins/jqplot.barRenderer.js"></script>
<script src="/assets/js/jqplot1.0.9/plugins/jqplot.dateAxisRenderer.js"></script>
<script src="/assets/js/jqplot1.0.9/plugins/jqplot.categoryAxisRenderer.js"></script>
<script src="/assets/js/jqplot1.0.9/plugins/jqplot.pieRenderer.js"></script>
<script src="/assets/js/jqplot1.0.9/plugins/jqplot.pointLabels.js"></script>

<!--load input mask -->
<script src="/assets/js/jquerymask/jquery.inputmask.bundle.js"></script>

<!--load inline editor plugin-->
<script src="/assets/js/jquery.tabledit.min.js"></script>

<!-- load floating thead plugin -->
<script src="/assets/js/jquery.floatThead.min.js"></script>

<!--[if lt IE 9]><script src="/assets/js/jqplot1.0.9/excanvas.js"></script><![endif]-->