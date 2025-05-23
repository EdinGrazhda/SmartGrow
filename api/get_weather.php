<?php
// filepath: c:\xampp\htdocs\SmartGrow\smartgrow\api\get_weather.php

require_once '../includes/config.php';
require_once '../includes/functions.php';
require_once './weather_api.php';

// Set content type to JSON
header('Content-Type: application/json');

// Check if the request has the location parameter
if (isset($_GET['location'])) {
    $location = htmlspecialchars(trim($_GET['location']));
    $plantType = isset($_GET['plantType']) ? htmlspecialchars(trim($_GET['plantType'])) : 'tomato';
    
    // Get weather data using the API key from config
    $apiKey = WEATHER_API_KEY;
    $weatherData = getWeatherData($apiKey, $location);
    
    // Also get forecast data for tomato planting recommendations
    $forecastData = getForecastData($apiKey, $location);
    $tomatoForecast = [];
    
    if ($forecastData) {
        $tomatoForecast = analyzeTomatoPlantingConditions($forecastData);
    }
    
    if ($weatherData) {
        // Return the weather data as JSON
        echo json_encode([
            'success' => true,
            'data' => $weatherData,
            'suggestion' => suggestPlantingDayFromWeather($weatherData),
            'forecast' => $forecastData,
            'tomatoForecast' => $tomatoForecast
        ]);
    } else {
        // Return an error if the weather data could not be retrieved
        echo json_encode([
            'success' => false,
            'error' => 'Unable to retrieve weather data. Please check your API key and try again.'
        ]);
    }
} else {
    // Return an error if the location parameter is missing
    echo json_encode([
        'success' => false,
        'error' => 'Location parameter is required.'
    ]);
}
?>
