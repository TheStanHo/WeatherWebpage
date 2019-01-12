<?php 

   
  //  $timeZone_Offset=$_POST['timezone'];
  //  print_r ($_POST);
  //  $timezone_name = timezone_name_from_abbr("",$timeZone_Offset*60,false);
  //  echo $timezone_name;
    date_default_timezone_set('Europe/London');

    $submitted = false;
    $weatherText="";
    $error = false;
    function curl($url)  {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }
    //temp given in Kevlins subtract + 273.15
    if(empty($_GET['city'])== false)  {
    $city = $_GET['city'];
    $content = curl("https://api.openweathermap.org/data/2.5/weather?q=".$city."&appid={YOURAPIKEY}");
    // $citiesContent = curl("cities.json");
    // $cities = json_decode($citiesContent,true);
    $weatherArray = json_decode($content, true);
  //  print_r($cities);
     if(isset($weatherArray['main']['temp']))  {
    $currentTemp = round(($weatherArray['main']['temp']-273.15),2);
    $minTemp = round(($weatherArray['main']['temp_min'] -273.15),2);
    $maxTemp = round(($weatherArray['main']['temp_max'] -273.15),2);
    $humidity = ($weatherArray['main']['humidity'])."%";
   
    $cloud = ($weatherArray['clouds']['all'])."%";
 

    $country = $weatherArray['sys']['country'];
  
    $city = $weatherArray['name'];
  
    $sunrise = $weatherArray['sys']['sunrise'];
    $sunriseTimeConverted = strftime("%H:%M",$sunrise  );
    
    $sunset = $weatherArray['sys']['sunset'];
    $sunsetTimeConverted = strftime("%H:%M",$sunset  );
  
   
    $dateOfSunrise = strftime("%d/%m/%Y",$sunrise  );
  
    $dateOfSunset = strftime("%d/%m/%Y",$sunset  );


    $weatherDescription = $weatherArray['weather'][0]['description'];
    
    $weatherRecoreded =strftime("%d/%m/%Y at %H:%M",$weatherArray['dt']);
    $weatherText ="In " .$city.", ".$country. " the current temperature is ".$currentTemp."&#176C. With a high of ".$maxTemp. "&#176C and a low of ".$minTemp."&#176C. Expect ".$weatherDescription. 
    " with a humidity of ". $humidity.". For the ".$dateOfSunrise. " Sunrise: ".$sunriseTimeConverted." and Sunset: ".$sunsetTimeConverted.". This data was recorded on the ".$weatherRecoreded.". Note that all times given are set for GMT time.";
     } else {
       $error = true;
     }
  
  } else {
      //If empty do nothing
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
  <link rel="shortcut icon" type="image/png" href="SH.png" />
    <link rel="icon" type="image/png" href="SH.png" />
    <title>Weather</title>
      <!-- Global site tag (gtag.js) - Google Analytics -->
      <script
      async
      src="https://www.googletagmanager.com/gtag/js?id=UA-131674608-1"
    ></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag() {
        dataLayer.push(arguments);
      }
      gtag("js", new Date());

      gtag("config", "UA-131674608-1");
    </script>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
 
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
  <link href="jquery-ui.css" rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css"
      integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ"
      crossorigin="anonymous"
    />
    <style type="text/css">
      html {
        background: url(Background.jpg) no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
      }

      body {
        background: none;
      }

      .container {
        text-align: center;
        margin-top: 100px;
        width: 450px;
      }

      input {
        margin: 20px;
      }

      #currentWeather{
          margin: 15px;
      }
      label{
          font-weight: bold;
          color:white;
          text-align:center;
      }
      h1 {
          color: white;
      }
    
      @media (max-width:600px)  {
        html {
         background: url(Background.jpg) no-repeat center center fixed;
        -webkit-background-size: cover;
       -moz-background-size: cover;
       -o-background-size: cover;
       background-size: cover;
       height: 100%;
       overflow: hidden;
      }
    }
    </style>
  </head>
  <body>
    <div class="container">
      <h1>What's The Weather</h1>
      <form>
        <div class="form-group">
          <label for="city">Enter the name of a Place.<br> (For a more accurate place type the place name followed by a comma and then the country. Eg. London, United Kingdom or London, UK).</label>
          <input
            type="text"
            class="form-control"
            name="city"
            id="city"
            aria-describedby="emailHelp"
            placeholder="Eg. London, Tokyo"
          
            
          />
        </div>
        <button type="submit" class="btn btn-primary"><?php $submitted=true; ?>Submit</button>
        <div id="currentWeather"><?php 
        
      if($weatherText)  {
            echo'<div class="alert alert-success" role="alert" style="width:435px;">
            '.$weatherText.'
          </div>';
        } 
        else if($error)  {
            echo'<div class="alert alert-danger" role="alert style="width:435px;">
            Place could not be found! Please try again!
          </div>';
        }   

        ?>

      </form>
    </div>

    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <!-- <script
      src="https://code.jquery.com/jquery-3.1.1.slim.min.js"
      integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n"
      crossorigin="anonymous"
    ></script> -->
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"
      integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"
      integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn"
      crossorigin="anonymous"
    ></script>
    <script type="text/javascript" src="script.js"></script>

  </body>
</html>
