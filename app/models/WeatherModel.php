<?php


namespace App\Models;


class WeatherModel
{
	/**
	 * @param string $location
	 * @param string $units
	 * @return mixed
	 */
	public function getData(string $location, string $units)
	{
		if (!in_array($units, ['c', 'f'])) {
			$units = 'c';
		}

		$baseURL = "http://query.yahooapis.com/v1/public/yql";
		$query = "select * from weather.forecast where woeid in (select woeid from geo.places(1) where text='$location') and u='$units'";

		$URL = $baseURL . "?q=" . urlencode($query) . "&format=json";
		$data = file_get_contents($URL);

		return json_decode($data);
	}

	/**
	 * @param $data
	 * @return array|null
	 */
	public function getWeatherInformation($data)
	{
		if (!$data->query->results OR !isset($data->query->results->channel->item)) {
			return NULL;
		}

		return $this->fetchWeatherData($data->query->results->channel);

	}

	/**
	 * @param $data
	 * @return array
	 */
	private function fetchWeatherData($data)
	{
		$forecast = [];
		foreach ($data->item->forecast as $day) {
			$forecast[] = [
				'date' => $day->date,
				'high' => $day->high,
				'low' => $day->low,
				'text' => $day->text,
			];
		}

		$weatherInfo = [
			'location' => [
				'city' => $data->location->city,
				'region' => $data->location->region,
				'country' => $data->location->country,
			],
			'wind' => [
				'direction' => $data->wind->direction,
				'speed' => $data->wind->speed,
				'speed_unit' => $data->units->speed,
			],
			'atmosphere' => [
				'humidity' => $data->atmosphere->humidity,
				'pressure' => $data->atmosphere->pressure,
				'pressure_unit' => $data->units->pressure,
			],
			'weather' => [
				'date' => $data->item->condition->date,
				'temp' => $data->item->condition->temp,
				'temp_unit' => $data->units->temperature,
				'text' => $data->item->condition->text,
			],
			'forecast' => $forecast
		];

		return $weatherInfo;
	}
}