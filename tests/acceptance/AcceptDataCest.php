<?php 

class AcceptDataCest
{
	public function weatherWorks(AcceptanceTester $I)
	{
		$I->amOnPage('/weather?location=Prague');
		$I->see('Czech Republic');
	}
}
