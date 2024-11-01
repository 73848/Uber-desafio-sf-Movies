<!DOCTYPE html>
<html>
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<body>

<br>
<div id="googleMap" style="width:75%;height:400px;
  margin: 0 auto; 
  padding: 20px;
  background-color: #f0f0f0;">
  </div>
<div style=" 
width:75%;margin: 0 auto; 
  padding: 20px;">
  <form action="/geolocation">
    <label for="">Search</label>
    <input type="text" id="search" name="search">
  
    <button type="submit">Submit</button>
    <div >
      <p id="result"></p>
    </div>
  </form>
</div>
<script>
function myMap() {
var mapProp= {
  center:new google.maps.LatLng(37.7749,-122.4194),
  zoom:5,
};
var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
}
</script>
<script>
  $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });

</script>
<script>
  /* AJAX PARA REQUISICOES DA FUNCAO SEARCH */
$(document).ready(function () {
  $("#search").on("keyup", function () {
    /* 
    $("#result").html(search) ; 
    */
   var search = $("#search").val(); 
   console.log(search);
    if(search != ''){
      $.ajax({
        type: "GET",
        url: '/search',
        dataType: "json",
        data: {'search':search},
        success: function (data) {
          var moviesList = $("#movieList");
          moviesList.empty();
          var movies = JSON.parse(data.movies);
          
          movies.forEach(title => {
            $('#result').html(title.title); 
            console.log(title.title);
            
          });
        },
    error: function(data){
        console.log(data);
    }});
    }else{
      $("#result").html(" ")
    }
    });
});

$("#result").on('click', function (title) { 
    var value = $(this).text();
    $("#search").val(value);
    $("#search").submit();

})


</script>

<script src="https://maps.googleapis.com/maps/api/js?key={{env("GOOGLE_MAPS_API_KEY")}}&callback=myMap"></script>

</body>
</html>