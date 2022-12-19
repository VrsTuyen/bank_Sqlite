
var check;
var time = 0;
$(document).on('click', '.content-container-table thead .table-header', function () {

  if (check != order) {
    var mode = 'asc';
    time++;
  } else {
    var mode = 'asc';
    time++;
    if (time % 2 == 0) {
      var mode = 'asc';
    } else {
      var mode = 'asc';
    }
  }
  var query = $('.navigation-search-input').val()
  var order = $(this).data('query')
  check = order
  liveSearch(query, "" + order + " ")
})


function object() {
  if (window.XMLHttpRequest) {
    xmlHttp = new XMLHttpRequest();
  } else {
    xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
  return xmlHttp;
}
http = object();

function liveSearch(data = '', order = 'account_number', page = 1) {
  if (data.trim() != "") {
    http.onreadystatechange = process;
    http.open('GET', './search.php?data=' + data.trim() + '&page=' + page + '&order=' + order, true);
    http.send();
  } else {
    http.onreadystatechange = process;
    http.open('GET', './search.php?page=' + page + '&order=' + order, true);
    http.send();
  }
}

function process() {
  if (http.readyState == 4 && http.status == 200) {
    result = http.responseText;
    document.querySelector(".content-container").innerHTML = result;
  }
}

$(document).on('click', '.pagination-item-link:not(.disable)', function () {
  var page = $(this).data('page_number')
  var query = $('.navigation-search-input').val()
  liveSearch(query, check, page);
})

liveSearch();
