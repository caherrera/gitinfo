<?php


namespace GitInfo\Bash;


use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class Local extends Bash {

	private $process;

	public function run( $cmd = null ) {
		return $this->exec( $cmd );
	}

	public function exec( $cmd = null, &$sterr = null ) {
		$process = new Process( $cmd ?? $this->getCmd() );
		$this->setProcess( $process );

		try {
			$process->mustRun();

			$this->setStdio( $process->getOutput() );
		} catch ( ProcessFailedException $exception ) {
			$this->setSterr( $sterr = $exception->getMessage() );
		}


		return $this->getStdio();

	}

	public function isFail() {
		return ! $this->isSuccess();
	}

	public function isSuccess() {
		return $this->getProcess()->isSuccessful();

	}

	/**
	 * @return mixed
	 */
	public function getProcess() {
		return $this->process;
	}

	/**
	 * @param mixed $process
	 *
	 * @return Local
	 */
	public function setProcess( $process ) {
		$this->process = $process;

		return $this;
	}
}
