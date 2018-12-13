var x = "";
var lastQuery = ""
var toggle = "DESC";
function loadPage(query, clicked) {
    lastQuery = query;
    if(clicked){
        if(toggle === "DESC") {
            toggle = "ASC";
        } else {
            toggle = "DESC";
        }
        var g = document.getElementById("tbl").rows[0].cells;
        for(i=0;i<g.length;i++){
            g[i].innerHTML = g[i].className;
        }
        if(toggle === "DESC") {
            clicked.innerHTML += " &#9660";
        } else {
            clicked.innerHTML += " &#9650";
        }   
    }
    var order = "?dir=" + toggle;
    if(query !== "") {
        query = "&by=" + query;
    }
    query = order + query;
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			x = JSON.parse(this.responseText);
            insertContent();
		}
	};
    console.log("ad_list.php" + query);
	xhr.open("GET", "ad_list.php" + query, true);
	xhr.send();
       
}


function insertContent() {
    var holder = "";
    for(i=0;i<x.length;i++) {
        holder += "<tr><td>"+ x[i]['title'] + "</td>" + "<td>"+ x[i]['description'] + "</td>" + "<td>"+ x[i]['asking_price'] + "</td>"+ "<td>"+ x[i]['created_at'] + "</td></tr>";
    }
    document.getElementById("contenttable").innerHTML = holder;
}

var isTabActive = true;
window.onfocus = function () { 
  isTabActive = true; 
}; 
window.onblur = function () { 
  isTabActive = false; 
}; 

window.setInterval(function(){
    if(window.isTabActive){
        loadPage(lastQuery);
        var d = new Date().toLocaleTimeString(); 
        document.getElementById("lastupdated").innerHTML = "Last updated: " + d;
        
        console.log(d);
    }
}, 5000);

loadPage("");





