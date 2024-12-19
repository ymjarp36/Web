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
