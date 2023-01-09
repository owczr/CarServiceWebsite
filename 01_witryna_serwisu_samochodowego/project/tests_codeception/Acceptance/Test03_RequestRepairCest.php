<?php

namespace TestsCodeception\Acceptance;

use TestsCodeception\Support\AcceptanceTester;

class Test03_RequestRepairCest
{
    public function requestRepairTest(AcceptanceTester $I): void
    {
        $I->wantTo('request a repair as a user');

        $I->amOnPage('/login');

        $I->seeCurrentUrlEquals('/login');

        $I->fillField('email', 'john.doe@gmail.com');
        $I->fillField('password', 'secret');

        $I->click('Log in');

        $I->seeCurrentUrlEquals('/dashboard');

        $I->amOnPage('/requests');
        $I->seeCurrentUrlEquals('/requests');

        $I->click('Create new request...');
        $I->seeCurrentUrlEquals('/requests/create');

        $title = 'zajebista fura';
        $model = 'civic honda';
        $description = 'drzwi do gory sie podnosza przod pare centymetrow ty szczur sie nie przecisnie';
        $I->fillField('title', $title);
        $I->fillField('model', $model);
        $I->fillField('description', $description);

        $I->see('Create');
        $I->click('Create');

        $I->seeInDatabase('repair_requests', ['title' => $title,
            'model' => $model, 'description' => $description]);
    }
}
