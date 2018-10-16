<?php

class WeatherModelTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;


    // tests
    public function test()
    {
    	$weatherModel = new \App\Models\WeatherModel();
		$I = $this->tester;

		$notExistLocData = $weatherModel->getData('tttttteeeeeeesssssssttttttttttttt', 'qwerty');
		$existingLocData = $weatherModel->getData('Prague', 'c');

		$I->assertNull($weatherModel->getWeatherInformation($notExistLocData));
		$I->assertNotNull($weatherModel->getWeatherInformation($existingLocData));

		$I->assertNotEmpty($notExistLocData);
		$I->assertNotEmpty($existingLocData);
    }
}