<?php
namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use WxHotel\Http\Controllers\Console\OrderManageController;

class ClosePower extends Job implements SelfHandling, ShouldQueue
{
    public function handle($goods_name)
    {
        $obj = new OrderManageController();
        $job = ($obj->close_power($goods_name))-delay(600);
        $this->dispatch($job);
    }
}