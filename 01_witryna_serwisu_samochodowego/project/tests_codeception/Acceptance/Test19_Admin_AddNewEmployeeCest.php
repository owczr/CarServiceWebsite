<?php

namespace TestsCodeception\Acceptance;

use TestsCodeception\Support\AcceptanceTester;

class Test19_Admin_AddNewEmployeeCest
{
    public function employeesTest(AcceptanceTester $I): void
    {
        $I->wantTo('Add new employee');

        $I->amOnPage('/login');
        $I->seeCurrentUrlEquals('/login');
        $I->fillField('email', 'admin@gmail.com');
        $I->fillField('password', 'secret');
        $I->click('Log in');
        $I->seeCurrentUrlEquals('/dashboard');

        $I->amOnPage('/employees');
        $I->seeCurrentUrlEquals('/employees');

        $I->see('List of employees');

        $name = 'Employee 123';
        $email = 'employee123@gmail.com';
        $type = 2;
        $phone = '432199999';
        $password = 'Em432123';

        $I->click('Add new employee');
        $I->seeCurrentUrlEquals('/employees/create');

        $I->dontSeeInDatabase('users', [
            'name' => $name,
            'email' => $email,
            'type' => $type,
            'phone' => $phone
        ]);

        $I->fillField('name', $name);
        $I->fillField('email', $email);
        $I->fillField('phone', $phone);

        $I->click('Create');

        $I->seeInDatabase('users', [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'type' => $type,
            'phone' => $phone
        ]);

        $allEmployees_ids = $I->grabColumnFromDatabase('users', 'id', ['type'=>2]);
        $id = end($allEmployees_ids);

        $I->seeCurrentUrlEquals('/employees/' . $id);
        $I->see('Employee no #'.$id.': '.$name);
        $I->see('Detailed information.');
        $I->see($name);
        $I->see($email);
        $I->see($phone);
    }
}
