<?php

namespace TestsCodeception\Acceptance;

use TestsCodeception\Support\AcceptanceTester;

class Test26_Admin_EmployeeDetailsCest
{
    public function employeeDetailsTest(AcceptanceTester $I): void
    {
        $I->wantTo('See employee details');

        $I->amOnPage('/login');
        $I->seeCurrentUrlEquals('/login');
        $I->fillField('email', 'admin@gmail.com');
        $I->fillField('password', 'secret');
        $I->click('Log in');
        $I->seeCurrentUrlEquals('/dashboard');

        $id = 420;
        $name = 'Employee of the month';
        $email = 'employee_of_the_month@gmail.com';
        $password = 'qwerty123';
        $type = 2;
        $phone = '420420420';

        $I->haveInDatabase('users', ['id' => $id, 'name' => $name,
            'email' => $email, 'password' => $password, 'type' => $type, 'phone' => $phone]);

        $I->amOnPage('/employees');
        $I->seeCurrentUrlEquals('/employees');

        $I->see('Details');
        $I->click('Details');

        $I->seeCurrentUrlEquals('/employees/'.$id);

        $I->see((string)$id);
        $I->see($name);
        $I->see($email);
        $I->see($phone);
    }
}
