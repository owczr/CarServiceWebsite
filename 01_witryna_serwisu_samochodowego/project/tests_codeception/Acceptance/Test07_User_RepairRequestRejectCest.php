<?php

namespace TestsCodeception\Acceptance;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use TestsCodeception\Support\AcceptanceTester;

class Test07_User_RepairRequestRejectCest
{
    public function requestedRepairsTest(AcceptanceTester $I): void
    {
        $I->wantTo('Reject returned request');

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

        $I->seeInDatabase('repair_requests', ['id' => $id, 'status' => $status]);

        $I->see($title);
        $I->see($model);
        $I->see($description);
        $I->see("Returned");

        $I->click("Reject");

        $I->seeCurrentUrlEquals('/requests');

        $I->seeInDatabase('repair_requests', ['id' => $id, 'status' => 3]);

        $I->see($title);
        $I->see("Rejected");
        $I->see("Details");
    }
}
