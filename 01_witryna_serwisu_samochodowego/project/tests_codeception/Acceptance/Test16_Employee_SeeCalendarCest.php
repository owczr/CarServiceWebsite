<?php

namespace TestsCodeception\Acceptance;

use TestsCodeception\Support\AcceptanceTester;
use Illuminate\Support\Facades\Date;

class Test16_Employee_SeeCalendarCest
{
    public function ordersTest(AcceptanceTester $I): void
    {
        $I->wantTo('See my personal calendar for current week');

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
        $date = '2023-01-20';
        $status = 1;

        $requestID = $I->haveInDatabase('repair_requests', ['clientID' => $clientID, 'title' => $title,
            'model' => $model, 'description' => $description, 'status' => $status, 'date' => $date]);

        $employeeID = 3;
        $startDatetime = '2023-01-20 10:00';
        $estDuration = 3;
        $cost = 49.99;
        $orderID = $I->haveInDatabase('orders', ['requestID' => $requestID, 'employeeID' => $employeeID,
            'startDatetime'=> $startDatetime, 'estDuration' => $estDuration, 'cost' => $cost]);


        $I->amOnPage('/orders/calendar');
        $I->seeCurrentUrlEquals('/orders/calendar');


        $client_name = $I->grabColumnFromDatabase('users', 'name', ['id'=>$clientID])[0];

        $I->seeElement('div', ['id'=>'calendar']);

        $I->seeElement('script');
        $I->seeInSource($title.' for '.$client_name);
        $I->seeInSource('"start":"'.$startDatetime.':00"');
        $I->seeInSource('"id":'.$requestID);
        $I->seeInSource((string)$orderID);
        $I->seeInSource('calendar.render();');
    }
}
