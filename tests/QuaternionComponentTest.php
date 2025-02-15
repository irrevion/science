<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use irrevion\science\Math\Entities\{NaN, QuaternionComponent};

class QuaternionComponentTest extends TestCase {
	public function testCreateI() {
		$i = new QuaternionComponent(1);
		$this->assertSame("$i", '1i');
	}

	public function testCreateK() {
		$k = new QuaternionComponent(2, 'k');
		$this->assertSame("$k", '2k');
	}

	public function testCreateJ() {
		$j = new QuaternionComponent(-3, 'j');
		$this->assertSame("$j", '-3j');
	}

	public function testCreateM() {
		$this->expectExceptionMessage('Only i, j, k basis symbols allowed');
		$m = new QuaternionComponent(-12.45, 'm');
	}

	public function testCreateNan() {
		$this->expectExceptionMessage('Invalid argument type');
		$n = new QuaternionComponent(new NaN);
	}
}
?>