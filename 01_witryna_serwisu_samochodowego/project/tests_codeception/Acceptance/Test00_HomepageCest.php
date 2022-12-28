<?php

namespace TestsCodeception\Acceptance;

use TestsCodeception\Support\AcceptanceTester;

class Test00_HomepageCest
{
    public function homepageTest(AcceptanceTester $I): void
    {
        $I->wantTo('see Laravel links on homepage');

        $I->amOnPage('/');

        $I->seeInTitle('Warsztat u chłopaków z baraków');

        $I->seeLink("Create a request", "https://laravel.com/docs");
        $I->seeLink("Prizes", "https://laracasts.com");
        $I->seeLink("stuff", "https://forge.laravel.com");
    }
}
