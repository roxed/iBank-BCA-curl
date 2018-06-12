<?php
/**
 * @author     cv.roxedltd <info@roxedltd.co.id>
 * @copyright  2018 roxedltd
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @version    0.1
 * AVAILABLE METHOD
 * get balance
 * get transaction
 * get debet
 * get credit
 * 
 * USED:
 * - http://domain.com/index.php?balance
 * - http://domain.com/index.php?transaction&from=yyyy-mm-dd&to=yyyy-mm-dd
 * - http://domain.com/index.php?debet&from=yyyy-mm-dd&to=yyyy-mm-dd
 * - http://domain.com/index.php?credit&from=yyyy-mm-dd&to=yyyy-mm-dd
 * 
 * change yyyy-mm-dd with date value. eg: 2018-06-13
 */
date_default_timezone_set('Asia/Jakarta');
require( 'BCAParser.php' );
header('Content-Type: application/json');
$username = "username bca";
$password = "password bca";
$Parser = new BCAParser($username,$password);

if (isset($_GET["balance"])) {
  $res = [];
  $balance = $Parser->getBalance();
  if ( !$balance ){
    $res['result'] = false;
    $res['err'] = 'Failed get transaction';
  } else {
    $res['result'] = true;
    $res['saldo'] = number_format($balance,0,'','');
  }
  echo json_encode($res);
} else if (isset($_GET["transaction"]) && isset($_GET["from"]) && isset($_GET["to"])){
  $output = $Parser->getListTransaksi($_GET["from"], $_GET["to"]);
  if ($output != null && count($output) > 0){
    echo json_encode($output);
  }
    echo json_encode("Failed. Transaction to date " .$_GET["to"]. " not found. please change to=");
} else if (isset($_GET["debet"]) && isset($_GET["from"]) && isset($_GET["to"])){
  $output = $Parser->getTransaksiDebit($_GET["from"], $_GET["to"]);
  if ($output != null && count($output) > 0){
    echo json_encode($output);
  }
    echo json_encode("Failed. Transaction to date " .$_GET["to"]. " not found. please change to=");
} else if (isset($_GET["credit"]) && isset($_GET["from"]) && isset($_GET["to"])){
  $output = $Parser->getTransaksiCredit($_GET["from"], $_GET["to"]);
  if ($output != null && count($output) > 0){
    echo json_encode($output);
  }
    echo json_encode("Failed. Transaction to date " .$_GET["to"]. " not found. please change to=");
} else{
  $res['result'] = false;
  $res['err'] = 'Available method: ?balance ?transaction&from=...&to=... ?debet&from=...&to=.. ?credit&from=...&to=..';
  echo json_encode($res);
}
// logout handle
$Parser->logout();

