<?php

namespace TestsCodeception\Acceptance;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use TestsCodeception\Support\AcceptanceTester;

class Test10_Employee_AcceptRepairRequestsCest
{
    public function requestedRepairsTest(AcceptanceTester $I): void
    {
        $I->wantTo('Accept repair request');

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


        $I->click('Accept');

        $I->seeCurrentUrlEquals('/requests/'.$requestID.'/accept_request');

        $client_name = $I->grabColumnFromDatabase('users', 'name', ['id'=>$clientID])[0];
        $I->see($client_name);
        $I->see($title);
        $I->see($model);
        $I->see('Waiting');
        $I->see($description);

        $startDatetime = '2023-01-20 12:00:00';
        $duration = 2;
        $cost = 80.00;
        $I->fillField('startDatetime', $startDatetime);
        $I->fillField('estDuration', $duration);
        $I->fillField('cost', $cost);

        $I->dontSeeInDatabase('orders', ['requestID' => $requestID]);

        $I->click('Accept');

        $I->seeInDatabase('orders', ['requestID' => $requestID]);
        $orderID = $I->grabColumnFromDatabase('orders', 'id', ['requestID' => $requestID])[0];

        $I->seeCurrentUrlEquals('/orders/'.$orderID);

        $employee_name = $I->grabColumnFromDatabase('users', 'name', ['id' => $employeeID])[0];

        $I->see($client_name);
        $I->see($title);
        $I->see($model);
        $I->see('Accepted');
        $I->see($description);
        $I->see($employee_name);
        $I->see((string)$cost);
        $I->see((string)$duration);

        $I->see('Edit');
        $I->see('Finish');
    }
}
