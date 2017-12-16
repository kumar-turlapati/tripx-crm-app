<?php
  use Atawa\Utilities;
  use Atawa\Constants;
  
  $current_date = date("d-m-Y");

  // dump($search_params);

  $query_params = '';
  if(isset($search_params['startDate']) && $search_params['startDate'] !='') {
    $startDate = $search_params['startDate'];
    $query_params[] = 'startDate='.$startDate;
  } else {
    $startDate = $current_date;
  }
  if(isset($search_params['endDate']) && $search_params['endDate'] !='' ) {
    $endDate = $search_params['endDate'];
    $query_params[] = 'endDate='.$endDate;
  } else {
    $endDate = $current_date;
  }
  if(isset($search_params['offerType']) && $search_params['offerType'] !== '' ) {
    $offerType = $search_params['offerType'];
    $query_params[] = 'offerType='.$offerType;
  } else {
    $offerType = '';
  }

  if(is_array($query_params) && count($query_params)>0) {
    $query_params = '?'.implode('&', $query_params);
  }

  $page_url = '/promo-offers/list';
?>

<!-- Basic form starts -->
<div class="row">
  <div class="col-lg-12">
    <!-- Panel starts -->
    <section class="panelBox">
      <h2 class="hdg-reports text-center">List Offers</h2>
      <div class="panelBody">

        <?php echo Utilities::print_flash_message() ?>

        <?php if($page_error !== ''): ?>
          <div class="alert alert-danger" role="alert">
            <strong>Error!</strong> <?php echo $page_error ?> 
          </div>
        <?php endif; ?>

        <!-- Right links starts -->
        <div class="global-links actionButtons clearfix">
          <div class="pull-right text-right">
            <a href="/promo-offers/entry" class="btn btn-default">
              <i class="fa fa-file-text-o"></i> New Promo Offer 
            </a> 
          </div>
        </div>
  		  <div class="filters-block">
    		  <div id="filters-form">
            <!-- Form starts -->
            <form class="form-validate form-horizontal" method="POST">
              <div class="form-group">
                <div class="col-sm-12 col-md-1 col-lg-1">Filter by</div>
                <div class="col-sm-12 col-md-2 col-lg-2">
                  <div class="input-append date" data-date="<?php echo $current_date ?>" data-date-format="dd-mm-yyyy">
                    <input class="span2" size="16" type="text" readonly name="startDate" id="startDate" value="<?php echo $startDate ?>" />
                    <span class="add-on"><i class="fa fa-calendar"></i></span>
                  </div>
                </div>
                <div class="col-sm-12 col-md-2 col-lg-2">
                  <div class="input-append date" data-date="<?php echo $current_date ?>" data-date-format="dd-mm-yyyy">
                    <input class="span2" size="16" type="text" readonly name="endDate" id="endDate" value="<?php echo $endDate ?>" />
                    <span class="add-on"><i class="fa fa-calendar"></i></span>
                  </div>
                </div>
                <div class="col-sm-12 col-md-2 col-lg-2">
                  <div class="select-wrap">
                    <select class="form-control" name="offerType" id="offerType">
                      <?php 
                        foreach($offer_types as $key=>$value): 
                          if($offer_type === $key) {
                            $selected = 'selected="selected"';
                          } else {
                            $selected = '';
                          }                      
                      ?>
                        <option value="<?php echo $key ?>" <?php echo $selected ?>><?php echo $value ?></option>
                      <?php endforeach; ?>
                    </select>
                   </div>
                </div>
                <?php include_once __DIR__."/../../../Layout/helpers/filter-buttons.helper.php" ?>
            </div>
           </form>        
          <!-- Form ends -->
			    </div>
        </div>
        <div class="table-responsive">
          <?php if(count($offers)>0): ?>
           <table class="table table-striped table-hover">
            <thead>
              <tr class="font12">
                <th width="5%" class="text-center">Sno</th>
                <th width="20%" class="text-center">Offer name</th>
                <th width="40%" class="text-center">Offer type</th>                
                <th width="8%" class="text-center">Start Date</th>
                <th width="8%" class="text-center">End Date</span></th>
                <th width="8%" class="text-center">Status</span></th>                
                <th width="8%" class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                $cntr = $sl_no;
                $total = 0;
                foreach($offers as $offer_details):
                  $offer_name = $offer_details['offerName'];
                  $offer_code = $offer_details['promoCode'];
                  $offer_type = Constants::$PROMO_OFFER_CATEGORIES_DIGITS[$offer_details['promoType']];
                  $start_date = date('d-M-Y', strtotime($offer_details['startDate']));
                  $end_date = date('d-M-Y', strtotime($offer_details['endDate']));
                  $status = Constants::$RECORD_STATUS[$offer_details['status']];
              ?>
                <tr class="font12">
                  <td align="right"><?php echo $cntr ?></td>
                  <td align="left"><?php echo $offer_name ?></td>
                  <td align="left"><?php echo $offer_type ?></td>
                  <td align="center"><?php echo $start_date ?></td>
                  <td align="center"><?php echo $end_date ?></td>
                  <td align="center"><?php echo $status ?></td>      
                  <td>
                  <?php if($offer_code !== ''): ?>
                    <div class="btn-actions-group" align="right">                    
                      <a class="btn btn-primary" href="/promo-offers/update/<?php echo $offer_code ?>" title="Edit Promotional Offer">
                        <i class="fa fa-pencil"></i>
                      </a>
                    </div>
                  <?php endif; ?>
                  </td>
                </tr>
            <?php
              $cntr++;
              endforeach; 
            ?>
            </tbody>
          </table>
          <?php endif; ?>
          <?php include_once __DIR__."/../../../Layout/helpers/pagination.helper.php" ?>
        </div>
      </div>
    </section>
    <!-- Panel ends -->
  </div>
</div>