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
