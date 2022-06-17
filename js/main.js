function blankSearch(){
    // 검색창 내용 유무. '영화제목'과 '관람일' 모두 비어있을 경우 검색 불가.
    var title = document.forms["search"]["movie_title"].value;
    var date = document.forms["search"]["s_date"].value;

    if(title=="" && date==""){
        return false;
    }
    else if(title!="" && date!=""){
        var s = "schedule.php?date="+date;
        document.formform.action = s;
    }
    return true;
}

function blankSignUp(){
    // 회원가입 정보 입력 체크.
    var fill = document.forms["signup"];
    for (var i = 0; i < fill.length-1; i++){
        if(fill[i].value == ""){
            alert("모든 내용을 입력해주세요.");
            return false;
        }
    }
    return true;
}

function check(event){
    // 마이페이지 예매내역 및 취소내역 테이블 교체.
    var tops = document.getElementsByClassName("myList");
    for(var i=0; i<tops.length; i++){
        if(tops[i].classList[2] == "clicked"){
            tops[i].classList.remove("clicked");
        }
    }
    event.target.classList.add("clicked");

    var book = document.getElementsByClassName("book content");
    var watch = document.getElementsByClassName("watch content");
    var cancel = document.getElementsByClassName("cancel content");
    if(event.target.classList[1] == "cancel"){  // '취소 내역' 탭 클릭 시,
        for(var i=0; i<book.length; i++){
            book[i].style.display = "none";
        }
        for(var i=0; i<watch.length; i++){
            watch[i].style.display = "none";
        }
        for(var i=0; i<cancel.length; i++){
            document.getElementsByClassName("bookingL3")[0].style.display = "block";
            cancel[i].style.display = "block";
        }
    }
    else if(event.target.classList[1] == "book"){
        for(var i=0; i<cancel.length; i++){  // '예매 내역' 탭 클릭 시,
            cancel[i].style.display = "none";
        }
        for(var i=0; i<watch.length; i++){
            watch[i].style.display = "none";
        }
        for(var i=0; i<book.length; i++){
            document.getElementsByClassName("bookingL")[0].style.display = "block";
            book[i].style.display = "block";
        }

    }
    else{   // event.target.classList[1] == "watch"
        for(var i=0; i<cancel.length; i++){  // '지난 관람 내역' 탭 클릭 시,
            cancel[i].style.display = "none";
        }
        for(var i=0; i<book.length; i++){
            book[i].style.display = "none";
        }
        for(var i=0; i<watch.length; i++){
            document.getElementsByClassName("bookingL2")[0].style.display = "block";
            watch[i].style.display = "block";
        }
    }

}

function show(tNumber){
    // schedule.php 
    // 각 상영관 탭 클릭 시 스케줄 리스트 출력 및 탭 background color 바꾸기.
    var t = document.getElementsByClassName("t");
    var div = document.getElementsByClassName("schedule");
    for(var i=1; i<6; i++){
        if("t"+i.toString()==tNumber){
            t[i-1].style.backgroundColor = "lightgrey";
            div[i-1].style.display = "block";
        }
        else{
            t[i-1].style.backgroundColor = "white";
            div[i-1].style.display = "none";
        }
    }
}

function dateChange(event){
    var date = event.target;
    var dates = document.getElementsByClassName("date");
    for(var i=0; i<dates.length; i++){
        dates[i].classList.remove("clicked");
    }
    date.classList.add("clicked");
}
