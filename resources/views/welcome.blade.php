<!DOCTYPE html>
<html>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>

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

            <div>
                <p id="result"></p>
            </div>
        </form>
        <form action="/geolocation" id="geolocation-form" method="get">
            <input type="hidden" id="search-location" name="search-location">
            <button type="submit">Submit</button>
        </form>
    </div>


    <script>
       
        $("#result").on('click', function(title) {
            var value = $(this).text();
            $("#search").val(value);
            $("#search").submit();

        });

        $.ajaxSetup({
            headers: {
                'csrftoken': '{{ csrf_token() }}'
            }
        });
        /* AJAX PARA REQUISICOES DA FUNCAO SEARCH */
        $(document).ready(function() {
            function getMovies(search) {
                return $.ajax({
                    type: "GET",
                    url: '/search',
                    dataType: "json",
                    data: {
                        'search': search
                    },
                });
            };

        $("#geolocation-form").on('submit', function(e) {
            e.preventDefault(e)
            // PRECISO DE OUTRA FUNCAO PARA REQ AJAX NO DB E RETORNO DE LAT E LONG
            var address = $('#search-location').val();
            if (address != " ") {
                getGeolocations(address).then((data) => {
                    console.log(data);
                });
            }
        });


            /* MANIPULACAO DE DADOS DO DB PARA REQUISICOES À API GEOLOCALIZACAO E COLETA DE DADOS */
            $("#search").on("keyup", function() {
                var search = $("#search").val();
                if (search != '') {
                    getMovies(search).then((data) => {
                        var moviesList = $("#movieList");
                        moviesList.empty();
                        var movies = JSON.parse(data.movies);
                        console.log(movies);
                        movies.forEach(title => {
                            $('#result').html(title.title);
                            $('#result').on('click', function() {
                                $('#search-location').val(title.locations);
                                /*  console.log($('#search-location').val()) */

                            });
                        });
                    }).catch((err) => {
                        $('#result').html("Refresh a página ou contate o administrador");
                    });
                }
            });
        });

             function myMap() {
            var mapProp = {
                center: new google.maps.LatLng(37.7749, -122.4194),
                zoom: 15,
            };
            var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
            getAllMovies(' ').then((data)=>{
                var movies = JSON.parse(data.movies);
                movies.forEach((movie)=>{
                    console.log(movie);
                })
            })
            var marker = new google.maps.Marker({
                position: {
                    lat: 37.8081009,
                    lng: -122.4159393
                }
            });
            
            marker.setMap(map);
        };
    </script>


    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=myMap"></script>

</body>

</html>
