<!--
トップページ

コイン名をクリックすると、１時間あたりの＄（コイン名）を含むツイート数を表示
それによって、そのコインについてつぶやく人がどれだけいるか把握

-->
<?php require_once('functions.php'); ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>CoinDream</title>
    <link rel="stylesheet" href="styles.css" type="text/css">
  </head>
  <body>
    <h1>CoinDream</h1>
    <div class="showTweets">
    <br><br>
    <?php
      if (isset($_GET['q'])) {
        $symbol = $_GET['q'];
        $tweets = countTweet($symbol);
        if ($tweets < 100) {
          echo '$'."$symbol: $tweets Tweets for an hour";
        } else {
          echo '$'."$symbol: more than 100 Tweets for an hour";
        }
      }
    ?>
    </div>
    <div class="tables">
      <div class="coinTable">
      <h2>Coin List</h2>
        <table border="1">
          <tr>
            <th>Symbol</th>
            <th>Coin Name</th>
            <th>Search Tweets</th>
          </tr>
          <?php foreach (getCoinList() as $key => $value): ?>
            <tr align="center">
              <td><?php echo $key ?></td>
              <td><?php echo $value ?></td>
              <td>
                <form class="" action="" method="get">
                  <button class="searchButton" type="submit" name="q" value="<?php echo $key ?>">Search $<?php echo $key ?> on Twitter
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </table>
      </div>
      <div class="symbolForm">
        <h2>Input Symbol</h2>
        <form class="" action="" method="get">
          $<input type="text" name="q" value="">
          <input type="submit" name="" value="Search on Twitter">
        </form>
      </div>
    </div>
  </body>
</html>
