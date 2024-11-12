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
        <div>
            <label for="">Search</label>
            <input type="text" id="search" name="search">
            <input type="hidden" id="address" name="adress">
            <select name="" id="container"></select>
            <button type="submit" id="buttonSubmit">Submit</button>
        </div>
       
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

        function getInfoMovies(movie, address) {
            return $.ajax({
                type: "GET",
                url: '/movies/information',
                dataType: "json",
                data: {
                    'movie': movie,
                    'address':address
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
            let i = 0;
            movies.forEach(title => {
                i++;
                const newPara = $('<option/>', { //PAREI AQUI
                    id: 'result'+i,
                    name: "movieOptions",
                    text: title.title,
                    value: title.locations
            });

            $('#container').append(newPara);
            $(document).on('click','#result1', function() {
                    let address = $("#result"+i).val();
                    $('#search-location').val(address);
            });
            });
        }

        function getLatLng(movie){
            return {lat: movie.lat,
            lng: movie.long};
        }
        function ajaxSearchResult(){ 
            var search = $("#search").val();// valor do label
            if (search != '') {
                $("#container").empty();
                searcMovies(search).then((data) => {
                    liveSearch(data)
                }).catch((err) => {
                    $('#result').html("Refresh a página ou contate o administrador");
                });
        }}

        $(document).ready(function() {
            $("#search").on("keyup", function() {
                ajaxSearchResult()
            });
        });

        function myMap() {
            var mapProp = {
                center: new google.maps.LatLng(37.7749, -122.4194),
                zoom: 15,
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
// observar mudancas no codigo
           $("#container").on('change', function()  { 
                var selectedValue = $(this).val();
                var selectedText = $(this).find('option:selected').text();
                $("#search").val(selectedText)
                $("#address").val(selectedValue)
             })
            $("#buttonSubmit").on('click', function() {
                var address = $('#address').val();
                var name = $('#search').val();
                console.log(address)
                if (address != " ") {
                    searcMovies(address).then((data) => {
                        var movies = JSON.parse(data.movies);
                        movies.forEach(movie => {
                            const position = getLatLng(movie);
                            getInfoMovies(name,address).then((data)=>{
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
