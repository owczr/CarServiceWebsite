<?php

namespace TestsCodeception\Acceptance;

use TestsCodeception\Support\AcceptanceTester;

class Test20_User_DashboardCest
{
    public function dashboardTest(AcceptanceTester $I): void
    {
        $I->wantTo("See my (user's) dashboard page");

        $I->amOnPage('/login');
        $I->seeCurrentUrlEquals('/login');
        $I->fillField('email', 'client1@gmail.com');
        $I->fillField('password', 'secret');
        $I->click('Log in');
        $I->seeCurrentUrlEquals('/dashboard');

        $I->see("Welcome to");

        $I->see("Requests & Orders");
        $I->click("Requests & Orders");
        $I->seeCurrentUrlEquals('/requests');
        $I->see('List of all services');
    }
}
