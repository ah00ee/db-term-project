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

function clickEvent(event){
    if(event.target.classList[1] == "clicked"){
        event.target.classList.remove("clicked");
    }
    else{
    event.target.classList.add("clicked");
    }
}

function show(tNumber){
    for(var i=1; i < 6; i++){
        var tNum = "t"+i.toString()+"movie";
        var tBox = "t"+i.toString()+"box";
        var div = document.getElementById(tBox);
        if(tNum == tNumber){
            div.style.backgroundColor = "lightgrey";
        }
        else{
            div.style.backgroundColor = "white";
        }
    }
    for(var i = 1; i < 6; i++){
        var tNum = "t"+i.toString()+"movie";
        var div = document.getElementById(tNum);
        if(tNum == tNumber){
            div.style.display = "block";
        }
        else{       
            div.style.display = "none";
        }
    } 
}

function showSchedule(tNumber, title){
    var getInfo = document.getElementsByClassName(tNumber+"info");
    for(var i = 0; i < getInfo.length; i++){
        getInfo[i].style.backgroundColor = "white";
    } 
    var div = document.getElementById(tNumber+title);
    div.style.backgroundColor = "lightgrey";

    for(var i=1; i < 6; i++){
        var tNum = "t"+i.toString();
        var div = document.getElementById(tNum);
        if(tNum == tNumber){
            div.style.display = "block";
        }
        else{
            div.style.display = "none";
        }
    }

    var ul = document.getElementById(tNumber).innerHTML.split("<ul class=");
    for(var i=0; i < ul.length; i++){
        var tmp = ul[i].trim(" ");
        if(tmp!=""){
            var div = document.getElementsByClassName(tNumber+"movie_sche"+title)[0];
            if(tmp.match(tmp.substring(13, 13+title.length)+"\"") == null){
                div.style.display = "none";
            }
            else{
                div.style.display = "block";
            }
        }
    }
}
