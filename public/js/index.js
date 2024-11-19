var script = document.createElement('script');
script.src = 'https://code.jquery.com/jquery-3.6.3.min.js'; // Check https://jquery.com/ for the current version
document.getElementsByTagName('head')[0].appendChild(script);

$.ajaxSetup({
    headers: {
        'csrftoken': '{{ csrf_token() }}'
    }
});

$(document).on('click', "#result", function (title) {
    var value = $("#result").text();
    $("#search").val(value);
    $("#search").submit();
});

// Aqui vem algumas funcoes de requisicoes ajax

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
            'address': address
        },
    });
}

function showingInformation(movie) {
    var title = $('#informations-title');
    var paragph = $('#informations-paragaph');
    title.html(movie.title)
    paragph.html("Localização: " + movie.locations + "<br>Ano de Gravação: " + movie.release_year +
        "<br>Produtor: " + movie.production_company + "<br>Distribuição: " + movie.distributor + "<br>Direção: " + movie.director +
        "<br>Escrito por: " + movie.writer + "<br>Atores: " + movie.actor_1 + ", " + movie.actor_2 + ", " + movie.actor_3)
    $("#info-box").addClass("info-box");
}

function liveSearch(data) {
    var movies = JSON.parse(data.movies);
    let i = 0;
    movies.forEach(title => {
        i++;
        // cria um novo elemento do tipo option
        const newPara = $('<option/>', { //PAREI AQUI
            id: 'result' + i,
            name: "movieOptions",
            text: title.title,
            value: title.locations
        });

        $('#container').append(newPara);
        $(document).on('click', '#result1', function () {
            let address = $("#result" + i).val();
            $('#search-location').val(address);
        });
    });
}

function getLatLng(movie) {
    return {
        lat: movie.lat,
        lng: movie.long
    };
}
// une as funcoes nescessárias para a funcionalidade liveSearch
function ajaxSearchResult() {
    var search = $("#search").val();// valor do label
    if (search != '') {
        $("#container").empty();
        searcMovies(search).then((data) => {
            liveSearch(data)
        }).catch((err) => {
            $('#result').html("Refresh a página ou contate o administrador");
        });
    }
}

$(document).ready(function () {
    $("#search").on("keyup", function () {
        ajaxSearchResult()
    });
});
// criacao do mapa
function myMap() {
    var mapProp = {
        center: new google.maps.LatLng(37.7749, -122.4194),
        zoom: 18,
    };
    var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
    // aqui é feita a distribuicao das marcacoes de todos os filmes no mapa
    getAllMovies(' ').then((data) => {
        var movies = JSON.parse(data.movies);
        movies.forEach((movie) => {
            if (movie.lat != 0) {
                var marker = new google.maps.Marker({
                    position: getLatLng(movie),
                    label: {
                        text: movie.title,
                        color: "#191970",
                        fontWeight: "bold",
                        fontSize: "10px"
                    },
                });
                marker.setMap(map);
            }
        })
    })
    // observar mudancas no codigo
    $("#container").on('change', function () {
        var selectedValue = $(this).val();
        var selectedText = $(this).find('option:selected').text();
        $("#search").val(selectedText)
        $("#address").val(selectedValue)
    })
    $("#buttonSubmit").on('click', function () {
        var address = $('#address').val();
        var name = $('#search').val();
        console.log(address)
        if (address != " ") {
            // aqui é feita a coleta de informacoes da API de filmes
            searcMovies(address).then((data) => {
                var movies = JSON.parse(data.movies);
                movies.forEach(movie => {
                    const position = getLatLng(movie);
                    getInfoMovies(name, address).then((data) => {
                        var infoMovie = JSON.parse(data.movies);
                        // com os dados coletados, chama a funcao para criar interface de informacoes
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
