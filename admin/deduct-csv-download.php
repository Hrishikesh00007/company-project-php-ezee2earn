<?php
include('includes/function.php');

$rand=rand(11111,99999);

$arr=array();
$arr[0][0]="Sl_No";
$arr[0][1]="User_ID";
$arr[0][2]="Name";
$arr[0][3]="Wallet";
$arr[0][4]="Amount";
$arr[0][5]="Remarks";
$arr[0][6]="Date";


$sqlm="SELECT * FROM `ee_deduct` ORDER BY `id` DESC";
$resm=query($conn,$sqlm);
$numm=numrows($resm);
if($numm>0)
{
$i=1;
while($fetchm=fetcharray($resm))
{

$arr[$i][0]=$i;
$arr[$i][1]=$fetchm['userid'];
$arr[$i][2]=ucwords(getMemberUserid($conn,$fetchm['userid'],'name'));
$arr[$i][3]=$fetchm['wallet'];
$arr[$i][4]=$fetchm['amount'];
$arr[$i][5]=$fetchm['remarks'];
$arr[$i][6]=$fetchm['date'];
$i++;
}}

$name='Deduct-Statement-'.date('Y-m-d');

$fp = fopen('csvfile/'.$name.'.csv', 'w');

foreach ($arr as $fields) {
fputcsv($fp, $fields);
}

fclose($fp);
redirect('download3.php?f='.$name.'.csv');