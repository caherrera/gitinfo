<?php

use mysql_xdevapi\Executable;
use PHPUnit\Framework\TestCase;

class GetInfoTest extends TestCase {

    protected $tempdir;

    public function scanTest() {
        $t             = sys_get_temp_dir();
        $this->tempdir = $t . '/gitinfo';
        mkdir( $this->tempdir );
        $cmd = [
            "mkdir " . $this->tempdir,
            "cd " . $this->tempdir,
            "git init",
            "touch empty",
            "git add . ",
            "git commit -m \"TEST\" -q"
        ];
        exec( join( ' && ', $cmd ) );

        exec('');


    }


}
