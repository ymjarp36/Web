<html>
<head>
    <style>
        table, td, th {
            border: 1px solid black;
            border-collapse: collapse;
            cursor: pointer;
        }
        .no-border-table, .no-border-table td {
            border: none;
        }
    </style>
</head>
<body>

<?php
session_start();
if (!isset($_SESSION['ssID'])) {
    header('Location: project_01.php'); // 로그인 안 한 경우 로그인 페이지로
    exit();
}

$conn = mysqli_connect('localhost', 'root', '', 'sample01_db');
$sID = $_SESSION['ssID'];

// 도서 기록 추가
if (isset($_POST['bookName']) && isset($_POST['bookReview'])) {
    $bookName = $_POST['bookName'];
    $bookReview = $_POST['bookReview'];

    $qry = "INSERT INTO book_records (sID, bookName, bookReview, recordDate) 
            VALUES ('$sID', '$bookName', '$bookReview', NOW())";
    mysqli_query($conn, $qry);
}

// 읽고 싶은 도서 추가
if (isset($_POST['wishlistName'])) {
    $wishlistName = $_POST['wishlistName'];

    $qry = "INSERT INTO wishlist (sID, bookName, addedDate) 
            VALUES ('$sID', '$wishlistName', NOW())";
    mysqli_query($conn, $qry);
}

// 최근 3개의 도서 기록 조회
$qry = "SELECT * FROM book_records WHERE sID='$sID' ORDER BY recordDate DESC LIMIT 3";
$result = mysqli_query($conn, $qry);

// 읽고 싶은 도서 조회
$wishlistQry = "SELECT * FROM wishlist WHERE sID='$sID' ORDER BY addedDate DESC";
$wishlistResult = mysqli_query($conn, $wishlistQry);
?>

<center>
<table class="no-border-table">
    <tr>
        <!-- 읽은 도서 기록 관리 -->
        <td>
            <h3>읽은 도서 기록 관리</h3>
            <form method="post" action="project_02.php">
                <table>
                    <tr><td align='right'>도서명: <input type="text" name="bookName" required></td></tr>
                    <tr><td align='right'>리뷰: <input type="text" name="bookReview" required></td></tr>
                </table>
                <input type="submit" value="기록 추가">
            </form>
        </td>
        <td>&nbsp&nbsp&nbsp</td>
        <!-- 읽고 싶은 도서 추가 -->
        <td>
            <h3>읽고 싶은 도서 추가</h3>
            <form method="post" action="project_02.php">
                <table>
                    <tr><td align='right'>도서명: <input type="text" name="wishlistName" required></td></tr>
                </table>
                <input type="submit" value="추가">
            </form>
        </td>
    </tr>
</table><br>
<hr>
<h3>최근 3개의 도서 기록</h3>
<table border="1">
	<tr>
		<th>도서명</th>
		<th>리뷰</th>
		<th>작성일</th>
	</tr>
	<?php while ($row = mysqli_fetch_assoc($result)) { ?>
	<tr>
		<td><?php echo $row['bookName']; ?></td>
		<td><?php echo $row['bookReview']; ?></td>
		<td><?php echo $row['recordDate']; ?></td>
	</tr>
	<?php } ?>
</table>       
<h3>읽고 싶은 도서 목록</h3>
<table border="1">
	<tr>
		<th>도서명</th>
		<th>추가 날짜</th>
	</tr>
	<?php while ($row = mysqli_fetch_assoc($wishlistResult)) { ?>
	<tr>
		<td><?php echo $row['bookName']; ?></td>
		<td><?php echo $row['addedDate']; ?></td>
	</tr>
	<?php } ?>
</table>
  
<br>

<!-- 버튼 영역 -->
<form action="project_03.php" method="get" style="display:inline;">
    <button type="submit">전체 도서 기록 보기</button>
</form>
<form action="project_01.php" method="get" style="display:inline;">
    <input type="hidden" name="logout" value="1">
    <button type="submit">로그아웃</button>
</form>
</center>

</body>
</html>

<?php
// 로그아웃 처리
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: project_01.php');
}
?>
