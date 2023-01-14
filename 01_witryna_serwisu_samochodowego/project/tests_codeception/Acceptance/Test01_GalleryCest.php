<?php

namespace TestsCodeception\Acceptance;

use TestsCodeception\Support\AcceptanceTester;

class Test01_GalleryCest
{
    public function homepageTest(AcceptanceTester $I): void
    {
        $I->wantTo('View gallery');
        $I->amOnPage('/');
        $I->see("Gallery");
        $I->click("Gallery");
        $I->seeCurrentUrlEquals('/gallery');
        $I->see('','li');
        $I->seeNumberOfElements('img', 5);
    }
}
