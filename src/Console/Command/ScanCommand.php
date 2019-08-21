<?php


namespace GitInfo\Console\Command;


use GitInfo\GitInfo;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\LogicException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ScanCommand extends Command {
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'git:info';

    protected function configure() {
        $this
            ->addArgument( 'path', InputArgument::REQUIRED, 'Folder to Scan' );

    }

    protected function execute( InputInterface $input, OutputInterface $output ) {
        $path = $input->getArgument( 'path' );
        if ( ! is_dir( $path ) ) {
            throw new LogicException( "Folder '$path' does not exists" );
        }
        $gitinfo = new GitInfo( realpath( $path ) );
        $json    = $gitinfo->toJson();
        $output->write( $json );
    }
}
