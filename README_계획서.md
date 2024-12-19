웹 응용 프로젝트 계획서
컴퓨터공학과 202268032 윤미진

주제 : 도서 기록 관리 시스템
(사용자가 자신이 읽은 도서에 대해 기록하는 시스템)

● project_01.php- 사용자 로그인
● project_02.php- 사용자가 읽은 도서에 대해 도서명과 리뷰를 남김- 사용자가 읽고 싶은 도서명을 추가함- 최근 3개의 도서 기록을 보여줌- 읽고 싶은 도서의 목록을 보여줌- 전체 도서 기록보기 -> project_03.php 이동
● project_03.php- 사용자가 읽은 도서에 대해 남긴 기록의 전체 기록을 보여줌- 사용자가 읽은 도서에 대해 남긴 기록(도서명, 리뷰)을 수정&삭제가 가능하도록 함
● DataBase
  CREATE TABLE book_records (	id INT AUTO_INCREMENT PRIMARY KEY,	sID VARCHAR(50) NOT NULL,	bookName VARCHAR(100) NOT NULL,bookReview VARCHAR(255) NOT NULL,	recordDate DATETIME NOT NULL);
  //따로 사용자 데이터 입력해야함
  CREATE TABLE member_tbl (	sID VARCHAR(10) PRIMARY KEY,	sPw VARCHAR(10) NOT NULL);
  CREATE TABLE wishlist (	id INT AUTO_INCREMENT PRIMARY KEY,	sID VARCHAR(50),	bookName VARCHAR(255),	addedDate DATETIME);
● 추가할 기능 및 더 보완할 점
  - 사용자가 읽은 책들을 검색할 수 있도록 하는 기능-project_03.php
  - 책들의 카테고리를 지정해 지정한 카테고리별로 볼 수 있게 하는 기능-project_03.php
  - 사용자가 리뷰룰 작성 시 도서별 평점을 부여하도록 하는 기능-project_02.php
  - 독서 활동의 통계를 시각화하는 기능-project_03.php
  - 사용자 회원가입 화면 추가-project_01.php
● 현 구현한 기능
- 사용자 로그인
- 사용자가 읽은 도서에 대한 기록
- 읽은 도서가 아닌 읽고 싶은 도서명 추가 기능
- 최근 3개의 도서 기록- 읽고 싶은 도서 목록
- 전체 도서 기록
- 읽은 도서 기록 수정 및 삭제 기능
project_01.php
<html><head></head>
<style>
table, td, th {
	border : 1px solid black;
	border-collapse : collapse;
	cursor: pointer;
}
</style>
<body>
<?php
session_start(); // 세션 시작
$conn = mysqli_connect('localhost', 'root', '', 'sample01_db');

if (isset($_POST['sID']) && isset($_POST['sPw'])) {
    $sID = $_POST['sID'];
    $sPw = $_POST['sPw'];

    // 사용자 확인
    $qry = "SELECT * FROM member_tbl WHERE sID='$sID' AND sPw='$sPw'";
    $result = mysqli_query($conn, $qry);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['ssID'] = $sID; // 세션에 아이디 저장
        header('Location: project_02.php'); // 다음 페이지로 이동
    } else {
        echo "<script>alert('로그인 실패. 아이디와 비밀번호를 확인해주세요.');</script>";
    }
}
?>
<center>
<br><h2> 도서 기록 관리 시스템</h2>
<h3>Log In</h3>
	<form action="project_01.php" method="post" id="frmMain">
	<table>
		<tr><td align='right'>아이디: </td><td><input type="text" name="sID"/></td></tr><br>
		<tr><td align='right'>비밀번호: </td><td><input type="password" name="sPw"/></td></tr><br>
	</table>
	<input type="submit" value="로그인">
	</form>
</body>
</html>

  
project_02.php
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

  
project_03.php
<?php
session_start();
if (!isset($_SESSION['ssID'])) {
    header('Location: project_01.php');
    exit();
}
$conn = mysqli_connect('localhost', 'root', '', 'sample01_db');
$sID = $_SESSION['ssID'];
// 삭제 기능
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM book_records WHERE id='$id' AND sID='$sID'");
}
// 수정 기능
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $bookName = $_POST['bookName'];
    $bookReview = $_POST['bookReview'];
    $qry = "UPDATE book_records SET bookName='$bookName', bookReview='$bookReview' WHERE id='$id' AND sID='$sID'";
    mysqli_query($conn, $qry);
}
// 전체 도서 기록 조회
$qry = "SELECT * FROM book_records WHERE sID='$sID' ORDER BY recordDate DESC";
$result = mysqli_query($conn, $qry);
?>
<html>
<body>
<center>
    <h3>전체 도서 기록</h3>
    <table border="1">
        <tr>
            <th>도서명</th>
            <th>리뷰</th>
            <th>작성일</th>
            <th>수정</th>
            <th>삭제</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <form method="post" action="project_03.php">
                <td><input type="text" name="bookName" value="<?php echo $row['bookName']; ?>"></td>
                <td><input type="text" name="bookReview" value="<?php echo $row['bookReview']; ?>"></td>
                <td><?php echo $row['recordDate']; ?></td>
                <td>
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <button type="submit" name="update">수정</button>
                </td>
            </form>
            <td>
                <a href="project_03.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('정말 삭제하시겠습니까?');">삭제</a>
            </td>
        </tr>
        <?php } ?>
    </table>
    <br>
    <form action="project_02.php" method="get" style="display:inline;">
        <button type="submit">뒤로 가기</button>
    </form>
    <form action="project_01.php" method="get" style="display:inline;">
        <input type="hidden" name="logout" value="1">
        <button type="submit">로그아웃</button>
    </form>
</body>
</html>
