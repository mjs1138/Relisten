function myFunction() {

    var matches = document.querySelectorAll("tr.shwInfo, tr.sourceID");

    var x = document.getElementById("655").checked;
    var y = document.getElementById("768").checked;

    if (!x) {
        document.getElementById("tr_655").remove();
    }

//            document.getElementById("tr_shwInfo_7904423").remove();
    var elementByShowInfo = document.getElementById("tr_shwInfo_7904423").valueOf();
}