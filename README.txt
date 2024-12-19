웹 응용 프로젝트 계획서
컴퓨터공학과 202268032 윤미진

주제 : 도서 기록 관리 시스템
(사용자가 자신이 읽은 도서에 대해 기록하는 시스템)
▶ project_01.php
  - 사용자 로그인
▶ project_02.php
  - 사용자가 읽은 도서에 대해 도서명과 리뷰를 남김
  - 사용자가 읽고 싶은 도서명을 추가함
  - 최근 3개의 도서 기록을 보여줌
  - 읽고 싶은 도서의 목록을 보여줌
  - 전체 도서 기록보기 -> project_03.php 이동
▶ project_03.php
  - 사용자가 읽은 도서에 대해 남긴 기록의 전체 기록을 보여줌
  - 사용자가 읽은 도서에 대해 남긴 기록(도서명, 리뷰)을 수정&삭제가 가능하도록 함
▶ 필요 DataBase
  CREATE TABLE book_records (	
  id INT AUTO_INCREMENT PRIMARY KEY,	
  sID VARCHAR(50) NOT NULL,	
  bookName VARCHAR(100) NOT NULL,	
  bookReview VARCHAR(255) NOT NULL,	
  recordDate DATETIME NOT NULL
  );
  //따로 사용자 데이터 입력해야함
  CREATE TABLE member_tbl (	
  sID VARCHAR(10) PRIMARY KEY,
  sPw VARCHAR(10) NOT NULL
  );
  CREATE TABLE wishlist (
  id INT AUTO_INCREMENT PRIMARY KEY,
  sID VARCHAR(50),
  bookName VARCHAR(255),
  addedDate DATETIME
  );

▶ 추가할 기능 및 더 보완할 점
  - 사용자가 읽은 책들을 검색할 수 있도록 하는 기능-project_03.php
  - 책들의 카테고리를 지정해 지정한 카테고리별로 볼 수 있게 하는 기능-project_03.php
  - 사용자가 리뷰룰 작성 시 도서별 평점을 부여하도록 하는 기능-project_02.php
  - 독서 활동의 통계를 시각화하는 기능-project_03.php
  - 사용자 회원가입 화면 추가-project_01.php
▶ 현 구현한 기능
  - 사용자 로그인
  - 사용자가 읽은 도서에 대한 기록
  - 읽은 도서가 아닌 읽고 싶은 도서명 추가 기능
  - 최근 3개의 도서 기록
  - 읽고 싶은 도서 목록
  - 전체 도서 기록
  - 읽은 도서 기록 수정 및 삭제 기능
