<?php 
include('header.php'); 
$left=21;
$service=getPendingTotalWithdrawal($conn,'service');
$totalcharge=$service;
?>
<style>
table,
thead,
tr,
tbody,
th,
td {
text-align: center;
}
</style>
<!-- main menu-->
<?php include('leftpanel.php'); ?>
<!-- / main menu-->
<div class="app-content content container-fluid">
<div class="content-wrapper" style="min-height:590px;">

<div class="content-body">
<div class="row">
<div class="col-xs-12">
<div class="card">
<div class="card-header">
<h4 class="card-title">Pending Withdrawal Statement</h4>
<a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
<div class="heading-elements">
<ul class="list-inline mb-0">
<li><a data-action="collapse"><i class="icon-minus4"></i></a></li>
<li><a data-action="reload"><i class="icon-reload"></i></a></li>
<li><a data-action="expand"><i class="icon-expand2"></i></a></li>
</ul>
</div>
</div>
<div class="card-body collapse in">

<div>&nbsp;</div>
<div class="row d-flex">
<div class="col-xs-12 col-sm-3">
<a href="withdrawal-pending-csv-download.php"><input type="button" value="Excel Download" class="btn" style="background:#009900;color:#FFFFFF; width:100%" /></a>
</div>
<div class="col-xs-12 col-sm-3 ml-auto">
<form name="form3" action="pending-withdrawal.php?act=search" method="post">
<input type="text" name="search" id="search" value="<?=$_REQUEST['search']?>" class="form-control border-primary"style="width:100%;" placeholder="User ID" />
</form>
</div>
</div>
<div>&nbsp;</div>

<div class="table-responsive">

<table width="80%" border="0" cellspacing="0" cellpadding="0" align="center">
<tr height="30" style="font-size:16px;color:#4378A3;">
<td width="23%" align="right" valign="middle"><strong style="font-size:14px;">&nbsp;&nbsp;Total_Request_Amount&nbsp;:&nbsp;</strong></td>
<td width="9%" align="left" valign="middle" style="font-size:14px;"><?=getPendingTotalWithdrawal($conn,'request')?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td width="24%" align="right" valign="middle"><strong style="font-size:14px;">Total_Charge&nbsp;:&nbsp;</strong></td>
<td width="10%" align="left" valign="middle" style="font-size:14px;"><?=$totalcharge?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td width="22%" align="right" valign="middle"><strong style="font-size:14px;">Total_Payout&nbsp;:&nbsp;</strong></td>
<td width="12%" align="left" valign="middle" style="font-size:14px;"><?=getPendingTotalWithdrawal($conn,'payout')?></td>
</tr>
</table>

<div>&nbsp;</div>
<table class="table table-bordered table-striped" align="center" >
<thead class="bg-teal bg-lighten-4" align="center">
<tr>
<th width="5%" align="center">Sl_No</th>
<th width="6%" align="center">User_ID</th>
<th width="6%" align="center">Name</th>


<th width="7%" align="center">Request</th>
<th width="9%" align="center">Service</th>
<th width="6%" align="center">Payout</th>
<th width="8%" align="center">Bank</th>
<th width="8%" align="center">Account_Name</th>
<th width="8%" align="center">Account_No</th>
<th width="8%" align="center">IFSC_Code</th>
<th width="8%" align="center">UPI_ID</th>
<th width="9%" align="center">Status</th>
<th width="5%" align="center">Date</th>
<th width="6%" align="center">Action</th>
</tr>
</thead>
<tbody>
<?php
$tname='ee_withdrawal';
$lim=100;
$tpage='pending-withdrawal.php';
if($_REQUEST['act']=='search')
{
$where="WHERE `userid` LIKE '".trim(mysqli_real_escape_string($conn,$_POST['search']))."' AND `status`='P' ORDER BY `id` DESC";
}else{
$where="WHERE `status`='P' ORDER BY `id` DESC";
}
include('pagination.php');
$num=numrows($result);
$i=1;
if($num>0)
{
while($fetch=fetcharray($result))
{
?>
<tr height="30">
<td align="center" class="tborder" style="padding:5px;"><?=$i?></td>
<td align="center" class="tborder" style="padding:5px;"><?=$fetch['userid']?></td>
<td align="center" class="tborder" style="padding:5px;"><?=ucwords(getMemberUserid($conn,$fetch['userid'],'name'))?></td>


<td align="center" class="tborder" style="padding:5px;"><?=$fetch['request']?></td>
<td align="center" class="tborder" style="padding:5px;"><?=$fetch['service']?></td>
<td align="center" class="tborder" style="padding:5px;"><?=$fetch['payout']?></td>
<td align="center" class="tborder" style="padding:5px;"><?=$fetch['bname']?></td>
<td align="center" class="tborder" style="padding:5px;"><?=$fetch['accname']?></td>
<td align="center" class="tborder" style="padding:5px;"><?=$fetch['accno']?></td>
<td align="center" class="tborder" style="padding:5px;"><?=$fetch['ifscode']?></td>
<td align="center" class="tborder" style="padding:5px;"><?=$fetch['upiid']?></td>

<td align="center" class="tborder" style="padding:5px;"><?php if($fetch['status']=='P'){?><a href="withdrawal-process.php?case=status&id=<?=$fetch['id']?>&page=<?=$_REQUEST['page']?>" onClick="return confirm('Are you sure want to active this status?');" style="text-decoration:none;"><span style="color:#FF0000;">Pending</span></a><?php } ?></td>
<td align="center" class="tborder" style="padding:5px;"><?=getDateConvert($fetch['date'])?></td>
<td ><a href="withdrawal-process.php?case=delete&id=<?=$fetch['id']?>&page=<?=$_REQUEST['page']?>" style="text-decoration:none;" onClick="return confirm('Are you sure want to delete?');"><img src="images/delete.png" title="Delete" /></a></td>
</tr>
<?php $i++;}}else{?>
<tr height="14"><td align="center" colspan="14" style="color:#FF0000;"><div class="norecord">No Record Found!</div></td></tr>
<?php }?>
</tbody>
</table>

<?php if($_REQUEST['act']==''){?>
<div align="center"><?=$pagination?></div>
<?php } ?>
</div>
</div>
</div>
</div>
</div>
<div class="col-md-3">&nbsp;</div>
</div>
</div>
</div>
</div>
<?php include('footer.php') ?>

<!-- BEGIN VENDOR JS-->
<script src="app-assets/js/core/libraries/jquery.min.js" type="text/javascript"></script>
<script src="app-assets/vendors/js/ui/tether.min.js" type="text/javascript"></script>
<script src="app-assets/js/core/libraries/bootstrap.min.js" type="text/javascript"></script>
<script src="app-assets/vendors/js/ui/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
<script src="app-assets/vendors/js/ui/unison.min.js" type="text/javascript"></script>
<script src="app-assets/vendors/js/ui/blockUI.min.js" type="text/javascript"></script>
<script src="app-assets/vendors/js/ui/jquery.matchHeight-min.js" type="text/javascript"></script>
<script src="app-assets/vendors/js/ui/screenfull.min.js" type="text/javascript"></script>
<script src="app-assets/vendors/js/extensions/pace.min.js" type="text/javascript"></script>
<!-- BEGIN VENDOR JS-->
<script src="app-assets/js/core/app-menu.js" type="text/javascript"></script>
<script src="app-assets/js/core/app.js" type="text/javascript"></script>
<!-- END ROBUST JS-->
</body>
</html>