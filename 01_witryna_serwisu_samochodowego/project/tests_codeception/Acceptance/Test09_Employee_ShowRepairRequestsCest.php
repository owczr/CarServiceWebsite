<?php

namespace TestsCodeception\Acceptance;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use TestsCodeception\Support\AcceptanceTester;

class Test09_Employee_ShowRepairRequestsCest
{
    public function requestedRepairsTest(AcceptanceTester $I): void
    {
        $I->wantTo('See my all waiting requests and its details');

        $I->amOnPage('/login');
        $I->seeCurrentUrlEquals('/login');
        $I->fillField('email', 'employee1@gmail.com');
        $I->fillField('password', 'secret');
        $I->click('Log in');
        $I->seeCurrentUrlEquals('/dashboard');


        $clientID = 2;
        $title = 'example title';
        $model = 'fso polonez';
        $description = 'lorem ipsum';
        $status = 0;
        $images = 'images/image1.jpg|images/image2.jpg|';

        $id = $I->haveInDatabase('repair_requests', ['clientID' => $clientID, 'title' => $title,
            'model' => $model, 'description' => $description, 'status' => $status, 'images' => $images]);

        $title_of_accepted = 'accepted request';
        $I->haveInDatabase('repair_requests', ['clientID' => $clientID, 'title' => $title_of_accepted,
            'model' => 'passat', 'description' => 'everything', 'status' => 1]);

        $I->amOnPage('/requests');
        $I->seeCurrentUrlEquals('/requests');

        $I->see($title);
        $I->dontSee($title_of_accepted);
        $I->see("Details");
        $I->click("Details");

        $I->seeCurrentUrlEquals('/requests/'.$id);

        $I->seeInDatabase('repair_requests', ['clientID' => $clientID, 'title' => $title,
            'model' => $model, 'description' => $description, 'status' => $status, 'images' => $images]);

        $client_name = $I->grabColumnFromDatabase('users', 'name', ['id'=>$clientID])[0];
        $client_phone = $I->grabColumnFromDatabase('users', 'phone', ['id'=>$clientID])[0];

        $I->see($client_name);
        $I->see($client_phone);
        $I->see($title);
        $I->see($model);
        $I->see('Waiting');
        $I->dontSee('Accepted');
        $I->dontSee('Returned');
        $I->dontSee('Rejected');
        $I->dontSee('Closed');
        $I->see($description);

        foreach (explode('|', $images) as $image) {
            if ($image != "") {
                $I->seeInSource($image);
                $I->seeElement('img', ['alt'=>explode('/', $image)[1]]);
            }
        }

        $I->see('Accept');
        $I->see('Reject');
        $I->see('Respond with new date');
    }
}
