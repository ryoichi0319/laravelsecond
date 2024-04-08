<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
class SampleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $user;
    public function __construct(User $user)
    {
        //
        $this->user = $user;

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $sufix = '[Job]';
    
        // $userプロパティがnullでないことを確認し、Userモデルのインスタンスであることを確認します
        if ($this->user instanceof User && strpos($this->user->name, $sufix) === false) {
            dd($this->user); // この行を追加して、$this->userが正しいインスタンスであるかを確認する
            $this->user->name .= $sufix;
            $this->user->save();
        }
}}