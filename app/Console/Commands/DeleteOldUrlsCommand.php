<?php

namespace App\Console\Commands;

use App\Models\Url;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;

class DeleteOldUrlsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'urls:remove_old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removing old urls';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     * @throws Exception
     */
    public function handle(): void
    {
        [$days, $urls] = [config('application.url_obsolesce_days'), $urls = Url::query()->cursor()];
        $diff = Carbon::now()->subDays($days);
        /** @var Url $url */
        foreach ($urls as $url) {
            if ($url->created_at->lessThanOrEqualTo($diff)) {
                $url->shares()->delete();
                $url->delete();
                $url->owner()->decrement('short_urls_count');
                event('log:event:oldUrlRemoved', [
                    'url' => $url,
                ]);
            }
        }
    }
}
