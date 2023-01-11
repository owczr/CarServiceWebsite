<?php

namespace TestsCodeception\Acceptance;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use TestsCodeception\Support\AcceptanceTester;

class Test15_Employee_FinishOrderCest
{
    public function ordersTest(AcceptanceTester $I): void
    {
        $I->wantTo('See finish order');

        $I->amOnPage('/login');
        $I->seeCurrentUrlEquals('/login');
        $I->fillField('email', 'employee1@gmail.com');
        $I->fillField('password', 'secret');
        $I->click('Log in');
        $I->seeCurrentUrlEquals('/dashboard');


        $clientID = 2;
        $title = 'moje ohv chce miodu';
        $model = 'fso polonez';
        $description = 'wygodna kanapki mientkie nie trzensie hoho sunie jak diabel po szosie';
        $date = Date::now();
        $status = 1;

        $requestID = $I->haveInDatabase('repair_requests', ['clientID' => $clientID, 'title' => $title,
            'model' => $model, 'description' => $description, 'status' => $status, 'date' => $date]);

        $employeeID = 3;
        $startDatetime = Date::now();
        $estDuration = 2;
        $cost = 49.99;
        $orderID = $I->haveInDatabase('orders', ['requestID' => $requestID, 'employeeID' => $employeeID,
            'startDatetime'=> $startDatetime, 'estDuration' => $estDuration, 'cost' => $cost]);


        $I->amOnPage('/orders');
        $I->seeCurrentUrlEquals('/orders');

        $I->see('#'.$requestID);
        $I->see($title);
        $I->see("Details");
        $I->click("Details");

        $I->seeCurrentUrlEquals('/orders/'.$orderID);

        $client_name = $I->grabColumnFromDatabase('users', 'name', ['id'=>$clientID])[0];
        $client_phone = $I->grabColumnFromDatabase('users', 'phone', ['id'=>$clientID])[0];

        $I->see($client_name);
        $I->see($client_phone);
        $I->see($title);
        $I->see($model);
        $I->see('Accepted');
        $I->see($description);

        $employee_name = $I->grabColumnFromDatabase('users', 'name', ['id'=>$employeeID])[0];

        $I->see($employee_name);
        $I->see((string)$cost);
        $I->see((string)$estDuration);

        $I->seeInDatabase('repair_requests', ['id' => $requestID, 'status' => $status]);

        $I->click('Finish');

        $I->dontSeeInDatabase('repair_requests', ['id' => $requestID, 'status' => $status]);
        $I->seeInDatabase('repair_requests', ['id' => $requestID, 'status' => 4]);

        $I->seeCurrentUrlEquals('/orders/'.$orderID);

        $I->see($client_name);
        $I->see($client_phone);
        $I->see($title);
        $I->see($model);
        $I->see('Closed');
        $I->see($description);

        $employee_name = $I->grabColumnFromDatabase('users', 'name', ['id'=>$employeeID])[0];

        $I->see($employee_name);
        $I->see((string)$cost);
        $I->see((string)$estDuration);
    }
}
