<?php

namespace TestsCodeception\Acceptance;

use TestsCodeception\Support\AcceptanceTester;

class Test25_Admin_ThreeEmployeesListCest
{
    public function threeEmployeesListTest(AcceptanceTester $I): void
    {
        $I->wantTo('See 3 employees on a list');

        $I->amOnPage('/login');
        $I->seeCurrentUrlEquals('/login');
        $I->fillField('email', 'admin@gmail.com');
        $I->fillField('password', 'secret');
        $I->click('Log in');
        $I->seeCurrentUrlEquals('/dashboard');

        $id1 = 11;
        $name1 = 'Employee 11';
        $email1 = 'employee11@gmail.com';
        $password1 = 'qwerty123';
        $type1 = 2;
        $phone1 = '420420421';

        $id2 = 12;
        $name2 = 'Employee 12nth';
        $email2 = 'employee12@gmail.com';
        $password2 = 'qwerty123';
        $type2 = 2;
        $phone2 = '420420422';

        $id3 = 13;
        $name3 = 'Employee 13';
        $email3 = 'employee13@gmail.com';
        $password3 = 'qwerty123';
        $type3 = 2;
        $phone3 = '420420423';

        $user1ID = $I->haveInDatabase('users', ['id' => $id1, 'name' => $name1,
            'email' => $email1, 'password' => $password1, 'type' => $type1, 'phone' => $phone1]);

        $user2ID = $I->haveInDatabase('users', ['id' => $id2, 'name' => $name2,
            'email' => $email2, 'password' => $password2, 'type' => $type2, 'phone' => $phone2]);

        $user3ID = $I->haveInDatabase('users', ['id' => $id3, 'name' => $name3,
            'email' => $email3, 'password' => $password3, 'type' => $type3, 'phone' => $phone3]);

        $I->amOnPage('/employees');
        $I->seeCurrentUrlEquals('/employees');

        $I->see((string)$id1);
        $I->see($name1);
        $I->see($email1);
        $I->see($phone1);

        $I->see((string)$id2);
        $I->see($name2);
        $I->see($email2);
        $I->see($phone2);

        $I->see((string)$id3);
        $I->see($name3);
        $I->see($email3);
        $I->see($phone3);
    }
}
