function openPopup(obj){
    var data = $(obj).serialize();

    var url = BASE_URL + "/report/inventory_pdf?" + data;
    console.log(url);
    window.open(url, "report", "width=700, height=500");

    return true;
}