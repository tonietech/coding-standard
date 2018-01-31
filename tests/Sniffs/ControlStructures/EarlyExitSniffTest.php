<?php declare(strict_types = 1);

namespace SlevomatCodingStandard\Sniffs\ControlStructures;

class EarlyExitSniffTest extends \SlevomatCodingStandard\Sniffs\TestCase
{

	public function testNoErrors(): void
	{
		$report = $this->checkFile(__DIR__ . '/data/earlyExitNoErrors.php');
		$this->assertNoSniffErrorInFile($report);
	}

	public function testErrors(): void
	{
		$report = $this->checkFile(__DIR__ . '/data/earlyExitErrors.php', [], [EarlyExitSniff::CODE_EARLY_EXIT_NOT_USED]);

		$this->assertSame(18, $report->getErrorCount());

		foreach ([6, 15, 24, 33, 42, 50, 58, 66, 74, 82, 90, 98, 108] as $line) {
			$this->assertSniffError($report, $line, EarlyExitSniff::CODE_EARLY_EXIT_NOT_USED, 'Use early exit instead of else.');
		}

		foreach ([115, 122, 129, 135, 141] as $line) {
			$this->assertSniffError($report, $line, EarlyExitSniff::CODE_EARLY_EXIT_NOT_USED, 'Use early exit to reduce code nesting.');
		}

		$this->assertAllFixedInFile($report);
	}

}