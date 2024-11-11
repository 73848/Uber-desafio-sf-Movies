<!DOCTYPE html>
<html>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
    <style>
        .info-box {
            max-width: 300px;
            padding: 20px;
            margin-top: 20px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            font-family: Arial, sans-serif;
            color: #333;
        }
        .info-box h2 {
            font-size: 20px;
            margin-top: 0;
            color: #007bff;
        }
        .info-box p {
            font-size: 16px;
            line-height: 1.5;
        }
    </style>

<body>

    <br>
    <div id="googleMap" style="width:75%;height:400px;margin: 0 auto; padding: 20px;background-color: #f0f0f0;">
    </div>
    <div style="width:75%;margin: 0 auto; padding: 20px;">
        <form action="/geolocation">
            <label for="">Search</label>
            <input type="text" id="search" name="search">
            <div id="container">
            </div>
        </form>
        <form action="/geolocation" id="geolocation-form" method="get">
            <input type="hidden" id="search-location" name="search-location">
            <button type="submit">Submit</button>
        </form>
        <div class="" id="info-box">
            <h2 id="informations-title"></h2>
            <p id="informations-paragaph"></p>
        </div>
        
    </div>
    <script>
        $.ajaxSetup({
            headers: {
                'csrftoken': '{{ csrf_token() }}'
            }
        });

        $(document).on('click',"#result", function(title) {
            var value = $("#result").text();
            $("#search").val(value);
            $("#search").submit();
        });

        function searcMovies(search) {
            return $.ajax({
                type: "GET",
                url: '/search',
                dataType: "json",
                data: {
                    'search': search
                },
            });
        };

        function getAllMovies() {
            return $.ajax({
                type: "GET",
                url: '/movies',
                dataType: "json",
            });
        };

        function getInfoMovies(movie) {
            return $.ajax({
                type: "GET",
                url: '/movies/information',
                dataType: "json",
                data: {
                    'movie': movie
                },
            });
          }

        function showingInformation (movie) { 
            var title = $('#informations-title');
            var paragph = $('#informations-paragaph');
            title.html(movie.title)
            paragph.html("Localização: " + movie.locations + "<br>Ano de Gravação: " + movie.release_year +
             "<br>Produtor: " + movie.production_company + "<br>Distribuição: "+ movie.distributor + "<br>Direção: " + movie.director+
              "<br>Escrito por: " +movie.writer + "<br>Atores: " +movie.actor_1+ ", "+movie.actor_2+", " + movie.actor_3)
            $("#info-box").addClass("info-box");
            }
        
         function liveSearch(data){
            var movies = JSON.parse(data.movies);
            movies.forEach(title => {
                const newPara = $('<p>', {
                    id: 'result',
                    text: title.title
            });
            $('#container').append(newPara);
                $(document).on('click','#result', function() {
                    $('#search-location').val(title.locations);
                });
            });
        }

        function getLatLng(movie){
            return {lat: movie.lat,
            lng: movie.long};
        }

        $(document).ready(function() {
            $("#search").on("keyup", function() {
                var search = $("#search").val();
                var moviesList = $("#conteiner");
                moviesList.empty();
                if (search != '') {
                    $("#container").empty();
                    searcMovies(search).then((data) => {
                        liveSearch(data)
                    }).catch((err) => {
                        $('#result').html("Refresh a página ou contate o administrador");
                    });
                }
            });
        });

        function myMap() {
            var mapProp = {
                center: new google.maps.LatLng(37.7749, -122.4194),
                zoom: 12,
            };
            var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
            getAllMovies(' ').then((data) => {
                var movies = JSON.parse(data.movies);
                movies.forEach((movie) => {
                    if(movie.lat != 0){
                        var marker = new google.maps.Marker({
                            position: getLatLng(movie),
                            label: {
                                    text: movie.title,
                                    color: "#191970",
                                    fontWeight: "bold",
                                    fontSize: "10px"
                            }                
                        });
                        marker.setMap(map);
                    }

                })
            })
            $("#geolocation-form").on('submit', function(e) {
                e.preventDefault(e)
                var address = $('#search-location').val();
                if (address != " ") {
                    searcMovies(address).then((data) => {
                        var movies = JSON.parse(data.movies);
                        movies.forEach(movie => {
                            const position = getLatLng(movie);
                            getInfoMovies(movie.title).then((data)=>{
                                var infoMovie = JSON.parse(data.movies);
                                infoMovie.forEach(element => {
                                    showingInformation(element);
                                });
                            });
                            setTimeout(() => {
                                map.setCenter(position);
                            }, 2000);
                        });
                    });
                }
            });
        };
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=myMap"></script>
</body>
</html>
