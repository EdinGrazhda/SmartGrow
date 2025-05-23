<?php
// filepath: c:\Users\Edin\Desktop\SmartGrow\smartgrow\api\weather_api.php

function getWeatherData($apiKey, $location) {
    $url = "https://api.openweathermap.org/data/2.5/weather?q={$location}&appid={$apiKey}&units=metric";

    // Use cURL instead of file_get_contents for better error handling
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Needed in some environments
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($response === false || $httpCode != 200) {
        error_log("Weather API Error: HTTP Code $httpCode, Error: $error");
        return null;
    }

    return json_decode($response, true);
}

function suggestPlantingDayFromWeather($weatherData) {
    $temperature = $weatherData['main']['temp'];
    $humidity = $weatherData['main']['humidity'];
    $windSpeed = $weatherData['wind']['speed'];
    $airPressure = $weatherData['main']['pressure'];

    if ($temperature > 15 && $temperature < 25 && $humidity < 70 && $windSpeed < 15 && $airPressure > 1000) {
        return "Today is a great day for planting!";
    } else {
        return "Consider waiting for a better day to plant.";
    }
}

function getForecastData($apiKey, $location) {
    // OpenWeatherMap 5-day forecast endpoint with 3-hour intervals
    $url = "https://api.openweathermap.org/data/2.5/forecast?q={$location}&appid={$apiKey}&units=metric";
    
    // Use cURL for better error handling
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Needed in some environments
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($response === false || $httpCode != 200) {
        error_log("Weather Forecast API Error: HTTP Code $httpCode, Error: $error");
        return null;
    }
    
    return json_decode($response, true);
}

/**
 * Analyze daily forecast data specifically for tomato planting
 * Tomatoes prefer:
 * - Day temperatures between 21°C and 29°C
 * - Night temperatures not below 13°C
 * - Moderate humidity (50-70%)
 * - Low to moderate wind
 * - Stable barometric pressure
 */
function analyzeTomatoPlantingConditions($forecastData) {
    if (!$forecastData || !isset($forecastData['list'])) {
        return [];
    }
    
    $dailyForecasts = [];
    $currentDate = '';
    $dailyData = null;
    
    // Process the 3-hour interval forecasts into daily summaries
    foreach ($forecastData['list'] as $forecast) {
        $date = date('Y-m-d', $forecast['dt']);
        
        // If we're on a new day, store the previous day's data and start a new one
        if ($date != $currentDate) {
            if ($dailyData !== null) {
                $dailyForecasts[] = $dailyData;
            }
            
            // Initialize new day
            $currentDate = $date;
            $dailyData = [
                'date' => $date,
                'display_date' => date('D, M j', $forecast['dt']), // Format: Mon, Jan 1
                'temp_min' => $forecast['main']['temp_min'],
                'temp_max' => $forecast['main']['temp_max'],
                'humidity' => $forecast['main']['humidity'],
                'wind_speed' => $forecast['wind']['speed'],
                'pressure' => $forecast['main']['pressure'],
                'weather' => $forecast['weather'][0]['main'],
                'description' => $forecast['weather'][0]['description'],
                'icon' => $forecast['weather'][0]['icon'],
                'readings' => 1,
            ];
        } else {
            // Update existing day with min/max values
            $dailyData['temp_min'] = min($dailyData['temp_min'], $forecast['main']['temp_min']);
            $dailyData['temp_max'] = max($dailyData['temp_max'], $forecast['main']['temp_max']);
            $dailyData['humidity'] = ($dailyData['humidity'] + $forecast['main']['humidity']) / 2;
            $dailyData['wind_speed'] = max($dailyData['wind_speed'], $forecast['wind']['speed']);
            $dailyData['pressure'] = ($dailyData['pressure'] + $forecast['main']['pressure']) / 2;
            $dailyData['readings']++;
        }
    }
    
    // Add the last day's data
    if ($dailyData !== null) {
        $dailyForecasts[] = $dailyData;
    }
    
    // Analyze each day for tomato planting suitability
    foreach ($dailyForecasts as &$day) {
        $score = 0;
        
        // Temperature score - tomatoes prefer 21-29°C (70-85°F)
        if ($day['temp_max'] >= 21 && $day['temp_max'] <= 29 && $day['temp_min'] >= 13) {
            $score += 5; // Ideal temperature
        } elseif ($day['temp_max'] >= 18 && $day['temp_max'] < 21 && $day['temp_min'] >= 10) {
            $score += 3; // Acceptable temperature
        } elseif ($day['temp_max'] > 29 && $day['temp_max'] <= 32) {
            $score += 2; // Too warm but manageable
        } else {
            $score -= 2; // Poor temperature
        }
        
        // Humidity score - moderate humidity (50-70%)
        if ($day['humidity'] >= 50 && $day['humidity'] <= 70) {
            $score += 3; // Ideal humidity
        } elseif ($day['humidity'] > 70 && $day['humidity'] <= 85) {
            $score += 1; // Acceptable but high humidity
        } elseif ($day['humidity'] < 50 && $day['humidity'] >= 35) {
            $score += 1; // Acceptable but low humidity
        } else {
            $score -= 1; // Poor humidity
        }
        
        // Wind score - tomatoes don't like strong winds
        if ($day['wind_speed'] < 10) {
            $score += 2; // Gentle breeze
        } elseif ($day['wind_speed'] < 15) {
            $score += 1; // Moderate wind
        } else {
            $score -= 2; // Too windy
        }
        
        // Weather condition penalty
        if (in_array($day['weather'], ['Rain', 'Thunderstorm', 'Drizzle'])) {
            $score -= 3; // Rainy conditions are not good for planting
        }
        
        // Assign rating based on score
        if ($score >= 8) {
            $day['rating'] = 'excellent';
            $day['color'] = 'green';
            $day['message'] = 'Excellent day for planting tomatoes!';
        } elseif ($score >= 5) {
            $day['rating'] = 'good';
            $day['color'] = 'lightgreen';
            $day['message'] = 'Good day for planting tomatoes.';
        } elseif ($score >= 2) {
            $day['rating'] = 'fair';
            $day['color'] = 'orange';
            $day['message'] = 'Fair conditions for tomatoes, but not ideal.';
        } else {
            $day['rating'] = 'poor';
            $day['color'] = 'red';
            $day['message'] = 'Poor conditions for planting tomatoes. Better wait.';
        }
        
        $day['score'] = $score;
    }
    
    return $dailyForecasts;
}
?>
