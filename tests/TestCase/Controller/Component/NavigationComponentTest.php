<?php
namespace TestCase\Controller\Component;

use App\Controller\Component\NavigationComponent;
use Cake\Controller\ComponentRegistry;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\TestSuite\TestCase;

class NavigationComponentTest extends TestCase
{
    public $component = null;
    public $controller = null;

    /**
     * Setup the component
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $request = new Request();
        $response = new Response();

        $this->controller = $this->getMock(
            'App\Controller\SettingsController',
            null,
            [$request, $response]
        );

        $this->controller->name = 'Settings';

        $registry = new ComponentRegistry($this->controller);
        $this->component = new NavigationComponent($registry);
    }

    /**
     * Test the before render method
     *
     * @return void
     */
    public function testBeforeRender()
    {
        NavigationComponent::addTab('Settings', '/');
        NavigationComponent::addTab('Tab 2', '/tab2');

        $this->component->addToController($this->controller);
        $result = $this->controller->viewVars['navigation']['tabs'];

        $this->assertEquals([
            [
                'title' => 'Settings',
                'href' => '/',
                'active' => true
            ],
            [
                'title' => 'Tab 2',
                'href' => '/tab2',
                'active' => false
            ]
        ], $result);
    }

    /**
     * Clean up
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();

        unset($this->component, $this->controller);
    }
}
