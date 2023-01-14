<?php

namespace TestsCodeception\Acceptance;

use TestsCodeception\Support\AcceptanceTester;

class Test21_Employee_DashboardCest
{
    public function dashboardTest(AcceptanceTester $I): void
    {
        $I->wantTo("See my (employee's) dashboard page");

        $I->amOnPage('/login');
        $I->seeCurrentUrlEquals('/login');
        $I->fillField('email', 'employee1@gmail.com');
        $I->fillField('password', 'secret');
        $I->click('Log in');
        $I->seeCurrentUrlEquals('/dashboard');

        $I->see("List of requests");
        $I->click("List of requests");
        $I->seeCurrentUrlEquals('/requests');
        $I->see('List of all waiting requests');

        $I->amOnPage('/dashboard');

        $I->see("My orders");
        $I->click("My orders");
        $I->seeCurrentUrlEquals('/orders');
        $I->see('List of all my orders');

        $I->amOnPage('/dashboard');

        $I->see("Calendar");
        $I->click("Calendar");
        $I->seeCurrentUrlEquals('/orders/calendar');
        $I->see('Calendar');
    }
}
