<?php

namespace TestsCodeception\Acceptance;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use TestsCodeception\Support\AcceptanceTester;

class Test12_Employee_RejectRepairRequestsCest
{
    public function requestedRepairsTest(AcceptanceTester $I): void
    {
        $I->wantTo('Respond repair request');

        $I->amOnPage('/login');
        $I->seeCurrentUrlEquals('/login');
        $I->fillField('email', 'employee1@gmail.com');
        $I->fillField('password', 'secret');
        $I->click('Log in');
        $I->seeCurrentUrlEquals('/dashboard');

        $employeeID = 3;
        $clientID = 2;
        $title = 'example title';
        $model = 'fso polonez';
        $description = 'lorem ipsum';
        $status = 0;

        $requestID = $I->haveInDatabase('repair_requests', ['clientID' => $clientID, 'title' => $title,
            'model' => $model, 'description' => $description, 'status' => $status]);


        $I->amOnPage('/requests');
        $I->seeCurrentUrlEquals('/requests');

        $I->see($title);
        $I->see("Details");
        $I->click("Details");

        $I->seeCurrentUrlEquals('/requests/'.$requestID);

        $I->seeInDatabase('repair_requests', ['clientID' => $clientID, 'title' => $title,
            'model' => $model, 'description' => $description, 'status' => $status]);


        $I->see($title);
        $I->see($model);
        $I->see('Waiting');
        $I->see($description);


        $I->seeInDatabase('repair_requests', ['id' => $requestID, 'status' => 0]);

        $I->click('Reject');

        $I->seeInDatabase('repair_requests', ['id' => $requestID, 'status' => 3]);


        $I->seeCurrentUrlEquals('/requests');

        $I->dontSee('#'.$requestID);
        $I->dontSee($title);
    }
}
