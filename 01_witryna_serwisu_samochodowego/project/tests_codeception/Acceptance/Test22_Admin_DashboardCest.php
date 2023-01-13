<?php

namespace TestsCodeception\Acceptance;

use TestsCodeception\Support\AcceptanceTester;

class Test22_Admin_DashboardCest
{
    public function dashboardTest(AcceptanceTester $I): void
    {
        $I->wantTo("See my (admin's) dashboard page");

        $I->amOnPage('/login');
        $I->seeCurrentUrlEquals('/login');
        $I->fillField('email', 'admin@gmail.com');
        $I->fillField('password', 'secret');
        $I->click('Log in');
        $I->seeCurrentUrlEquals('/dashboard');

        $I->see("Requests");
        $I->click("Requests");
        $I->seeCurrentUrlEquals('/requests');
        $I->see('List of all requests');

        $I->amOnPage('/dashboard');

        $I->see("Employees");
        $I->click("Employees");
        $I->seeCurrentUrlEquals('/employees');
        $I->see('List of all my employees');
    }
}
