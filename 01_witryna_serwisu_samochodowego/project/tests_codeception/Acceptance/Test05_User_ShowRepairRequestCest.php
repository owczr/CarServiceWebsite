<?php

namespace TestsCodeception\Acceptance;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use TestsCodeception\Support\AcceptanceTester;

class Test05_User_ShowRepairRequestCest
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
        $status = 0;
        $images = 'images/image1.jpg|images/image2.jpg|';

        $id = $I->haveInDatabase('repair_requests', ['clientID' => $clientID, 'title' => $title,
            'model' => $model, 'description' => $description, 'status' => $status, 'images' => $images]);

        $I->amOnPage('/requests');
        $I->seeCurrentUrlEquals('/requests');

        $I->see("Details");
        $I->click("Details");

        $I->seeCurrentUrlEquals('/requests/'.$id);

        $I->seeInDatabase('repair_requests', ['title' => $title,
            'model' => $model, 'description' => $description]);

        $client_name = $I->grabColumnFromDatabase('users', 'name', ['id'=>$clientID])[0];

        $I->see($client_name);
        $I->see($title);
        $I->see($model);
        $I->see($description);

        foreach (explode('|', $images) as $image) {
            if ($image != "") {
                $I->seeInSource($image);
                $I->seeElement('img', ['alt'=>explode('/', $image)[1]]);
            }
        }
    }
}
