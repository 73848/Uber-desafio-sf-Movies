<!DOCTYPE html>
<html>
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

<script src="https://maps.googleapis.com/maps/api/js?key={{env("GOOGLE_MAPS_API_KEY")}}&callback=myMap"></script>

</body>
</html>