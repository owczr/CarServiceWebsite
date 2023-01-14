<?php

namespace TestsCodeception\Acceptance;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use TestsCodeception\Support\AcceptanceTester;

class Test18_Admin_ShowAllEmployeesCest
{
    public function employeesTest(AcceptanceTester $I): void
    {
        $I->wantTo('See list of employees');

        $I->amOnPage('/login');
        $I->seeCurrentUrlEquals('/login');
        $I->fillField('email', 'admin@gmail.com');
        $I->fillField('password', 'secret');
        $I->click('Log in');
        $I->seeCurrentUrlEquals('/dashboard');


        $I->amOnPage('/employees');
        $I->seeCurrentUrlEquals('/employees');

        $I->see('List of employees');

        $I->see('#Id');
        $I->see('Name');
        $I->see('Email');
        $I->see('Phone');

        $allEmployees_ids = $I->grabColumnFromDatabase('users', 'id', ['type'=>2]);

        $I->seeNumberOfElements('tr', count($allEmployees_ids)+1); # +1 because of header

        if (!empty($allEmployees_ids)) {
            $employeeID = end($allEmployees_ids);
            $I->see("Details");
            $I->click("Details");
            $I->seeCurrentUrlEquals('/employees/' . $employeeID);
            $I->amOnPage('/employees');
        }

        foreach ($allEmployees_ids as $id) {
            $employee_name = $I->grabColumnFromDatabase('users', 'name', ['id'=>$id])[0];
            $employee_email = $I->grabColumnFromDatabase('users', 'email', ['id'=>$id])[0];
            $employee_phone = $I->grabColumnFromDatabase('users', 'phone', ['id'=>$id])[0];
            $I->see($employee_name);
            $I->see($employee_email);
            $I->see($employee_phone);
        }

        $I->click('Add new employee');
        $I->seeCurrentUrlEquals('/employees/create');
    }
}
