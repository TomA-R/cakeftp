<?php
App::uses('FtpSocket', 'Ftp.Lib');

/**
 * FtpSocket Test
 *
 * @package cakeftp
 * @author Kyle Robinson Young <kyle at dontkry.com>
 * @copyright 2012 Kyle Robinson Young
 */
class FtpSocketTest extends CakeTestCase {

/**
 * Valid test config data
 *
 * @var array
 */
	protected $_config = array(
		'host'		=> 'ftp.secureftp-test.com',
		'username'	=> 'test',
		'password'	=> 'test',
	);

/**
 * Invalid test config data
 *
 * @var array
 */
	protected $_badConfig = array(
		'host'		=> '1.1.1.1000', // Invalid IP
		'username'	=> 'anonymous',
		'password'	=> 'anonymous',
	);

/**
 * setUp
 */
	public function setUp() {
		parent::setUp();
		$this->Ftp = new FtpSocket($this->_config);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		parent::tearDown();
		unset($this->Ftp);
	}

/**
 * testConfig
 */
	public function testConfig() {
		$result = count($this->Ftp->config);
		$this->assertEquals(11, $result);
	}

/**
 * testConnect
 */
	public function testConnect() {
		$result = $this->Ftp->connect()->connected;
		$this->assertTrue($result);
	}

/**
 * testLogin
 */
	public function testLogin() {
		$result = $this->Ftp->login()->responses;
		$this->assertContains('220 Please visit http://sourceforge.net/projects/filezilla/', current($result));
	}

/**
 * testNoConnection
 */
	public function testNoConnection() {
		$this->setExpectedException('SocketException');
		$ftp = new FtpSocket($this->_badConfig);
		$ftp->connect()->connected;
	}
}
