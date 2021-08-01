<?php

namespace App\Console\Commands;

use App\Models\HomePageItems;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use PHPHtmlParser\Exceptions\ChildNotFoundException;
use PHPHtmlParser\Exceptions\CircularException;
use PHPHtmlParser\Exceptions\CurlException;
use PHPHtmlParser\Exceptions\NotLoadedException;
use PHPHtmlParser\Exceptions\StrictException;

class ParseHomePage extends Command
{
    /**
     * @var string
     */
    protected $signature = 'app:parse-home-page';

    /**
     * @var string
     */
    protected $description = 'Parsing data for Home Page';

    private HomePageItems $homePageItems;

    /**
     * @return void
     */
    public function __construct(HomePageItems $homePageItems)
    {
        parent::__construct();
        $this->homePageItems = $homePageItems;
    }

    /**
     * @return int
     * @throws GuzzleException
     * @throws ChildNotFoundException
     * @throws CircularException
     * @throws CurlException
     * @throws NotLoadedException
     * @throws StrictException
     */
    public function handle(): int
    {
        $this->homePageItems->parseHomeItems();
        echo 'Home Items have been parsed' . PHP_EOL;
        $this->homePageItems->parsePopularCategories();
        echo 'Popular Categories have been parsed' . PHP_EOL;
        return 0;
    }
}
