<html>

<head>
  <!-- Bootstrap core CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
  <!-- JQuery -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>

<body>
  <?php
  $cities = [
    'TOKYO',
    'JAKARTA',
    'New York',
    'SEOUL',
    'MANILA',
    'Mumbai',
    'Sao Paulo',
    'MEXICO CITY',
    'Delhi',
    'Osaka',
    'CAIRO',
    'Los Angeles',
    'Shanghai',
    'MOSCOW',
    'BEIJING',
    'BUENOS AIRES',
    'Istanbul',
    'Rio de Janeiro',
    'PARIS',
    'Chicago',
    'LONDON',
  ];
  ?>
  <h1>WeatherGenerator</h1>
  <h2>Generowanie pliku CSV z pogodą dla wybranych miast</h2>

  <form method="post" action="generate.php">

    <div class="form-group">
      <label for="cities">Wybierz kraje</label>
      <select multiple class="form-control" id="cities" name="cities[]">
        <?php foreach ($cities as $city)
          echo "<option value='{$city}'> {$city} </option>"
        ?>
      </select>
    </div>

    <p>Zaznacz pola które chcesz zobaczyć w pliku CSV</p>

    <div class="form-group">
      <label for="coord">Współrzędne</label>
      <select multiple class="form-control" id="coord" name="coord[]">
        <option value="lon">Długość geograficzna</option>
        <option value="lat">Szerokość geograficzna</option>
      </select>
    </div>


    <div class="form-group">
      <label for="main">Główne informacje</label>
      <select multiple class="form-control" id="main" name="main[]">
        <option value="temp">Temperatura</option>
        <option value="feels_like">Odczucia</option>
        <option value="temp_min">Min. temperatura</option>
        <option value="temp_max">Max. temperatura</option>
        <option value="pressure">Ciśnienie</option>
        <option value="humidity">Wilgotność</option>
      </select>
    </div>

    <div class="form-group">
      <label for="wind">Wiatr</label>
      <select multiple class="form-control" id="wind" name="wind[]">
        <option value="speed">Prędkość</option>
        <option value="deg">Stopień</option>
      </select>
    </div>


    <button type="submit" class="btn btn-primary">Generuj</button>
  </form>

</body>

</html>