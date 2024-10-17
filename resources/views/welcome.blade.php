<!DOCTYPE html>
<html>
<body>

<h1>My First Google Map</h1>

<div id="googleMap" style="width:75%;height:400px;
  margin: 0 auto; 
  padding: 20px;
  background-color: #f0f0f0;">
  </div>
<div style=" 
width:75%;margin: 0 auto; 
  padding: 20px;">
    <label for="">Search</label>
    <input type="text" id="search">
</div>
<script>
function myMap() {
var mapProp= {
  center:new google.maps.LatLng(51.508742,-0.120850),
  zoom:5,
};
var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
}
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCs8Fx2_N0gwM-B2rMSMUOow-e889zm6To&callback=myMap"></script>

</body>
</html>