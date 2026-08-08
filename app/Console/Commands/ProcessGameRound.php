<?php

namespace App\Console\Commands;

use App\Models\GameRound;
use App\Services\GameRoundService;
use Illuminate\Console\Command;

class ProcessGameRound extends Command
{
    protected $signature   = 'game:process-round';
    protected $description = 'Process current round result and start new round';

    public function handle(GameRoundService $service): void
    {
        // Current open round nikalo
        $currentRound = GameRound::where('status', 'open')
                                 ->where('ends_at', '<=', now())
                                 ->latest()
                                 ->first();

        if ($currentRound) {
            // Round process karo — result + payout
            $service->processRound($currentRound);
            $this->info('Round #' . $currentRound->id . ' processed!');
        }

        // Koi open round nahi hai toh naya banao
        $openRound = GameRound::where('status', 'open')->first();

        if (!$openRound) {
            $newRound = $service->createNewRound();   
            $this->info('New Round #' . $newRound->id . ' started!');
        }
    }
}