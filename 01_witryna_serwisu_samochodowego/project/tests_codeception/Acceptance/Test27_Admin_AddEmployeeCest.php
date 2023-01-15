<?php

namespace TestsCodeception\Acceptance;

use TestsCodeception\Support\AcceptanceTester;

class Test27_Admin_AddEmployeeCest
{
    public function addEmployeeTest(AcceptanceTester $I): void
    {
        $I->wantTo('Add a new employee');

        $I->amOnPage('/login');
        $I->seeCurrentUrlEquals('/login');
        $I->fillField('email', 'admin@gmail.com');
        $I->fillField('password', 'secret');
        $I->click('Log in');
        $I->seeCurrentUrlEquals('/dashboard');

        $name = 'Employee of the month';
        $email = 'employee_of_the_month@gmail.com';
        $type = 2;
        $phone = '420420420';

        $I->dontSeeInDatabase('users', ['name' => $name,
            'email' => $email, 'type' => $type, 'phone' => $phone]);

        $I->amOnPage('/employees');
        $I->seeCurrentUrlEquals('/employees');

        $I->see('Add new employee');
        $I->click('Add new employee');

        $I->seeCurrentUrlEquals('/employees/create');

        $I->fillField('name', $name);
        $I->fillField('email', $email);
        $I->fillField('phone', $phone);

        $I->see('Create');
        $I->click('Create');

        $I->see($name);
        $I->see($email);
        $I->see($phone);

        $I->amOnPage('/employees');

        $I->see($name);
        $I->see($email);
        $I->see($phone);
    }
}
