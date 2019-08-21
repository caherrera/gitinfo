<?php


namespace GitInfo;

use GitInfo\Bash\Local;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;

class GitInfo implements Jsonable {


    protected $console;
    protected $path;
    /**
     * @var Collection
     */
    protected $gitInfo;

    public function __construct( $path, $console = null ) {
        $this->setPath( $path )->setConsole( $console )->setGitInfo( collect( [] ) );

    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param int $options
     *
     * @return string
     */
    public function toJson( $options = 0 ) {
        return $this->getGitInfo()->toJson( $options );
    }

    /**
     * @return Collection
     */
    public function getGitInfo(): Collection {
        if ( $this->gitInfo->isEmpty() ) {
            $this->scan();
        }

        return $this->gitInfo;
    }

    /**
     * @param Collection $gitInfo
     *
     * @return GitInfo
     */
    public function setGitInfo( Collection $gitInfo ): GitInfo {
        $this->gitInfo = $gitInfo;

        return $this;
    }

    public function scan() {
        $item    = $this->getPath();
        $console = $this->getConsole();

        if ( is_dir( "$item/.git" ) ) {
            $git        = "git -C $item";
            $basename   = $console->exec( "basename $item" );
            $git_status = collect( explode( "\n", $console->exec( "$git status -s" ) ) )->filter()->map( function ( $info ) {
                $c = explode( " ", $info );

                return [ 'file' => $c[1], 'status' => $c[0] ];
            } );
            $git_remote = $console->exec( "$git remote -v | grep fetch | awk '{print $2}'" );
            $git_branch = $console->exec( "$git branch | grep '*' | awk '{print $2}'" );
            $git_tag    = collect( explode( ", ", $console->exec( "$git log --format='%D' -1 --tags" ) ) )
                ->map( function ( $r ) {
                    return explode( ":", $r );
                } )->filter( function ( $r ) {
                    return $r[0] === 'tag';
                } )->map( function ( $ref ) {
                    return trim( $ref[1] );
                } )->first();

            $info     = 'commit=%H|hash=%h|created=%at|author=%an|email=%ae';
            $git_info = $console->exec( "$git log --format='$info' -1" );
            $git_info = collect( explode( "|", $git_info ) )->map( function ( $info ) {
                $c = explode( "=", $info );

                return [ $c[0] => $c[1] ];
            } )->reduce( function ( $cur, $info ) {
                return array_merge( $cur, $info );
            }, [] );

            $git_info['repository'] = $git_remote;
            $git_info['status']     = $git_status;
            $git_info['branch']     = $git_branch;
            $git_info['tag']        = $git_tag;
            $git_info['created']    = gmdate( 'Y-m-d H:j:s', $git_info['created'] );
            $git_info['project']    = $basename;

            $git_info = collect( $git_info );


            $this->setGitInfo( $git_info->map( function ( $i ) {
                return trim( $i );
            } ) );

        }


    }

    /**
     * @return mixed
     */
    public function getPath() {
        return $this->path;
    }

    /**
     * @param mixed $path
     *
     * @return GitInfo
     */
    public function setPath( $path ) {
        $this->path = $path;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getConsole() {
        if ( $this->console === null ) {
            $this->console = new Local();
        }

        return $this->console;
    }

    /**
     * @param mixed $console
     *
     * @return GitInfo
     */
    public function setConsole( $console ) {
        $this->console = $console;

        return $this;
    }
}
