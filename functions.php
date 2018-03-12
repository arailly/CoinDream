<?php

require_once('phpQuery-onefile.php');
require_once('twitteroauth-0.7.4/autoload.php');
use Abraham\TwitterOAuth\TwitterOAuth;

//CoinMarketCapにアクセスしてコイン名、シンボル名のマップを取得
function getCoinList()
{
  $url = 'https://coinmarketcap.com';
  $html = file_get_contents($url);
  $dom = phpQuery::newDocument($html);
  $currencyNamesText = $dom['.currency-name']->text();
  // echo $currencyNames->text();
  $currencyNamesList = explode("\n", $currencyNamesText);
  $currencyNamesList = array_filter($currencyNamesList, "strlen");
  $currencyNamesList = array_filter($currencyNamesList, function($value) { return !($value == ' '); });
  $currencyNamesList = array_values($currencyNamesList);

  $symbolNameMap = [];
  foreach ($currencyNamesList as $key => $value) {
    if ($key % 2 == 1) {
      $symbolNameMap[$currencyNamesList[$key-1]] = $value;
    }
  }
  return $symbolNameMap;
}


//渡されたシンボル名に関するツイート数を出力
function countTweet($symbol)
{
  $twiter_keys = parse_ini_file('twitter-keys.ini');
  $ck = $twiter_keys['Consumer_Key'];
  $cs = $twiter_keys['Consumer_Secret'];
  $at = $twiter_keys['Access_Token'];
  $ats = $twiter_keys['Access_Token_Secret'];

  $connection = new TwitterOAuth($ck, $cs, $at, $ats);
  $content = $connection->get("account/verify_credentials");

  $params = array(
    "q" => '$'.$symbol.' $'.strtolower($symbol),
    "count" => 100,
    "since_id" => NULL,
    "max_id" => NULL
  );

  $req = $connection->get("search/tweets", $params);

  // １時間毎のツイート数を出力
  // まず100個のツイートを取得
  // 100個目のツイートが直近１時間以内なら100を出力
  // 100個目のツイートが直近１時間以内でなければ、どのツイートまでが１時間前か調べる
  foreach ($req->statuses as $index => $status) {
    $created_at = new DateTime($status->created_at);
    $now = new Datetime("now");
    $intervalHour = $created_at->diff($now)->format("%h");

    if ($intervalHour > 0) {
      break;
    } elseif ($index === 99) {
      $index += 1;
    }
  }
  return $index;
}

countTweet('OMG');
?>
