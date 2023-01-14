<?php

namespace TestsCodeception\Acceptance;

use TestsCodeception\Support\AcceptanceTester;

class Test03_RegisterCest
{
    public function registerTest(AcceptanceTester $I): void
    {
        $I->wantTo('register new client');
        $I->amOnPage('/');
        $I->click('Register');
        $I->seeCurrentUrlEquals('/register');

        $userName = 'Client test';
        $userEmail = 'clientTest@gmail.com';
        $userPhone = '987654321';

        $I->fillField('name', $userName);
        $I->fillField('email', $userEmail);
        $I->fillField('phone', '123');
        $I->fillField('password', 's');
        $I->fillField('password_confirmation', '');
        $I->click('Register');

        $I->see('The phone must be 9 digits.', 'li');
        $I->see('The password confirmation does not match.', 'li');
        $I->see('The password must be at least 8 characters.', 'li');

        $I->fillField('phone', $userPhone);
        $I->fillField('password', 'secret123');
        $I->fillField('password_confirmation', 'secret123');

        $I->dontSeeInDatabase('users', [
            'name' => $userName,
            'email' => $userEmail,
            'phone' => $userPhone
        ]);

        $I->click('Register');

        $I->seeInDatabase('users', [
            'name' => $userName,
            'email' => $userEmail,
            'phone' => $userPhone
        ]);

        $I->seeCurrentUrlEquals('/dashboard');
        $I->see($userName);
        $I->see("Welcome to");
    }
}
