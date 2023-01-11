<?php

namespace TestsCodeception\Acceptance;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use TestsCodeception\Support\AcceptanceTester;

class Test13_Employee_ShowOrdersCest
{
    public function ordersTest(AcceptanceTester $I): void
    {
        $I->wantTo('See all my orders');

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

        $id_of_waiting_request = $I->grabColumnFromDatabase('repair_requests', 'id', ['status' => 0])[0];

        $I->amOnPage('/orders');
        $I->seeCurrentUrlEquals('/orders');

        $I->dontSee('#'.$id_of_waiting_request);
        $I->see('#'.$requestID);
        $I->see($title);
        $I->see("Details");
        $I->click("Details");

        $I->seeCurrentUrlEquals('/orders/'.$orderID);

        $I->seeInDatabase('repair_requests', ['clientID' => $clientID, 'title' => $title,
            'model' => $model, 'description' => $description, 'status' => $status]);

        $client_name = $I->grabColumnFromDatabase('users', 'name', ['id'=>$clientID])[0];
        $client_phone = $I->grabColumnFromDatabase('users', 'phone', ['id'=>$clientID])[0];

        $I->see($client_name);
        $I->see($client_phone);
        $I->see($title);
        $I->see($model);
        $I->dontSee('Waiting');
        $I->see('Accepted');
        $I->dontSee('Returned');
        $I->dontSee('Rejected');
        $I->dontSee('Closed');
        $I->see($description);

        $employee_name = $I->grabColumnFromDatabase('users', 'name', ['id'=>$employeeID])[0];

        $I->see($employee_name);
        $I->see((string)$cost);
        $I->see((string)$estDuration);

        $I->see('Edit');
        $I->see('Finish');
    }
}
