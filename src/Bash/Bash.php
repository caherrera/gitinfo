<?php


namespace GitInfo\Bash;


use Illuminate\Support\Collection;

Abstract class Bash {

	public $sterr;
	public $stdio;
	public $cmd;

	public function setCmd( $cmd ) {
		if ( $cmd instanceof Collection ) {
			$this->cmd = $cmd->implode( ';' );
		} elseif ( is_array( $cmd ) ) {
			$this->cmd = implode( ';', $cmd );
		} elseif ( is_string( $cmd ) ) {
			$this->cmd = $cmd;
		}

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getCmd() {
		return $this->cmd;
	}

	/**
	 * @return mixed
	 */
	public function getSterr() {
		return $this->sterr;
	}

	/**
	 * @param mixed $sterr
	 *
	 * @return Bash
	 */
	public function setSterr( $sterr ) {
		$this->sterr = $sterr;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getStdio() {
		return $this->stdio;
	}

	/**
	 * @param mixed $stdio
	 *
	 * @return Bash
	 */
	public function setStdio( $stdio ) {
		$this->stdio = $stdio;

		return $this;
	}

	abstract public function exec( $cmd, &$sterr = null );

	abstract public function run( $cmd = null );

	abstract public function isFail();

	abstract public function isSuccess();

}