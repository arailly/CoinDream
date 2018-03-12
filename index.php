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
  </head>
  <body>
    <h1>CoinDream</h1>
    <h2>Coin List</h2>
    <table border="1">
      <tr>
        <th>Symbol</th>
        <th>Coin Name</th>
        <th>Tweets (Last 1 hour)</th>
      </tr>
      <?php foreach (getCoinList() as $key => $value): ?>
        <tr align="center">
          <td><?php echo $key ?></td>
          <td><?php echo $value ?></td>
          <td><button type="submit" name="<?php echo $key ?>" value="<?php echo $key ?>">Search $<?php echo $key ?> on Twitter</td>
        </tr>
      <?php endforeach; ?>
    </table>

  </body>
</html>
