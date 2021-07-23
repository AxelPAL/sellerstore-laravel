<?php

namespace App\Console\Commands;

use App\Models\HomePageItems;
use Illuminate\Console\Command;

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
     */
    public function handle(): int
    {
        $this->homePageItems->parseHomeItems();
        $this->homePageItems->parsePopularCategories();
        return 0;
    }
}
