function openPopup(obj){
    var data = $(obj).serialize();

    console.log(data);

    var url = BASE_URL + "/report/sales_pdf?" + data;
    console.log(url);
    window.open(url, "report", "width=700, height=500");

    return true;
}