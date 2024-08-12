<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Models\User;
use App\Notifications\OrderCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class SendOrderCreatedNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event): void
    {

       //$store = $event->order->store;
       $order = $event->order;
      // dd($order);

       $user = User::where('store_id', $order->store_id)->first();
       if ($user) {
           $user->notify(new OrderCreatedNotification($order));
       }
     // dd($user);

//        $user = User::find(1); // The user you want to notify
// $order = order::find(1); // The order object

      // $user?? $user->notify(new OrderCreatedNotification($order));


        //دي لو هبعت نوتفيكشن لكذا يوزر
      // $users=User::where('store_id',$order->store_id)->get();
      // Notification::send($users,new OrderCreatedNotification($order));
    }
}
