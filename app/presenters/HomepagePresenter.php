<?php

namespace App\Presenters;

use App\Models\WeatherModel;
use Nette;


final class HomepagePresenter extends Nette\Application\UI\Presenter
{
	/**
	 * @var WeatherModel
	 * @inject
	 */
	public $weatherModel;

	public function renderWeather(string $location, string $units = 'c')
	{
		$data = $this->weatherModel->getData($location, $units);
		$weatherInfo = $this->weatherModel->getWeatherInformation($data);

		if (!$weatherInfo) {
			$this->getHttpResponse()->setCode(404);
			$this->sendResponse(new Nette\Application\Responses\JsonResponse(
				['error' => 'Location not found']
			));
		}

		$this->sendResponse(new Nette\Application\Responses\JsonResponse($weatherInfo));
	}

	public function renderFullInfo(string $location, string $units = 'c')
	{
		$data = $this->weatherModel->getData($location, $units);
		$this->sendResponse(new Nette\Application\Responses\JsonResponse($data));
	}
}
