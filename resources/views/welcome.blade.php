<!DOCTYPE html>
<html>
    <head>
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
        
    </head>

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
    <script src="{{ asset('js/index.js') }}"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=myMap"></script>

    </body>
</html>
