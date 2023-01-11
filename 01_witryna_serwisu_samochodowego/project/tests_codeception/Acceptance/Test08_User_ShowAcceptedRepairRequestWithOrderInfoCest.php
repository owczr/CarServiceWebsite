<?php

namespace TestsCodeception\Acceptance;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use TestsCodeception\Support\AcceptanceTester;

class Test08_User_ShowAcceptedRepairRequestWithOrderInfoCest
{
    public function requestedRepairsTest(AcceptanceTester $I): void
    {
        $I->wantTo('See my requested repairs and its details');

        $I->amOnPage('/login');
        $I->seeCurrentUrlEquals('/login');
        $I->fillField('email', 'client1@gmail.com');
        $I->fillField('password', 'secret');
        $I->click('Log in');
        $I->seeCurrentUrlEquals('/dashboard');


        $clientID = 2;
        $title = 'moje ohv chce miodu';
        $model = 'fso polonez';
        $description = 'wygodna kanapki mientkie nie trzensie hoho sunie jak diabel po szosie';
        $date = Date::now();
        $status = 1;
        $user_images = 'images/image1.jpg|images/image2.jpg|';

        $requestID = $I->haveInDatabase('repair_requests', ['clientID' => $clientID, 'title' => $title,
            'model' => $model, 'description' => $description, 'status' => $status, 'date' => $date, 'images' => $user_images]);

        $employeeID = 3;
        $startDatetime = Date::now();
        $estDuration = 2;
        $cost = 49.99;
        $employee_images = 'images/image3.jpg|images/image4.jpg|';
        $orderID = $I->haveInDatabase('orders', ['requestID' => $requestID, 'employeeID' => $employeeID,
            'startDatetime'=> $startDatetime, 'estDuration' => $estDuration, 'cost' => $cost,'images' => $employee_images]);

        $I->amOnPage('/requests');
        $I->seeCurrentUrlEquals('/requests');

        $I->see("Details");
        $I->click("Details");

        $I->seeCurrentUrlEquals('/requests/'.$requestID);

        $I->seeInDatabase('repair_requests', ['clientID' => $clientID, 'title' => $title,
            'model' => $model, 'description' => $description, 'status' => $status, 'date' => $date, 'images' => $user_images]);

        $client_name = $I->grabColumnFromDatabase('users', 'name', ['id'=>$clientID])[0];

        $I->see($client_name);
        $I->see($title);
        $I->see($model);
        $I->see($description);

        foreach (explode('|', $user_images) as $image) {
            if ($image != "") {
                $I->seeInSource($image);
                $I->seeElement('img', ['alt'=>explode('/', $image)[1]]);
            }
        }

        $I->seeInDatabase('orders', ['requestID' => $requestID, 'employeeID' => $employeeID,
            'startDatetime'=> $startDatetime, 'estDuration' => $estDuration, 'cost' => $cost,'images' => $employee_images]);
        $employee_name = $I->grabColumnFromDatabase('users', 'name', ['id'=>$employeeID])[0];
        $employee_phone = $I->grabColumnFromDatabase('users', 'phone', ['id'=>$employeeID])[0];

        $I->see($employee_name);
        $I->see($employee_phone);
        $I->see((string)$cost);
        $I->see((string)$estDuration);

        foreach (explode('|', $employee_images) as $image) {
            if ($image != "") {
                $I->seeInSource($image);
                $I->seeElement('img', ['alt'=>explode('/', $image)[1]]);
            }
        }
    }
}
