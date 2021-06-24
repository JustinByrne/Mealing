<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

class WebhookController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $githubPayload = $request->getContent();
        $githubHash = $request->header('X-Hub-Signature');

        $localToken = config('app.webhook_secret');
        $localHash = 'sha1=' . hash_hmac('sha1', $githubPayload, $localToken, false);
        
        if (hash_equals($githubHash, $localHash)) {
            $root_path = base_path();
            $process = new Process([$root_path . '/deploy.sh']);
            
            try {
                $process->run();

                Log::info($process->getOutput());
            } catch (ProcessFailedException $exception) {
                Log::error($exception->getMessage());
            }
        }
    }
}
