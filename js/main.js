function blankSearch(){
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
    var fill = document.forms["signup"];
    for (var i = 0; i < fill.length-1; i++){
        if(fill[i].value == ""){
            alert("모든 내용을 입력해주세요.");
            return false;
        }
    }
    return true;
}

function clickEvent(event){
    var tmp = document.getElementsByClassName("clicked");
    if(tmp.length<10){
        if(event.target.classList[1] == "clicked"){
            event.target.classList.remove("clicked");
        }
        else{
            event.target.classList.add("clicked");
        }
    }
    else{
        if(event.target.classList[1] == "clicked"){
            event.target.classList.remove("clicked");
        }
        else{
            alert("예매 가능 좌석 수를 초과하였습니다!");
        }
    }
    document.getElementById("cnt").innerHTML = "선택 좌석 수: "+tmp.length.toString();
}

function check(event){
    var tops = document.getElementsByClassName("myList");
    for(var i=0; i<tops.length; i++){
        if(tops[i].classList[2] == "clicked"){
            tops[i].classList.remove("clicked");
        }
    }
    event.target.classList.add("clicked");

    var book = document.getElementsByClassName("book content");
    var cancel = document.getElementsByClassName("cancel content");
    if(event.target.classList[1] == "cancel"){
        for(var i=0; i<book.length; i++){
            book[i].style.display = "none";
        }
        for(var i=0; i<cancel.length; i++){
            document.getElementsByClassName("bookingL2")[0].style.display = "block";
            cancel[i].style.display = "block";
        }
    }
    else{
        for(var i=0; i<cancel.length; i++){
            cancel[i].style.display = "none";
        }
        for(var i=0; i<book.length; i++){
            book[i].style.display = "block";
        }
    }
}

function show(tNumber, event){
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
