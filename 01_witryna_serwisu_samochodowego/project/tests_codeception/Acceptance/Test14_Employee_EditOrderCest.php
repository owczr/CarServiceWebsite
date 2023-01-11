<?php

namespace TestsCodeception\Acceptance;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use TestsCodeception\Support\AcceptanceTester;

class Test14_Employee_EditOrderCest
{
    public function ordersTest(AcceptanceTester $I): void
    {
        $I->wantTo('Edit order and add images');

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
        $estDuration = 5;
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

        $I->see($title);
        $I->see($model);
        $I->see('Accepted');
        $I->see($description);

        $I->see((string)$cost);
        $I->see((string)$estDuration);

        $I->click('Edit');

        $I->seeCurrentUrlEquals('/orders/'.$orderID.'/edit');

        $client_name = $I->grabColumnFromDatabase('users', 'name', ['id'=>$clientID])[0];
        $client_phone = $I->grabColumnFromDatabase('users', 'phone', ['id'=>$clientID])[0];

        $I->see($client_name);
        $I->see($client_phone);
        $I->see($title);
        $I->see($model);
        $I->see('Accepted');
        $I->see($description);

        $newStartDatetime = '2023-01-20 09:00:00';
        $newDuration = 2;
        $newCost = 99.99;

        $I->fillField('startDatetime', $newStartDatetime);
        $I->fillField('estDuration', $newDuration);
        $I->fillField('cost', $newCost);

        $I->seeElement('input', ['type'=>'file']);
        $I->attachFile('input[type="file"]', 'test_images/test.jpg');

        $I->seeInDatabase('orders', ['requestID' => $requestID, 'employeeID' => $employeeID,
            'startDatetime'=> $startDatetime, 'estDuration' => $estDuration, 'cost' => $cost]);

        $I->click('Update');

        $I->seeCurrentUrlEquals('/orders/'.$orderID);

        $I->dontSeeInDatabase('orders', ['requestID' => $requestID, 'employeeID' => $employeeID,
            'startDatetime'=> $startDatetime, 'estDuration' => $estDuration, 'cost' => $cost]);

        $I->seeInDatabase('orders', ['requestID' => $requestID, 'employeeID' => $employeeID,
            'startDatetime'=> $newStartDatetime, 'estDuration' => $newDuration, 'cost' => $newCost]);

        $I->see((string)$newCost);
        $I->see((string)$newDuration);

        $inserted_images = $I->grabColumnFromDatabase('orders', 'images', ['id' => $orderID])[0];

        foreach (explode('|', $inserted_images) as $image) {
            if ($image != "") {
                $I->seeInSource($image);
                $I->seeElement('img', ['alt'=>explode('/', $image)[1]]);
            }
        }

        $I->seeNumberOfElements('img', 1);

        $I->click('Edit');

        $I->seeCurrentUrlEquals('/orders/'.$orderID.'/edit');

        $I->seeElement('input', ['type'=>'file']);
        $I->attachFile('input[type="file"]', 'test_images/test.jpg');

        $I->click('Update');

        $I->seeCurrentUrlEquals('/orders/'.$orderID);

        $inserted_images = $I->grabColumnFromDatabase('orders', 'images', ['id' => $orderID])[0];

        foreach (explode('|', $inserted_images) as $image) {
            if ($image != "") {
                $I->seeInSource($image);
                $I->seeElement('img', ['alt'=>explode('/', $image)[1]]);
            }
        }

        $I->seeNumberOfElements('img', 2);
    }
}
