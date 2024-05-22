<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="comment.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<?php
  // 資料庫連線細節（請使用您的實際認證）
  $servername = "localhost";
  $username = "root";
  $password = "2002";
  $dbname = "comment";

  // 建立連線
  $conn = new mysqli($servername, $username, $password, $dbname);

  // 檢查連線
  if ($conn->connect_error) {
    die("連線失敗：" . $conn->connect_error);
  }

  // SQL 查詢以獲取假數據（有限 - 考慮使用專門的工具來獲取更真實的數據）
  $sql = "SELECT 
    FLOOR(RAND() * 5) + 1 AS rating, 
    FLOOR(RAND() * 100) + 1 AS count 
  FROM 
    (SELECT 1 AS dummy) AS dummy_table
  GROUP BY 
    rating
  ORDER BY 
    rating DESC;";

  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $reviews = array();
    while($row = $result->fetch_assoc()) {
      $reviews[] = array(
        'stars' => $row["rating"],
        'count' => $row["count"],
      );
    }
  } else {
    echo "找不到數據";
  }
  $conn->close();

  // 根據檢索到的數據計算平均評分（如果需要，請替換您的邏輯）
  $totalReviews = 0;
  $totalRating = 0;
  foreach ($reviews as $review) {
    $totalReviews += $review['count'];
    $totalRating += $review['stars'] * $review['count'];
  }
  $averageRating = $totalReviews > 0 ? round($totalRating / $totalReviews, 1) : 0;
?>

  <div class="heading">使用者評分</div>
  <span class="fa fa-star checked"></span>
  <span class="fa fa-star checked"></span>
  <span class="fa fa-star checked"></span>
  <span class="fa fa-star checked"></span>
  <span class="fa fa-star"></span>
  <p><?php echo $averageRating; ?> 平均分，基於 <?php echo $totalReviews; ?> 則評論。</p>
  <hr style="border:3px solid #fffceb">

  <div class="row">
    <?php foreach ($reviews as $review): ?>
      <div class="side">
        <div><?php echo $review['stars']; ?> 星</div>
      </div>
      <div class="middle">
        <div class="bar-container">
          <div class="bar-<?php echo $review['stars']; ?>"></div>
        </div>
      </div>
      <div class="side right">
        <div><?php echo $review['count']; ?></div>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="comment-section">
    <h2>留言</h2>
    <form class="comment-form">
      <textarea name="comment" id="comment" placeholder="請輸入您的評論"></textarea>
      <button type="submit">提交</button>
    </form>
    <h3>評論</h3>
    <ul class="comment-list">
      <li class="comment-item">
        <div class="user-info">
          <img src="user-avatar.jpg" class="fa fa-solid fa-user" alt="用戶頭像">
          <div class="name-date">
            <p class="name">John Doe</p>
            <p class="date">2022年5月15日</p>
          </div>
        </div>
        <p class="comment">這是一個很棒的產品！我強烈推薦給任何人。</p>
      </li>
    </ul>
  </div>

</body>
</html>
