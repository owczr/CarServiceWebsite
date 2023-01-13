<?php

namespace TestsCodeception\Acceptance;

use TestsCodeception\Support\AcceptanceTester;

class Test00_HomepageCest
{
    public function homepageTest(AcceptanceTester $I): void
    {
        $I->wantTo('see Laravel links on homepage');

        $I->amOnPage('/');

        $I->seeInTitle('Better than Worst mechanics!');

        $I->seeLink("Create a request", "route('reguests')");
    }
}
