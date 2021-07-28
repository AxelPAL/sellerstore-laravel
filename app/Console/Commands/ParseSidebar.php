<?php

namespace App\Console\Commands;

use App\Models\Plati;
use Illuminate\Console\Command;

class ParseSidebar extends Command
{
    /**
     * @var string
     */
    protected $signature = 'app:parse-sidebar';

    /**
     * @var string
     */
    protected $description = 'Parsing data for Sidebar';

    /**
     * @return void
     */
    public function __construct(public Plati $plati)
    {
        parent::__construct();
    }

    /**
     * @return int
     */
    public function handle(): int
    {
        $this->plati->getSidebar();
        return 0;
    }
}
