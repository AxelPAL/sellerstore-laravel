<?php

namespace App\Console\Commands;

use App\Models\Plati;
use Illuminate\Console\Command;

class ParseStatistics extends Command
{
    /**
     * @var string
     */
    protected $signature = 'app:parse-statistics';

    /**
     * @var string
     */
    protected $description = 'Parsing data for footer statistics';

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
        $this->plati->getStatistics();
        return 0;
    }
}
