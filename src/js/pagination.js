let totalCount;
let totalPage;
let pageSize = 6;
//let currentPage;

function showPage(arr,currentPage) {
for(let i=(currentPage-1)*6;i<currentPage*6;i++){
return "<div class=box>\n" +
    "        <a href=details.php?id=" + arr[i].ImageID + "><img src=../../travel-images/large/" + arr[i].PATH + " alt=image height=150 width=200></a>\n" +
    "        <div class=words>\n" +
    "        <h4>"+arr[i].Title+"</h4>\n" +
    "        <p>" +arr[i].Description+"</p>\n" +
    "        </div>\n" +
    "        </div>";
}

}