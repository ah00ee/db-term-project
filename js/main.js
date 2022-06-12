function blankSearch(){
    var title = document.forms["search"]["movie_title"].value;
    if(title==""){
        return false;
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

function show(tNumber){
    var getSchedule = document.getElementsByClassName("sche");
    for(var i=0; i < getSchedule.length; i++){
        getSchedule[i].style.display = "none";
    }
    for(var i = 1; i < 6; i++){
        var tNum = "t"+i.toString()+"movie";
        if(tNum == tNumber){
            var div = document.getElementById(tNumber);
            div.style.display = "block";
        }
        else{
            var div = document.getElementById(tNum);
            div.style.display = "none";
        }
    } 
}

function showSchedule(title){
    var getTitle = document.getElementById(title);
    var getSchedule = document.getElementsByClassName("sche");
    for(var i=0; i < getSchedule.length; i++){
        getSchedule[i].style.display = "none";
    }
    if(getTitle != null){
        getTitle.style.display = "block";
    }
}
