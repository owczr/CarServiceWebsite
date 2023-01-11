<?php

namespace TestsCodeception\Acceptance;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use TestsCodeception\Support\AcceptanceTester;

class Test06_User_RepairRequestAcceptCest
{
    public function requestedRepairsTest(AcceptanceTester $I): void
    {
        $I->wantTo('Accept or reject returned request');

        $I->amOnPage('/login');
        $I->seeCurrentUrlEquals('/login');
        $I->fillField('email', 'client1@gmail.com');
        $I->fillField('password', 'secret');
        $I->click('Log in');
        $I->seeCurrentUrlEquals('/dashboard');


        $clientID = 2;
        $title = 'example title';
        $model = 'passerati';
        $description = 'lorem ipsum';
        $date = Date::now();
        $status = 2;

        $id = $I->haveInDatabase('repair_requests', ['clientID' => $clientID, 'title' => $title,
            'model' => $model, 'description' => $description, 'date' => $date, 'status' => $status]);

        $I->amOnPage('/requests');
        $I->seeCurrentUrlEquals('/requests');

        $I->see("Returned");
        $I->see("Details");
        $I->click("Details");

        $I->seeCurrentUrlEquals('/requests/'.$id);

        $I->seeInDatabase('repair_requests', ['title' => $title,
            'model' => $model, 'description' => $description, 'status' => $status]);

        $I->see($title);
        $I->see($model);
        $I->see($description);
        $I->see("Returned");

        $I->click("Accept new date");

        $I->seeCurrentUrlEquals('/requests/'.$id);

        $I->seeInDatabase('repair_requests', ['title' => $title,
            'model' => $model, 'description' => $description, 'status' => 0]);

        $I->see($title);
        $I->see($model);
        $I->see($description);
        $I->see("Waiting");
    }
}
