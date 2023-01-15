<?php

namespace TestsCodeception\Acceptance;

use TestsCodeception\Support\AcceptanceTester;

class Test23_PricesCest
{
    public function homepageTest(AcceptanceTester $I): void
    {
        $I->wantTo('View Prices');
        $I->amOnPage('/');
        $I->see("Prices");
        $I->click("Prices");
        $I->seeCurrentUrlEquals('/prices');
        $I->seeElement('table');
        $I->see('JOB');
        $I->see('AMOUNT DUE');
        $I->see('APPROXIMATE TIME');
        $I->seeNumberOfElements('tr', 5);
    }
}
