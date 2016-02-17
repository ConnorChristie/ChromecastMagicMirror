<?php
namespace TestCase\View\Helper;

use App\View\Helper\NavigationHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

class NavigationHelperTest extends TestCase
{
    /**
     * Setup the helper
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $View = new View();
        $this->Navigation = new NavigationHelper($View);
    }

    /**
     * Test the menu
     *
     * @return void
     */
    public function testMenu()
    {
        $navItems = [
            [
                'title' => 'Tab 1',
                'href' => '/',
                'active' => true
            ],
            [
                'title' => 'Tab 2',
                'href' => '/tab2',
                'active' => false
            ]
        ];

        $html = '<ul class="nav navbar-nav"><li class="active"><a href="/">Tab 1</a></li><li class=""><a href="/tab2">Tab 2</a></li></ul>';

        $result = $this->Navigation->menu($navItems);

        $this->assertEquals($html, $result);
    }
}
