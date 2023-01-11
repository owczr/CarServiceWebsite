<?php

namespace TestsCodeception\Acceptance;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use TestsCodeception\Support\AcceptanceTester;

class Test16_Admin_ShowAllRequestsCest
{
    public function requestedRepairsTest(AcceptanceTester $I): void
    {
        $I->wantTo('See my all request/orders of all users');

        $I->amOnPage('/login');
        $I->seeCurrentUrlEquals('/login');
        $I->fillField('email', 'admin@gmail.com');
        $I->fillField('password', 'secret');
        $I->click('Log in');
        $I->seeCurrentUrlEquals('/dashboard');


        $clientID = 2;
        $title = 'moje ohv chce miodu';
        $model = 'fso polonez';
        $description = 'wygodna kanapki mientkie nie trzensie hoho sunie jak diabel po szosie';
        $date = Date::now();
        $status = 1;
        $images = 'images/image1.jpg|images/image2.jpg|';

        $requestID = $I->haveInDatabase('repair_requests', ['clientID' => $clientID, 'title' => $title,
            'model' => $model, 'description' => $description, 'status' => $status, 'date' => $date, 'images' => $images]);

        $employeeID = 3;
        $startDatetime = Date::now();
        $estDuration = 2;
        $cost = 49.99;
        $employee_images = 'images/image1.jpg|images/image2.jpg|';
        $orderID = $I->haveInDatabase('orders', ['requestID' => $requestID, 'employeeID' => $employeeID,
            'startDatetime'=> $startDatetime, 'estDuration' => $estDuration, 'cost' => $cost, 'images' => $employee_images]);


        $I->amOnPage('/requests');
        $I->seeCurrentUrlEquals('/requests');

        $all_ids = $I->grabColumnFromDatabase('repair_requests', 'id');
        $I->seeNumberOfElements('tr', count($all_ids)+1); # +1 because of header
        $I->see($title);
        $I->see("Details");
        $I->click("Details");

        $I->seeCurrentUrlEquals('/requests/'.$requestID);

        $I->seeInDatabase('repair_requests', ['clientID' => $clientID, 'title' => $title,
            'model' => $model, 'description' => $description, 'status' => $status, 'images' => $images]);

        $client_name = $I->grabColumnFromDatabase('users', 'name', ['id'=>$clientID])[0];
        $client_phone = $I->grabColumnFromDatabase('users', 'phone', ['id'=>$clientID])[0];

        $I->see($client_name);
        $I->see($client_phone);
        $I->see($title);
        $I->see($model);
        $I->see('Accepted');
        $I->see($description);

        foreach (explode('|', $images) as $image) {
            if ($image != "") {
                $I->seeInSource($image);
                $I->seeElement('img', ['alt'=>explode('/', $image)[1]]);
            }
        }

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

        $I->seeNumberOfElements('img', 4);
    }
}
