<?php
namespace App\Test\TestCase\Controller;

use Cake\Core\Configure;
use Cake\TestSuite\IntegrationTestCase;

/**
 * SettingsControllerTest class
 */
class SettingsControllerTest extends IntegrationTestCase
{
    /**
     * Tests the display of the settings page
     *
     * @return void
     */
    public function testDisplay()
    {
        $this->get('/settings');
        $this->assertResponseOk();
        $this->assertResponseContains('Magic Mirror');
        $this->assertResponseContains('<html>');
        $this->assertResponseContains('<form');
    }
}
