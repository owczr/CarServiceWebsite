<?php

namespace TestsCodeception\Acceptance;

use TestsCodeception\Support\AcceptanceTester;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Test04_User_AddRepairRequestCest
{
    public function requestRepairTest(AcceptanceTester $I): void
    {
        $I->wantTo('request a repair as a user');

        $I->amOnPage('/login');

        $I->seeCurrentUrlEquals('/login');

        $I->fillField('email', 'client1@gmail.com');
        $I->fillField('password', 'secret');

        $I->click('Log in');

        $I->seeCurrentUrlEquals('/dashboard');

        $I->amOnPage('/requests');
        $I->seeCurrentUrlEquals('/requests');

        $I->click('Create new request...');
        $I->seeCurrentUrlEquals('/requests/create');

        $title = 'zajebista fura';
        $model = 'civic honda';
        $description = 'drzwi do gory sie podnosza przod pare centymetrow ty szczur sie nie przecisnie';
        $date = '2023-02-02';
        $I->fillField('title', $title);
        $I->fillField('model', $model);
        $I->fillField('description', $description);
        $I->fillField('date', $date);

        $I->seeElement('input', ['type'=>'file']);
        $I->attachFile('input[type="file"]', 'test_images/test.jpg');
        $I->see('Create');

        $I->dontSeeInDatabase('repair_requests', ['title' => $title,
            'model' => $model, 'description' => $description]);

        $I->click('Create');

        $I->seeInDatabase('repair_requests', ['title' => $title,
            'model' => $model, 'description' => $description, 'date'=>$date]);

        $inserted_images = $I->grabColumnFromDatabase('repair_requests', 'images', ['title' => $title,
            'model' => $model, 'description' => $description, 'date'=>$date])[0];

        $I->see($title);
        $I->see($model);
        $I->see($description);

        foreach (explode('|', $inserted_images) as $image) {
            if ($image != "") {
                $I->seeInSource($image);
                $I->seeElement('img', ['alt'=>explode('/', $image)[1]]);
            }
        }
    }
}
