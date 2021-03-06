<?php 
  // echo $cur_month;
  // echo $cur_year;
  // dump($cal_months);
  // dump($cal_years);
  // dump($_SESSION);
?>
<div>
 
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist" id="dbContainer">
    <li role="presentation" class="active">
    	<a href="#tSales" aria-controls="tSales" role="tab" data-toggle="tab">Sales</a>
    </li>
    <!--li role="presentation">
    	<a href="#tPurchases" aria-controls="tPurchases" role="tab" data-toggle="tab">Purchases</a>
    </li>
    <li role="presentation">
    	<a href="#tInventory" aria-controls="tInventory" role="tab" data-toggle="tab">Inventory</a>
    </li>
    <li role="presentation">
    	<a href="#tFinance" aria-controls="tFinance" role="tab" data-toggle="tab">Finance</a>
    </li-->
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">

  	<!--markup for Sales Tab-->
    <div role="tabpanel" class="tab-pane active" id="tSales">

    	<div class="row">
    		<div class="col-md-6" id="daySales">
    		  <div class="widgetSec">
            <div class="widgetHeader">Today's Sale</div>
            <div class="widgetContent">
              <table class="table priceTable">
                <tbody>
                  <tr>
                    <td>Cash Sale</td>
                    <td align="right"><div id="ds-cashsale"></div></td>
                  </tr>
                  <tr>
                    <td>Card Sale</td>
                    <td align="right"><div id="ds-cardsale"></div></td>
                  </tr>
                  <tr>
                    <td>Credit Sale</td>
                    <td align="right"><div id="ds-creditsale"></div></td>
                  </tr>
                  <tr>
                    <td><b>Totals</b></td>
                    <td align="right"><b><span id="ds-totals"></span></b></td>
                  </tr>
                  <tr>
                    <td ><b>Sales Return</b></td>
                    <td align="right"><b><span id="ds-returns"></span></b></td>
                  </tr>
                  <tr>
                    <td ><b>Net Sales</b></td>
                    <td align="right"><b><span id="ds-netsale"></span></b></td>
                  </tr>
                  <tr>
                    <td ><b>Cash in hand</b></td>
                    <td align="right"><b><span id="ds-cashinhand"></span></b></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
    		</div>
    		<div class="col-md-6">
          <div class="widgetSec">
            <div class="widgetHeader">Fast Moving Items</div>
            <div class="widgetContent">
              <div class="cumulativeSales"></div>
            </div>
          </div>
    		</div>
    	</div><!--end of Row-1 -->

      <div class="row">
        <div class="col-md-12">
          <div class="widgetSec">
            <div class="widgetHeader">Daywise Sales Summary</div>
            <div class="widgetContent">
              <div class="subHeader">
              <form class="form-inline" id="salesGraphFilter">
                <select class="form-control" id="sgf-month">
                  <?php 
                    foreach($cal_months as $key=>$value):
                      $selected = ((int)$key===(int)$cur_month?'selected':'');
                  ?>
                   <option value="<?php echo $key ?>" <?php echo $selected ?>>
                      <?php echo $value ?>
                   </option>
                  <?php endforeach; ?>
                </select>
                <select class="form-control" id="sgf-year">
                  <?php 
                    foreach($cal_years as $key=>$value): 
                      $selected = ((int)$key==(int)$cur_year?'selected':'');                
                  ?>
                   <option value="<?php echo $key ?>" <?php echo $selected ?>>
                      <?php echo $value ?>
                   </option>
                  <?php endforeach; ?>
                </select>
                <input type="hidden" name="saleMonth" id="saleMonth" value="<?php echo $cur_month ?>" />
                <input type="hidden" name="saleYear" id="saleYear" value="<?php echo $cur_year ?>" />                
                <input class="btn btn-primary" type="button" value="Reload" id="sfGraphReload" name="sfGraphReload" />
               </form>
              </div>
               <div id="salesGraph"></div>              
            </div>
          </div>
        </div>
      </div>






    </div><!--end of Tab -->
    

  	<!--markup for Purchases Tab-->
    <div role="tabpanel" class="tab-pane" id="tPurchases">...</div>
  	
  	<!--markup for Inventory Tab-->    
    <div role="tabpanel" class="tab-pane" id="tInventory">...</div>

  	<!--markup for Finance Tab-->    
    <div role="tabpanel" class="tab-pane" id="tFinance">...</div>
  </div>

</div>