<?php

namespace TestsCodeception\Acceptance;

use TestsCodeception\Support\AcceptanceTester;

class Test00_HomepageCest
{
    public function homepageTest(AcceptanceTester $I): void
    {
        $I->wantTo('View homepage');

        $I->amOnPage('/');

        $I->seeInTitle('Better than Worst mechanics');

        $I->see("Log in");
        $I->click("Log in");
        $I->seeCurrentUrlEquals('/login');

        $I->amOnPage('/');

        $I->see("Register");
        $I->click("Register");
        $I->seeCurrentUrlEquals('/register');

        $I->amOnPage('/');

        $I->see("Create a request");
        $I->click("Create a request");
        $I->seeCurrentUrlEquals('/login');
    }
}
